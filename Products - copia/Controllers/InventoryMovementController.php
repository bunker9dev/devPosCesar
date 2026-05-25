<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;
use App\Modules\Products\Repositories\AuditLogRepository;
use App\Modules\Products\Repositories\CatalogRepository;
use App\Modules\Products\Repositories\InventoryMovementRepository;
use App\Modules\Products\Repositories\RollRepository;
use App\Modules\Products\Services\InventoryMovementService;

class InventoryMovementController extends Controller
{
    private function service()
    {
        global $db;

        return new InventoryMovementService(
            $db,
            new RollRepository($db),
            new InventoryMovementRepository($db),
            new CatalogRepository($db),
            new AuditLogRepository($db)
        );
    }

    public function index()
    {
        $this->auth();
        $this->onlyAdmin();

        $data = $this->service()->indexData();

        $this->render('Modules/Products/Views/movements/index', [
            'title' => 'Kardex',
            'movements' => $data['movements'],
            'warehouses' => $data['warehouses'],
        ]);
    }

    public function store()
    {
        $this->auth();
        $this->onlyAdmin();

        header('Content-Type: application/json');

        try {
            $movementId = $this->service()->create($_POST, $_SESSION['user']['id']);

            echo json_encode([
                'ok' => true,
                'movement_id' => $movementId,
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
