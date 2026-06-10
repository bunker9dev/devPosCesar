<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;
use App\Modules\Products\Services\CatalogService;
use App\Services\PermissionService;

class ColorController extends Controller
{
    private $service;
    private $table = 'fabric_colors';
    private $module = 'products';

    public function __construct()
    {
        $this->service = new CatalogService();
    }

    // ======================================================
    // INDEX
    // ======================================================
    // public function index()
    // {
    //     $rolId = $_SESSION['user']['rol_id'] ?? null;

    //     if (!PermissionService::can($rolId, $this->module, 'view')) {
    //         return $this->redirect(BASE_URL);
    //     }

    //     $colors = $this->service->getAll($this->table);

    //     $permissions = PermissionService::getModulePermissions($rolId, $this->module);

    //     $this->render('Modules/Products/Views/products/colors', [
    //         'colors' => $colors,
    //         'canCreate' => $permissions['create'],
    //         'canEdit' => $permissions['edit'],
    //         'canDelete' => $permissions['delete'],
    //         'canRestore' => $permissions['restore'],
    //     ]);
    // }

    public function index()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, $this->module, 'view')) {
            return $this->redirect(BASE_URL);
        }

        // 🔥 MISMA LÓGICA QUE USERS
        $colors = $this->service->getAllForList($this->table, $rolId);

        $permissions = PermissionService::getModulePermissions($rolId, $this->module);

        $this->render('Modules/Products/Views/products/colors', [
            'colors' => $colors,
            'canCreate' => $permissions['create'],
            'canEdit' => $permissions['edit'],
            'canDelete' => $permissions['delete'],
            'canRestore' => $permissions['restore'],
        ]);
    }

    // ======================================================
    // STORE
    // ======================================================
    public function store()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, $this->module, 'create')) {
            return $this->redirect(BASE_URL . "/products/colors");
        }

        try {

            $this->service->create($this->table, $_POST['nombre']);

            $_SESSION['success'] = "Color creado correctamente";
        } catch (\Exception $e) {

            $_SESSION['error'] = $e->getMessage();
        }

        return $this->redirect(BASE_URL . '/products/colors');
    }

    // ======================================================
    // UPDATE
    // ======================================================
    public function update()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, $this->module, 'edit')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            exit;
        }

        header('Content-Type: application/json');

        try {

            $id = $_POST['id'] ?? null;
            $nombre = trim($_POST['nombre'] ?? '');

            if (!$id || !$nombre) {
                throw new \Exception('Datos inválidos');
            }

            $this->service->update($this->table, $id, $nombre);

            echo json_encode([
                'ok' => true,
                'message' => 'Color actualizado'
            ]);
        } catch (\Exception $e) {

            $msg = $e->getMessage();

            if (str_contains($msg, 'Duplicate entry')) {
                $msg = "El nombre ya está registrado";
            }

            echo json_encode([
                'ok' => false,
                'error' => $msg
            ]);
        }

        exit;
    }

    // ======================================================
    // TOGGLE
    // ======================================================
    public function toggle()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, $this->module, 'edit')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            exit;
        }

        header('Content-Type: application/json');

        try {

            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception('ID inválido');
            }

            $estado = $this->service->toggle($this->table, $id);

            echo json_encode([
                'ok' => true,
                'estado' => $estado
            ]);
        } catch (\Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);
        }

        exit;
    }

    // ======================================================
    // DELETE
    // ======================================================
    public function delete()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, $this->module, 'delete')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            exit;
        }

        header('Content-Type: application/json');

        try {

            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception('ID inválido');
            }

            $this->service->delete($this->table, $id);

            echo json_encode([
                'ok' => true,
                'message' => 'Color eliminado'
            ]);
        } catch (\Throwable $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
        }

        exit;
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public function restore()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, $this->module, 'restore')) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            exit;
        }

        header('Content-Type: application/json');

        try {

            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception('ID inválido');
            }

            $this->service->restore($this->table, $id);

            echo json_encode([
                'ok' => true,
                'message' => 'Color restaurado'
            ]);
        } catch (\Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);
        }

        exit;
    }
}
