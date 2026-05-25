<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;
use App\Modules\Products\Repositories\AuditLogRepository;
use App\Modules\Products\Repositories\CatalogRepository;
use App\Modules\Products\Services\CatalogService;

class ProductController extends Controller
{
    private function service()
    {
        global $db;

        return new CatalogService(
            new CatalogRepository($db),
            new AuditLogRepository($db)
        );
    }

    public function index()
    {
        $this->auth();
        $this->onlyAdmin();

        $data = $this->service()->dashboardData();

        $this->render('Modules/Products/Views/products/index', [
            'title' => 'Productos',
            'types' => $data['types'],
            'colors' => $data['colors'],
            'products' => $data['products'],
        ]);
    }

    public function types()
    {
        $this->auth();
        $this->onlyAdmin();

        $data = $this->service()->fabricTypesData();

        $this->render('Modules/Products/Views/products/types', [
            'title' => 'Tipos de tela',
            'types' => $data['types'],
        ]);
    }

    public function colors()
    {
        $this->auth();
        $this->onlyAdmin();

        $data = $this->service()->colorsData();

        $this->render('Modules/Products/Views/products/colors', [
            'title' => 'Colores',
            'colors' => $data['colors'],
        ]);
    }

    public function storeFabricType()
    {
        $this->auth();
        $this->onlyAdmin();

        try {
            $this->service()->createFabricType($_POST);
            $_SESSION['success'] = "Tipo de tela creado";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        return $this->redirect(BASE_URL . "/products/types");
    }

    public function storeColor()
    {
        $this->auth();
        $this->onlyAdmin();

        try {
            $this->service()->createColor($_POST);
            $_SESSION['success'] = "Color creado";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        return $this->redirect(BASE_URL . "/products/colors");
    }
}
