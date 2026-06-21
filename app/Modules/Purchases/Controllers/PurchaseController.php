<?php

namespace App\Modules\Purchases\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Services\PermissionService;
use App\Modules\Purchases\Services\PurchaseService;
use App\Modules\Purchases\Models\PurchaseModel;
use App\Modules\Suppliers\Services\SupplierService;
use App\Modules\Suppliers\Models\Supplier;

class PurchaseController extends Controller
{
    private $service;

    public function __construct()
    {
        $db = Database::getConnection();
        $model = new PurchaseModel($db);
        $this->service = new PurchaseService($model, $db);
    }

    public function index()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'purchases', 'view')) {
            return $this->redirect(BASE_URL . "/dashboard");
        }

        $canViewDeleted = PermissionService::can($rolId, 'purchases', 'view_deleted');

        $purchases = $this->service->getAll($canViewDeleted);

        $this->render('Modules/Purchases/Views/index', [
            'title'             => 'Compras',
            'purchases'         => $purchases,
            'canCreate'         => PermissionService::can($rolId, 'purchases', 'create'),
            'canEdit'           => PermissionService::can($rolId, 'purchases', 'edit'),
            'canDelete'         => PermissionService::can($rolId, 'purchases', 'delete'),
            'canRestore'        => PermissionService::can($rolId, 'purchases', 'restore'),
            'canManagePrice'    => PermissionService::can($rolId, 'purchases', 'manage_price'),
            'canManagePayments' => PermissionService::can($rolId, 'purchases', 'manage_payments'),
        ]);
    }

    public function create()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'purchases', 'create')) {
            return $this->redirect(BASE_URL . "/purchases");
        }

        $supplierOptions = $this->service->getFormOptions();

        $db = Database::getConnection();
        $rollModel = new \App\Modules\Rolls\Models\RollModel($db);

        $this->render('Modules/Purchases/Views/create', [
            'title'        => 'Crear compra',
            'suppliers'    => $supplierOptions['suppliers'],
            'types'        => $rollModel->getActiveFabricTypes(),
            'colors'       => $rollModel->getActiveFabricColors(),
            'warehouses'   => $rollModel->getActiveWarehouses(),
            'canViewPrice' => PermissionService::can($rolId, 'rolls', 'view_price'),
        ]);
    }


    public function store()
{
    header('Content-Type: application/json');

    $rolId = $_SESSION['user']['rol_id'] ?? null;

    if (!PermissionService::can($rolId, 'purchases', 'create')) {
        echo json_encode(['ok' => false, 'error' => 'No autorizado']);
        return;
    }

    $db = Database::getConnection();

    try {
        $lotes = json_decode($_POST['lotes_json'] ?? '[]', true);

        if (!is_array($lotes) || count($lotes) === 0) {
            throw new \Exception("Debes agregar al menos una tela a la compra");
        }

        $canViewPrice = PermissionService::can($rolId, 'rolls', 'view_price');

        // ============================
        // INICIA TRANSACCIÓN
        // ============================
        $db->begin_transaction();

        // 1. CREAR LA CABECERA DE LA COMPRA
        $purchaseId = $this->service->create($_POST, $_SESSION['user']['id'], $canViewPrice);

        // 2. CREAR CADA LOTE (REUTILIZANDO RollService)
        $rollModel = new \App\Modules\Rolls\Models\RollModel($db);
        $rollService = new \App\Modules\Rolls\Services\RollService($rollModel, $db);

        $totalRollosCreados = 0;

        foreach ($lotes as $index => $lote) {
            $loteData = [
                'fabric_type_id'   => $lote['fabric_type_id'] ?? 0,
                'fabric_color_id'  => $lote['fabric_color_id'] ?? 0,
                'supplier_id'      => $_POST['supplier_id'] ?? 0,
                'warehouse_id'     => $lote['warehouse_id'] ?? 0,
                'fecha_compra'     => $_POST['fecha'] ?? '',
                'metraje_inicial'  => $lote['metraje_por_rollo'] ?? 0,
                'cantidad'         => $lote['cantidad'] ?? 1,
                'precio_compra'    => $lote['precio_compra'] ?? '',
                'purchase_id'      => $purchaseId,
                'confirm_merge'    => 1,
            ];

            try {
                $result = $rollService->create($loteData, $_SESSION['user']['id']);
                $totalRollosCreados += count($result['codes']);
            } catch (\Exception $e) {
                // Identifica cuál de los lotes falló, para un mensaje útil
                throw new \Exception("Error en la tela #" . ($index + 1) . ": " . $e->getMessage());
            }
        }

        // ============================
        //  TODO SALIÓ BIEN — CONFIRMA
        // ============================
        $db->commit();

        echo json_encode([
            'ok' => true,
            'purchase_id' => $purchaseId,
            'total_rollos' => $totalRollosCreados,
        ]);

    } catch (\Throwable $e) {
        // ============================
        //  ALGO FALLÓ — DESHACE TODO
        // ============================
        $db->rollback();

        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
    }
}
    public function show()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'purchases', 'view')) {
            return $this->redirect(BASE_URL . "/dashboard");
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            return $this->redirect(BASE_URL . "/purchases");
        }

        try {
            $purchase = $this->service->find($id);
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            return $this->redirect(BASE_URL . "/purchases");
        }

        $this->render('Modules/Purchases/Views/show', [
            'title'             => 'Compra ' . $purchase['numero_documento'],
            'purchase'          => $purchase,
            'canEdit'           => PermissionService::can($rolId, 'purchases', 'edit'),
            'canManagePrice'    => PermissionService::can($rolId, 'purchases', 'manage_price'),
            'canManagePayments' => PermissionService::can($rolId, 'purchases', 'manage_payments'),
        ]);
    }

    public function update()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'purchases', 'edit')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception("ID inválido");
            }

            $this->service->update($id, $_POST, $_SESSION['user']['id']);

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    public function registerPayment()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'purchases', 'manage_payments')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $purchaseId = $_POST['purchase_id'] ?? null;

            if (!$purchaseId) {
                throw new \Exception("ID de compra inválido");
            }

            $result = $this->service->registerPayment($purchaseId, $_POST, $_SESSION['user']['id']);

            echo json_encode(['ok' => true] + $result);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    public function delete()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'purchases', 'delete')) {
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

        if (!PermissionService::can($rolId, 'purchases', 'restore')) {
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
    // ===================================================
    // MOSTRAR CONTEXTO DE COMPRA
    // ==================================================

    public function getBasicInfo()
    {
        header('Content-Type: application/json');

        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo json_encode(['ok' => false, 'error' => 'ID inválido']);
            return;
        }

        try {
            $purchase = $this->service->find($id);

            echo json_encode([
                'ok' => true,
                'purchase' => [
                    'id' => $purchase['id'],
                    'numero_documento' => $purchase['numero_documento'],
                    'supplier_id' => $purchase['supplier_id'],
                    'proveedor_nombre' => $purchase['proveedor_nombre'],
                ],
            ]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }
    // ===================================================
    // CREACIÓN RÁPIDA DE PROVEEDOR (modal, desde el form de compra)
    // ==================================================
    public function quickSupplier()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        // Reutiliza el permiso real de Suppliers — si no puede crear
        // proveedores ahí, tampoco puede hacerlo desde este atajo.
        if (!PermissionService::can($rolId, 'proveedores', 'create')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $db = Database::getConnection();
            $supplierModel = new Supplier($db);
            $supplierService = new SupplierService($supplierModel, $db);

            $_POST['user_id'] = $_SESSION['user']['id'];

            $id = $supplierService->create($_POST);

            echo json_encode([
                'ok' => true,
                'supplier' => [
                    'id' => $id,
                    'nombre' => $_POST['nombre'],
                ],
            ]);
        } catch (\Exception $e) {
            $errors = json_decode($e->getMessage(), true);
            echo json_encode([
                'ok' => false,
                'error' => is_array($errors) ? implode(', ', $errors) : $e->getMessage(),
            ]);
        }
    }
}
