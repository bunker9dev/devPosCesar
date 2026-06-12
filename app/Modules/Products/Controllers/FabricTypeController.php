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


    public function index()
    {
        $types = $this->service->getAll($this->table);

        $this->render('Modules/Products/Views/products/types', [
            'types' => $types,
            'title' => 'Tipos de tela'
        ]);
    }


    public function store()
    {
        try {

            $nombre = trim($_POST['nombre'] ?? '');

            if (!$nombre) {
                throw new \Exception("El nombre es obligatorio");
            }

            $this->service->create($this->table, $nombre);

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

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!Roles::canEdit($rolId)) {
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            exit;
        }

        try {

            $id = $_POST['id'] ?? null;
            $nombre = trim($_POST['nombre'] ?? '');

            if (!$id || !$nombre) {
                throw new \Exception('Datos inválidos');
            }

            $this->service->update($this->table, $id, $nombre);

            echo json_encode([
                'ok' => true,
                'message' => 'Tipo actualizado correctamente'
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

            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception('ID inválido');
            }

            if ($this->service->isUsed($this->table, $id, 'products', 'fabric_type_id')) {
                throw new \Exception("Este tipo de tela está en uso");
            }

            $this->service->delete($this->table, $id);

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

            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception('ID inválido');
            }

            $this->service->restore($this->table, $id);

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
