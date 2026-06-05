<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;
use App\Modules\Products\Services\WarehouseService;

class WarehouseController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->auth();
        $this->onlyAdmin();

        $this->service = new WarehouseService();
    }

    // ======================================================
    // LISTAR
    // ======================================================
    public function index()
    {
        $warehouses = $this->service->getAllWarehouses(true);

        $rol = $_SESSION['user']['rol_nombre'] ?? '';

        $canEdit    = in_array($rol, ['super', 'administrador']);
        $canDelete  = in_array($rol, ['super', 'administrador']);
        $canRestore = ($rol === 'super');

        $this->render('Modules/Products/Views/warehouses/index', [
            'warehouses' => $warehouses,
            'title'      => 'Bodegas',
            'canEdit'    => $canEdit,
            'canDelete'  => $canDelete,
            'canRestore' => $canRestore
        ]);
    }

    // ======================================================
    // CREAR
    // ======================================================
    public function store()
    {
        try {

            $this->service->createWarehouse($_POST);

            $_SESSION['success'] = "Bodega creada correctamente";

        } catch (\Exception $e) {

            $_SESSION['error'] = $e->getMessage();
        }

        return $this->redirect(BASE_URL . "/warehouses");
    }

    // ======================================================
    // ACTUALIZAR
    // ======================================================
    public function update()
    {
        header('Content-Type: application/json');

        try {

            $id = $_POST['id'] ?? null;

            $this->service->updateWarehouse($id, $_POST);

            echo json_encode([
                'success' => true,
                'message' => 'Bodega actualizada'
            ]);

        } catch (\Throwable $e) {

            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        exit;
    }

    // ======================================================
    // DELETE
    // ======================================================
    public function delete()
    {
        header('Content-Type: application/json');

        try {

            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception("ID inválido");
            }

            $this->service->deleteWarehouse($id);

            echo json_encode([
                'ok' => true,
                'message' => 'Bodega eliminada'
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
    //  RESTORE
    // ======================================================
    public function restore()
    {
        header('Content-Type: application/json');

        try {

            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception("ID inválido");
            }

            $this->service->restoreWarehouse($id);

            echo json_encode([
                'ok' => true,
                'message' => 'Bodega restaurada'
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
    // TOGGLE
    // ======================================================
    public function toggle()
    {
        header('Content-Type: application/json');

        try {

            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception("ID inválido");
            }

            $estado = $this->service->toggleWarehouse($id);

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
}