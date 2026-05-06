<?php
namespace App\Modulos\Dashboard\Controllers;

use App\Core\Controller;

class DashboardController extends Controller {

    public function index() {

        $data = [
            'stock' => 8450,
            'activos' => 1250,
            'lowStock' => 32,
            'movimientos' => 156,
            'title' => 'devPosSoho'
        ];

        $this->render('Modulos/Dashboard/Views/index', $data);
    }

//     public function index() {
//     echo "OK CONTROLLER FUNCIONANDO";
//     die();
// }
}