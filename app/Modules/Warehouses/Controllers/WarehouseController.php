<?php

namespace App\Modules\Warehouses\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Services\PermissionService;
use App\Modules\Warehouses\Services\WarehouseService;
use App\Modules\Warehouses\Models\WarehouseModel;

class WarehouseController extends Controller
{
    private $service;

    public function __construct()
    {
        $db = Database::getConnection();

        $model = new WarehouseModel($db);

        $this->service = new WarehouseService($model, $db);
    }

    public function index()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'warehouses', 'view')) {
            return $this->redirect(BASE_URL . "/dashboard");
        }

        $canViewDeleted = PermissionService::can($rolId, 'warehouses', 'view_deleted');

        $warehouses = $this->service->getAll($canViewDeleted);

        $permissions = PermissionService::getModulePermissions($rolId, 'warehouses');

        $this->render('Modules/Warehouses/Views/index', [
            'warehouses' => $warehouses,
            'title'      => 'Bodegas',
            'canCreate'  => $permissions['create'],
            'canEdit'    => $permissions['edit'],
            'canDelete'  => $permissions['delete'],
            'canRestore' => $permissions['restore'],
        ]);
    }

    public function store()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'warehouses', 'create')) {
            $_SESSION['error'] = "No autorizado";
            return $this->redirect(BASE_URL . "/warehouses");
        }

        try {
            $this->service->create($_POST, $_SESSION['user']['id']);
            $_SESSION['success'] = "Bodega creada correctamente";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        return $this->redirect(BASE_URL . "/warehouses");
    }

    public function update()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'warehouses', 'edit')) {
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
        } catch (\Throwable $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    public function delete()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'warehouses', 'delete')) {
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

        if (!PermissionService::can($rolId, 'warehouses', 'restore')) {
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

    public function toggle()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'warehouses', 'edit')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception("ID inválido");
            }

            $estado = $this->service->toggle($id, $_SESSION['user']['id']);

            echo json_encode(['ok' => true, 'estado' => $estado]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }
}