<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;
use App\Modules\Products\Services\FabricTypeService;

class FabricTypeController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->auth();
        $this->onlyAdmin();

        $this->service = new FabricTypeService();
    }

    public function index()
    {
        $types = $this->service->getAll();

        $this->render('Modules/Products/Views/products/types', [
            'types' => $types
        ]);
    }

    public function store()
    {
        try {
            $this->service->create($_POST['nombre']);

            $_SESSION['success'] = "Tipo creado correctamente";

        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: ' . BASE_URL . '/products/types');
    }

    public function delete($id)
    {
        $this->onlyAdmin();

        $this->service->delete($id);

        header('Location: ' . BASE_URL . '/products/types');
    }

    public function restore($id)
    {
        $this->onlySuper();

        $this->service->restore($id);

        header('Location: ' . BASE_URL . '/products/types');
    }
}