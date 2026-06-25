<?php

namespace App\Modules\Purchases\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Services\PermissionService;
use App\Modules\Purchases\Services\PedidoService;
use App\Modules\Purchases\Models\PedidoModel;

class PedidoController extends Controller
{
    private $service;

    public function __construct()
    {
        $db = Database::getConnection();
        $model = new PedidoModel($db);
        $this->service = new PedidoService($model, $db);
    }

    public function index()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'pedidos', 'view')) {
            return $this->redirect(BASE_URL . "/dashboard");
        }

        $canViewDeleted = PermissionService::can($rolId, 'pedidos', 'view_deleted');

        $pedidos = $this->service->getAll($canViewDeleted);

        $this->render('Modules/Purchases/Views/pedidos/index', [
            'title' => 'Pedidos',
            'pedidos' => $pedidos,
            'canCreate' => PermissionService::can($rolId, 'pedidos', 'create'),
            'canEdit' => PermissionService::can($rolId, 'pedidos', 'edit'),
            'canDelete' => PermissionService::can($rolId, 'pedidos', 'delete'),
            'canRestore' => PermissionService::can($rolId, 'pedidos', 'restore'),
        ]);
    }

    public function create()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'pedidos', 'create')) {
            return $this->redirect(BASE_URL . "/pedidos");
        }

        $db = Database::getConnection();
        $rollModel = new \App\Modules\Rolls\Models\RollModel($db);

        $this->render('Modules/Purchases/Views/pedidos/create', [
            'title' => 'Crear pedido',
            'suppliers' => $rollModel->getActiveSuppliers(),
            'types' => $rollModel->getActiveFabricTypes(),
            'colors' => $rollModel->getActiveFabricColors(),
        ]);
    }

    public function store()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'pedidos', 'create')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $items = json_decode($_POST['items_json'] ?? '[]', true);

            $result = $this->service->create($_POST, is_array($items) ? $items : [], $_SESSION['user']['id']);

            echo json_encode(['ok' => true] + $result);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    public function show()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'pedidos', 'view')) {
            return $this->redirect(BASE_URL . "/dashboard");
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            return $this->redirect(BASE_URL . "/pedidos");
        }

        try {
            $pedido = $this->service->find($id);
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return $this->redirect(BASE_URL . "/pedidos");
        }

        $this->render('Modules/Purchases/Views/pedidos/show', [
            'title' => 'Pedido ' . $pedido['consecutivo'],
            'pedido' => $pedido,
            'canEdit' => PermissionService::can($rolId, 'pedidos', 'edit'),
            'canApprove' => PermissionService::can($rolId, 'pedidos', 'approve'),
            'canDelete' => PermissionService::can($rolId, 'pedidos', 'delete'),
        ]);
    }

    public function approve()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'pedidos', 'approve')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception("ID inválido");
            }

            $this->service->approve($id, $_SESSION['user']['id']);

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    public function markAs()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'pedidos', 'edit') && !PermissionService::can($rolId, 'pedidos', 'approve')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $id = $_POST['id'] ?? null;
            $estado = $_POST['estado'] ?? '';

            if (!$id) {
                throw new \Exception("ID inválido");
            }

            $this->service->markAs($id, $estado, $_SESSION['user']['id']);

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }


    public function edit()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'pedidos', 'edit')) {
            return $this->redirect(BASE_URL . "/pedidos");
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            return $this->redirect(BASE_URL . "/pedidos");
        }

        try {
            $pedido = $this->service->find($id);
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return $this->redirect(BASE_URL . "/pedidos");
        }

        if ($pedido['estado'] !== 'borrador') {
            $_SESSION['error'] = "Solo se pueden editar pedidos en estado borrador";
            return $this->redirect(BASE_URL . "/pedidos/show?id=" . $id);
        }

        $db = Database::getConnection();
        $rollModel = new \App\Modules\Rolls\Models\RollModel($db);

        $this->render('Modules/Purchases/Views/pedidos/edit', [
            'title' => 'Editar pedido ' . $pedido['consecutivo'],
            'pedido' => $pedido,
            'suppliers' => $rollModel->getActiveSuppliers(),
            'types' => $rollModel->getActiveFabricTypes(),
            'colors' => $rollModel->getActiveFabricColors(),
        ]);
    }

    public function update()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'pedidos', 'edit')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception("ID inválido");
            }

            $items = json_decode($_POST['items_json'] ?? '[]', true);

            $db = Database::getConnection();

            $this->service->update($id, $_POST, is_array($items) ? $items : [], $_SESSION['user']['id'], $db);

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    public function delete()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'pedidos', 'delete')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception("ID inválido");
            }

            $this->service->delete($id, $_SESSION['user']['id']);

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    public function restore()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'pedidos', 'restore')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception("ID inválido");
            }

            $this->service->restore($id, $_SESSION['user']['id']);

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    // ======================================================
    // PEDIDOS APROBADOS DE UN PROVEEDOR (para vincular en Purchases)
    // ======================================================
    public function aprobadosBySupplier()
    {
        header('Content-Type: application/json');

        $supplierId = $_GET['supplier_id'] ?? null;

        if (!$supplierId) {
            echo json_encode(['ok' => false, 'error' => 'Proveedor inválido']);
            return;
        }

        $pedidos = $this->service->getAprobadosBySupplier($supplierId);

        echo json_encode(['ok' => true, 'pedidos' => $pedidos]);
    }
}
