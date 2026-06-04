<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;
use App\Modules\Products\Services\CatalogService;

class ColorController extends Controller
{
    private $service;
    private $table = 'fabric_colors';

    public function __construct()
    {
        $this->auth();
        $this->onlyAdmin();

        $this->service = new CatalogService();
    }

    public function index()
    {
        $colors = $this->service->getAll($this->table);

        $this->render('Modules/Products/Views/products/colors', [
            'colors' => $colors,
            'title' => 'Colores'
        ]);
    }

    public function store()
    {
        try {
            $this->service->create($this->table, $_POST['nombre']);
            $_SESSION['success'] = "Color creado correctamente";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: ' . BASE_URL . '/products/colors');
    }

    public function delete()
    {
      
        header('Content-Type: application/json');
         

        try {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                echo json_encode(['ok' => false, 'error' => 'ID inválido']);
                exit;
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

    public function restore()
    {
        header('Content-Type: application/json');

        try {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                echo json_encode(['ok' => false, 'error' => 'ID inválido']);
                exit;
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

    public function update()
    {
        header('Content-Type: application/json');

        try {
            $id = $_POST['id'] ?? null;
            $nombre = $_POST['nombre'] ?? '';

            $this->service->update($this->table, $id, $nombre);

            echo json_encode([
                'success' => true,
                'message' => 'Color actualizado'
            ]);

        } catch (\Exception $e) {

            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        exit;
    }
}
