<?php

namespace App\Modules\FabricTypes\Controllers;

use App\Core\Controller;
use App\Services\PermissionService;
use App\Modules\FabricTypes\Services\FabricTypeService;
use App\Modules\FabricTypes\Models\FabricTypeModel;

class FabricTypeController extends Controller
{
    private $service;

    public function __construct()
    {
        $db = conectarDB();

        $model = new FabricTypeModel($db);

        $this->service = new FabricTypeService($model, $db);
    }

    // ======================================================
    // INDEX
    // ======================================================
    public function index()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'fabric_types', 'view')) {
            return $this->redirect(BASE_URL);
        }

        $types = $this->service->getAll();

        $permissions = PermissionService::getModulePermissions($rolId, 'fabric_types');

        $this->render('Modules/FabricTypes/Views/index', [
            'types' => $types,
            'canCreate' => $permissions['create'],
            'canEdit' => $permissions['edit'],
            'canDelete' => $permissions['delete'],
            'canRestore' => $permissions['restore']
        ]);
    }

    // ======================================================
    // CREATE
    // ======================================================
    public function create()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'fabric_types', 'create')) {
            return $this->redirect(BASE_URL . "/fabric-types");
        }

        $permissions = PermissionService::getModulePermissions($rolId, 'fabric_types');

        $this->render('Modules/FabricTypes/Views/create', [
            'canCreate' => $permissions['create']
        ]);
    }

    // ======================================================
    // STORE
    // ======================================================
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect(BASE_URL . "/fabric-types");
        }

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'fabric_types', 'create')) {
            $_SESSION['error'] = "No autorizado";
            return $this->redirect(BASE_URL . "/fabric-types");
        }

        try {
            $this->service->create($_POST, $_SESSION['user']['id']);

            $_SESSION['success'] = "Tipo de tela creado";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        return $this->redirect(BASE_URL . "/fabric-types");
    }

    // ======================================================
    // UPDATE
    // ======================================================
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect(BASE_URL . "/fabric-types");
        }

        try {
            $this->service->update(
                $_POST['id'],
                $_POST,
                $_SESSION['user']['id']
            );

            $_SESSION['success'] = "Actualizado";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        return $this->redirect(BASE_URL . "/fabric-types");
    }

    // ======================================================
    // TOGGLE
    // ======================================================
    public function toggle()
    {
        header('Content-Type: application/json');

        try {
            $estado = $this->service->toggle(
                $_POST['id'],
                $_SESSION['user']['id']
            );

            echo json_encode(['ok' => true, 'estado' => $estado]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    // ======================================================
    // DELETE
    // ======================================================
    public function delete()
    {
        header('Content-Type: application/json');

        try {
            $this->service->delete(
                $_POST['id'],
                $_SESSION['user']['id']
            );

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public function restore()
    {
        header('Content-Type: application/json');

        try {
            $this->service->restore(
                $_POST['id'],
                $_SESSION['user']['id']
            );

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }
}