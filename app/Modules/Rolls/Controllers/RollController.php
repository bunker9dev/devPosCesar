<?php

namespace App\Modules\Rolls\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Services\PermissionService;
use App\Modules\Rolls\Services\RollService;
use App\Modules\Rolls\Models\RollModel;

class RollController extends Controller
{
    private $service;

    public function __construct()
    {
        $db = Database::getConnection();
        $model = new RollModel($db);
        $this->service = new RollService($model, $db);
    }

    public function index()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'rolls', 'view')) {
            return $this->redirect(BASE_URL . "/dashboard");
        }

        $canViewDeleted = PermissionService::can($rolId, 'rolls', 'view_deleted');

        $rolls = $this->service->getAll($canViewDeleted);

        $permissions = PermissionService::getModulePermissions($rolId, 'rolls');

        $this->render('Modules/Rolls/Views/index', [
            'rolls'      => $rolls,
            'canCreate'  => $permissions['create'],
            'canEdit'    => $permissions['edit'],
            'canDelete'  => $permissions['delete'],
            'canRestore' => $permissions['restore'],
        ]);
    }

    public function create()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'rolls', 'create')) {
            return $this->redirect(BASE_URL . "/rolls");
        }

        $options = $this->service->getFormOptions();

        $this->render('Modules/Rolls/Views/create', [
            'types'      => $options['types'],
            'colors'     => $options['colors'],
            'suppliers'  => $options['suppliers'],
            'warehouses' => $options['warehouses'],
        ]);
    }

    public function store()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'rolls', 'create')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        try {
            $result = $this->service->create($_POST, $_SESSION['user']['id']);

            if ($result['conflict']) {
                echo json_encode([
                    'ok'       => false,
                    'conflict' => true,
                    'message'  => $result['message'],
                    'lote_id'  => $result['lote_id'],
                ]);
                return;
            }

            echo json_encode([
                'ok'          => true,
                'lote_codigo' => $result['lote_codigo'],
                'codes'       => $result['codes'],
            ]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    public function update()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'rolls', 'edit')) {
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

    public function delete()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'rolls', 'delete')) {
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

        if (!PermissionService::can($rolId, 'rolls', 'restore')) {
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
}