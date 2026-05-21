<?php

namespace App\Modules\Suppliers\Controllers;

use App\Core\Controller;
use App\Modules\Suppliers\Services\SupplierService;
use App\Modules\Suppliers\Models\Supplier;

class SupplierController extends Controller
{
    private $service;
    private $model;

    public function __construct()
    {
        global $db;

        $this->model = new Supplier($db);
        $this->service = new SupplierService($this->model, $db);
    }

    public function index()
    {
        $this->auth();
        $this->onlyAdmin();

        $isSuper = ($_SESSION['user']['rol'] == 1);

        $suppliers = $this->service->getAll($isSuper);

        $this->render('Modules/Suppliers/Views/index', [
            'suppliers' => $suppliers,
            'isSuper' => $isSuper
        ]);
    }

    public function create()
    {
        $this->auth();
        $this->onlyAdmin();

        $isSuper = ($_SESSION['user']['rol'] == 1);

        $this->render('Modules/Suppliers/Views/create', [
            'isSuper' => $isSuper
        ]);
    }

    public function store()
    {
        $this->auth();
        $this->onlyAdmin();

        try {
            $_POST['user_id'] = $_SESSION['user']['id'];
            $this->service->create($_POST);

            $_SESSION['success'] = "Proveedor creado";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        return $this->redirect(BASE_URL . "/suppliers");
    }

    public function edit($id)
    {
        $this->auth();
        $this->onlyAdmin();

        $supplier = $this->model->find($id);

        if (!$supplier) return $this->redirect(BASE_URL . "/suppliers");

        $isSuper = ($_SESSION['user']['rol'] == 1);

        $this->render('Modules/Suppliers/Views/edit', [
            'supplier' => $supplier,
            'isSuper' => $isSuper
        ]);
    }

    public function update($id)
    {
        $this->auth();
        $this->onlyAdmin();

        try {
            $_POST['user_id'] = $_SESSION['user']['id'];
            $this->service->update($id, $_POST);

            $_SESSION['success'] = "Proveedor actualizado";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        return $this->redirect(BASE_URL . "/suppliers");
    }

    public function toggle()
    {
        header('Content-Type: application/json');

        try {
            $estado = $this->service->toggle(
                $_POST['id'],
                $_SESSION['user']['id']
            );

            echo json_encode(['ok' => true, 'estado' => $estado]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false]);
        }
    }

    public function delete()
    {
        header('Content-Type: application/json');

        try {
            $this->service->delete($_POST['id'], $_SESSION['user']['id']);
            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false]);
        }
    }

    public function restore()
    {
        header('Content-Type: application/json');

        try {
            $this->service->restore($_POST['id'], $_SESSION['user']['id']);
            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false]);
        }
    }

    // public function checkNit()
    // {
    //     header('Content-Type: application/json');

    //     $nit = $_GET['nit'] ?? '';

    //     if (!$nit) {
    //         echo json_encode(['exists' => false]);
    //         return;
    //     }

    //     $exists = $this->model->existsByNit($nit);

    //     echo json_encode(['exists' => $exists]);
    // }

    public function checkNit()
    {
        header('Content-Type: application/json');

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $nit = $_GET['nit'] ?? '';

        $exists = $this->model->existsByNit($nit);

        echo json_encode(['exists' => $exists]);
    }
}
