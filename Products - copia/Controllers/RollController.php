<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;
use App\Modules\Products\Repositories\AuditLogRepository;
use App\Modules\Products\Repositories\CatalogRepository;
use App\Modules\Products\Repositories\InventoryMovementRepository;
use App\Modules\Products\Repositories\RollRepository;
use App\Modules\Products\Services\RollService;

class RollController extends Controller
{
    private function service()
    {
        global $db;

        return new RollService(
            $db,
            new CatalogRepository($db),
            new RollRepository($db),
            new InventoryMovementRepository($db),
            new AuditLogRepository($db)
        );
    }

    public function index()
    {
        $this->auth();
        $this->onlyAdmin();

        $this->render('Modules/Products/Views/rolls/index', [
            'title' => 'Rollos',
            'rolls' => $this->service()->indexData()['rolls'],
        ]);
    }

    public function create()
    {
        $this->auth();
        $this->onlyAdmin();

        $data = $this->service()->createData();

        $this->render('Modules/Products/Views/rolls/create', [
            'title' => 'Crear rollo',
            'types' => $data['types'],
            'colors' => $data['colors'],
            'suppliers' => $data['suppliers'],
            'warehouses' => $data['warehouses'],
            'old' => $_SESSION['old'] ?? [],
            'errors' => $_SESSION['errors'] ?? [],
        ]);

        unset($_SESSION['old'], $_SESSION['errors']);
    }

    public function store()
    {
        $this->auth();
        $this->onlyAdmin();

        try {
            $roll = $this->service()->createManual($_POST, $_SESSION['user']['id']);
            $_SESSION['success'] = "Rollo creado: " . $roll['codigo_barra'];

            return $this->redirect(BASE_URL . "/rolls/label?id=" . $roll['id']);
        } catch (\Exception $e) {
            $_SESSION['errors'] = ['general' => $e->getMessage()];
            $_SESSION['old'] = $_POST;

            return $this->redirect(BASE_URL . "/rolls/create");
        }
    }

    public function search()
    {
        $this->auth();
        $this->onlyAdmin();

        header('Content-Type: application/json');

        try {
            $code = $_POST['code'] ?? $_GET['code'] ?? '';
            $roll = $this->service()->findByCode($code);

            echo json_encode([
                'ok' => (bool) $roll,
                'roll' => $roll,
                'error' => $roll ? null : 'Rollo no encontrado',
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'ok' => false,
                'roll' => null,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function label()
    {
        $this->auth();
        $this->onlyAdmin();

        global $db;

        $id = (int) ($_GET['id'] ?? 0);
        $roll = (new RollRepository($db))->find($id);

        if (!$roll) {
            $_SESSION['error'] = "Rollo no encontrado";
            return $this->redirect(BASE_URL . "/rolls");
        }

        $this->render('Modules/Products/Views/rolls/label', [
            'title' => 'Etiqueta rollo',
            'roll' => $roll,
        ]);
    }
}
