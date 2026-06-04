<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;
use App\Core\Roles;
use App\Core\Status;
use App\Modules\Products\Services\CatalogService;

class FabricTypeController extends Controller
{
    private $service;
    private $table = 'fabric_types';

    public function __construct()
    {
        $this->auth();
        $this->onlyAdmin();

        $this->service = new CatalogService();
    }

    // ======================================================
    // INDEX
    // ======================================================
    public function index()
    {
        $types = $this->service->getAll($this->table);

        $this->render('Modules/Products/Views/products/types', [
            'types' => $types,
            'title' => 'Tipos de tela'
        ]);
    }

    // ======================================================
    // STORE
    // ======================================================
    public function store()
    {
        try {

            $this->service->create($this->table, $_POST['nombre']);

            $_SESSION['success'] = "Tipo creado correctamente";

        } catch (\Exception $e) {

            $_SESSION['error'] = $e->getMessage();
        }

        $this->redirect(BASE_URL . '/products/types');
    }

    // ======================================================
    // UPDATE
    // ======================================================
    public function update()
    {
        header('Content-Type: application/json');

        try {

            $this->service->update(
                $this->table,
                $_POST['id'],
                $_POST['nombre']
            );

            echo json_encode([
                'success' => true,
                'message' => 'Tipo actualizado correctamente'
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
    // TOGGLE (🔥 NUEVO)
    // ======================================================
    public function toggle()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!Roles::canEdit($rolId)) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            exit;
        }

        try {

            $estado = $this->service->toggle($this->table, $_POST['id']);

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
    // DELETE (SIMPLIFICADO)
    // ======================================================
    public function delete()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!Roles::canDelete($rolId)) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            exit;
        }

        try {

            // 🔥 VALIDAR USO
            if ($this->service->isUsed($this->table, $_POST['id'], 'products', 'fabric_type_id')) {
                throw new \Exception("Este tipo de tela está en uso");
            }

            $this->service->delete($this->table, $_POST['id']);

            echo json_encode([
                'ok' => true,
                'message' => 'Tipo eliminado correctamente'
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
    // RESTORE
    // ======================================================
    public function restore()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!Roles::canRestore($rolId)) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            exit;
        }

        try {

            $this->service->restore($this->table, $_POST['id']);

            echo json_encode([
                'ok' => true,
                'message' => 'Registro restaurado correctamente'
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