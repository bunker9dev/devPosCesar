<?php

namespace App\Modules\Suppliers\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Services\PermissionService;
use App\Modules\Suppliers\Services\SupplierService;
use App\Modules\Suppliers\Models\Supplier;

class SupplierController extends Controller
{
    private $service;

    public function __construct()
    {
        $db = Database::getConnection();
        $model = new Supplier($db);
        $this->service = new SupplierService($model, $db);
    }

    public function index()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'proveedores', 'view')) {
            return $this->redirect(BASE_URL . "/dashboard");
        }

        $canViewDeleted = PermissionService::can($rolId, 'proveedores', 'view_deleted');

        $suppliers = $this->service->getAll($canViewDeleted);

        $permissions = PermissionService::getModulePermissions($rolId, 'proveedores');

        $this->render('Modules/Suppliers/Views/index', [
            'suppliers'  => $suppliers,
            'canCreate'  => $permissions['create'],
            'canEdit'    => $permissions['edit'],
            'canDelete'  => $permissions['delete'],
            'canRestore' => $permissions['restore'],
        ]);
    }

    public function create()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'proveedores', 'create')) {
            return $this->redirect(BASE_URL . "/suppliers");
        }

        $this->render('Modules/Suppliers/Views/create');
    }

    public function store()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'proveedores', 'create')) {
            $_SESSION['error'] = "No autorizado";
            return $this->redirect(BASE_URL . "/suppliers");
        }

        try {
            $_POST['user_id'] = $_SESSION['user']['id'];

            $this->service->create($_POST);

            $_SESSION['success'] = "Proveedor creado";
            return $this->redirect(BASE_URL . "/suppliers");

        } catch (\Exception $e) {

            $errors = json_decode($e->getMessage(), true);

            $_SESSION['errors'] = $errors ?: ['general' => $e->getMessage()];
            $_SESSION['old'] = $_POST;

            return $this->redirect(BASE_URL . "/suppliers/create");
        }
    }

    public function edit()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'proveedores', 'edit')) {
            return $this->redirect(BASE_URL . "/suppliers");
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            return $this->redirect(BASE_URL . "/suppliers");
        }

        $supplier = $this->service->find($id);

        if (!$supplier) {
            return $this->redirect(BASE_URL . "/suppliers");
        }

        $this->render('Modules/Suppliers/Views/edit', compact('supplier'));
    }

    public function update()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'proveedores', 'edit')) {
            $_SESSION['errors'] = ['general' => 'No autorizado'];
            return $this->redirect(BASE_URL . "/suppliers");
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $_SESSION['errors'] = ['general' => 'ID no proporcionado'];
            return $this->redirect(BASE_URL . "/suppliers");
        }

        try {
            $_POST['user_id'] = $_SESSION['user']['id'];

            $this->service->update($id, $_POST);

            $_SESSION['success'] = "Proveedor actualizado";
            return $this->redirect(BASE_URL . "/suppliers");

        } catch (\Exception $e) {

            $errors = json_decode($e->getMessage(), true);

            $_SESSION['errors'] = $errors ?: ['general' => $e->getMessage()];
            $_SESSION['old'] = $_POST;

            return $this->redirect(BASE_URL . "/suppliers/edit?id=" . $id);
        }
    }

    public function toggle()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'proveedores', 'edit')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo json_encode(['ok' => false, 'error' => 'ID inválido']);
            return;
        }

        try {
            $estado = $this->service->toggle($id, $_SESSION['user']['id']);

            echo json_encode(['ok' => true, 'estado' => $estado]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    public function delete()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'proveedores', 'delete')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo json_encode(['ok' => false, 'error' => 'ID inválido']);
            return;
        }

        try {
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

        if (!PermissionService::can($rolId, 'proveedores', 'restore')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo json_encode(['ok' => false, 'error' => 'ID inválido']);
            return;
        }

        try {
            $this->service->restore($id, $_SESSION['user']['id']);
            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    public function checkNit()
    {
        header('Content-Type: application/json');

        try {
            $nit = $_POST['nit'] ?? '';
            $excludeId = $_POST['id'] ?? null;

            if (!$nit) {
                echo json_encode(['ok' => true, 'exists' => false]);
                return;
            }

            $exists = $this->service->existsByNit($nit, $excludeId);

            echo json_encode(['ok' => true, 'exists' => $exists]);

        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'exists' => false]);
        }
    }
}