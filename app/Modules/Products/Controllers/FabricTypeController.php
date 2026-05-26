<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;
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
            $this->service->create($this->table, $_POST['nombre']);
            $_SESSION['success'] = "Tipo creado correctamente";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: ' . BASE_URL . '/products/types');
    }

    public function delete($id)
    {
        $this->service->delete($this->table, $id);

        header('Location: ' . BASE_URL . '/products/types');
    }

    public function restore($id)
    {
        $this->onlySuper();

        $this->service->restore($this->table, $id);

        header('Location: ' . BASE_URL . '/products/types');
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $this->redirect(BASE_URL . '/products/types');
        }

        $type = $this->service->find($this->table, $id);

        $this->render('Modules/Products/Views/products/edit-type', [
            'type' => $type,
            'title' => 'Editar tipo de tela'
        ]);
    }



public function update()
{
    header('Content-Type: application/json'); // 🔥 CLAVE

    try {

        $id = $_POST['id'] ?? null;
        $nombre = $_POST['nombre'] ?? '';

        if (!$id) {
            throw new \Exception("ID inválido");
        }

        $this->service->update($this->table, $id, $nombre);

        echo json_encode([
            'success' => true,
            'message' => 'Tipo actualizado correctamente'
        ]);

    } catch (\Throwable $e) { // 🔥 mejor que Exception

        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }

    exit; // 🔥 OBLIGATORIO
}
}
