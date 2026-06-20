<?php

namespace App\Modules\Colors\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Services\PermissionService;
use App\Modules\Colors\Services\ColorService;
use App\Modules\Colors\Models\ColorModel;

class ColorController extends Controller
{
    private $service;

    public function __construct()
    {
        $db = Database::getConnection();

        $model = new ColorModel($db);

        $this->service = new ColorService($model, $db);
    }

    public function index()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'fabric_colors', 'view')) {
            return $this->redirect(BASE_URL . "/dashboard");
        }

        $canViewDeleted = PermissionService::can($rolId, 'fabric_colors', 'view_deleted');

        $colors = $this->service->getAll($canViewDeleted);

        $permissions = PermissionService::getModulePermissions($rolId, 'fabric_colors');

        $this->render('Modules/Colors/Views/index', [
            'title' => 'Colores',
            'colors' => $colors,
            'canCreate' => $permissions['create'],
            'canEdit' => $permissions['edit'],
            'canDelete' => $permissions['delete'],
            'canRestore' => $permissions['restore'],
        ]);
    }

    public function store()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'fabric_colors', 'create')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $id = $this->service->create($_POST, $_SESSION['user']['id']);

            $_SESSION['success'] = "Color creado";

            echo json_encode(['ok' => true, 'id' => $id]);
        } catch (\Throwable $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    public function update()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'fabric_colors', 'edit')) {
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

    public function toggle()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'fabric_colors', 'edit')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $estado = $this->service->toggle($_POST['id'], $_SESSION['user']['id']);

            echo json_encode(['ok' => true, 'estado' => $estado]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    public function delete()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'fabric_colors', 'delete')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $this->service->delete($_POST['id'], $_SESSION['user']['id']);

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    public function restore()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'fabric_colors', 'restore')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $this->service->restore($_POST['id'], $_SESSION['user']['id']);

            $_SESSION['success'] = "Color restaurado";

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }
}
