<?php

namespace App\Modules\Suppliers\Controllers;

use App\Core\Controller;
use App\Modules\Suppliers\Services\SupplierService;

class SupplierController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new SupplierService();
    }

    public function index()
    {
        $this->auth();
        $this->onlyAdmin();

        $isSuper = ($_SESSION['user']['rol'] == 1);

        $suppliers = $this->service->getAll($isSuper);

        $this->render('Modules/Suppliers/Views/index', [
            'suppliers' => $suppliers,
            'title' => 'Proveedores'
        ]);
    }

    public function store()
    {
        $this->auth();
        $this->onlyAdmin();

        $data = [
            'nombre' => $_POST['nombre'],
            'apellidos' => $_POST['apellidos'],
            'ciudad' => $_POST['ciudad'],
            'telefono' => $_POST['telefono'],
            'user_id' => $_SESSION['user']['id']
        ];

        $id = $this->service->create($data);

        auditoria("CREATE", "proveedores", $id, "Proveedor creado", "suppliers");

        $_SESSION['success'] = "Proveedor creado";

        return $this->redirect(BASE_URL . "/suppliers");
    }

    public function toggle()
    {
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json');

        $id = $_POST['id'];

        $estado = $this->service->toggle($id);

        echo json_encode([
            'ok' => true,
            'estado' => $estado
        ]);
    }

    public function create()
    {
        $this->auth();
        $this->onlyAdmin();

        $this->render('Modules/Suppliers/Views/create', [
            'title' => 'Crear proveedor'
        ]);
    }
}
