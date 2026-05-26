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
}