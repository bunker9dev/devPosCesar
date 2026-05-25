<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;
use App\Modules\Products\Repositories\PurchaseRepository;
use App\Modules\Products\Services\PurchaseService;

class PurchaseController extends Controller
{
    public function index()
    {
        $this->auth();
        $this->onlyAdmin();

        global $db;

        $data = (new PurchaseService(new PurchaseRepository($db)))->indexData();

        $this->render('Modules/Products/Views/purchases/index', [
            'title' => 'Compras',
            'purchases' => $data['purchases'],
        ]);
    }
}
