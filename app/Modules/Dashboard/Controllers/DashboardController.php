<?php
namespace App\Modules\Dashboard\Controllers;

use App\Core\Controller;

class DashboardController extends Controller {

    public function index() {

        $this->auth(); // protección

        $data = [
            'stock' => 8450,
            'activos' => 1250,
            'lowStock' => 32,
            'movimientos' => 156,
            'title' => 'Dashboard'
        ];

        $this->render('Modules/Dashboard/Views/index', $data);
    }
}