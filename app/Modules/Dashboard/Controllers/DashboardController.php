<?php
namespace App\Modules\Dashboard\Controllers;

use App\Core\Controller;

class DashboardController extends Controller {

    public function index() {

        // 🔐 Validación 
        if(!isset($_SESSION['user'])){
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $data = [
            'stock' => 8450,
            'activos' => 1250,
            'lowStock' => 32,
            'movimientos' => 156,
            'title' => 'devPosSoho'
        ];


        $this->render('Modules/Dashboard/Views/index', $data);
    }

}