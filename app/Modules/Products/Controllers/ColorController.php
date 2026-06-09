<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;
use App\Core\Roles;
use App\Modules\Products\Services\CatalogService;

class ColorController extends Controller
{
    private $service;
    private $table = 'fabric_colors';

    public function __construct()
    {
        $this->service = new CatalogService();
    }

    // ======================================================
    // LISTADO
    // ======================================================
    public function index()
    {
        $this->auth();

        $rolId = $_SESSION['user']['rol_id'] ?? null;
        $isSuper = $rolId === Roles::SUPER;

        $colors = $this->service->getAll($this->table, $isSuper);

        $this->render('Modules/Products/Views/products/colors', [
            'colors' => $colors,
            'title' => 'Colores'
        ]);
    }

    // ======================================================
    // STORE
    // ======================================================
    public function store()
    {
        $this->auth();

        try {
            $this->service->create($this->table, $_POST['nombre']);

            $_SESSION['success'] = "Color creado correctamente";

        } catch (\Exception $e) {

            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: ' . BASE_URL . '/products/colors');
        exit;
    }

    // ======================================================
    // DELETE
    // ======================================================
    public function delete()
    {
        $this->auth();

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
        $this->auth();

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

    // ======================================================
    // UPDATE
    // ======================================================
    public function update()
    {
        $this->auth();

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

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);
        }

        exit;
    }
}