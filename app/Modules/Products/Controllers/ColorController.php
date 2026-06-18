<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;
use App\Core\Roles;
use App\Core\Status;
use App\Modules\Products\Services\ColorService;
use App\Modules\Products\Models\FabricColor;

class ColorController extends Controller
{
    private $service;

    public function __construct()
    {
        global $db;

        $model = new FabricColor($db);
        $this->service = new ColorService($model, $db);
    }

    // ======================================================
    // LISTADO
    // ======================================================
    public function index()
    {
        $this->auth();
        $this->onlyAdmin();

        $rolId = $_SESSION['user']['rol_id'] ?? null;
        $isSuper = $rolId === Roles::SUPER;

        $colors = $this->service->getAll($isSuper);

        $this->render('Modules/Products/Views/colors/index', compact('colors'));
    }

    // ======================================================
    // STORE (FORM NORMAL)
    // ======================================================
    public function store()
{
    header('Content-Type: application/json');

    try {

        $_POST['user_id'] = $_SESSION['user']['id'];

        $id = $this->service->create($_POST);

        echo json_encode([
            'ok' => true,
            'id' => $id,
            'message' => 'Color creado'
        ]);

    } catch (\Throwable $e) {

        http_response_code(400);

        echo json_encode([
            'ok' => false,
            'error' => $e->getMessage()
        ]);
    }
}
    // ======================================================
    // UPDATE (AJAX ✅)
    // ======================================================
    public function update()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!Roles::canEdit($rolId)) {
            return print json_encode([
                'ok' => false,
                'error' => 'No autorizado'
            ]);
        }

        try {

            $id = $_POST['id'] ?? null;

            if (!$id) {
                throw new \Exception("ID inválido");
            }

            $_POST['user_id'] = $_SESSION['user']['id'];

            $this->service->update($id, $_POST);

            echo json_encode([
                'ok' => true
            ]);
        } catch (\Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    // ======================================================
    // TOGGLE (AJAX)
    // ======================================================
    public function toggle()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!Roles::canEdit($rolId)) {
            return print json_encode([
                'ok' => false,
                'error' => 'No autorizado'
            ]);
        }

        try {

            $estado = $this->service->toggle(
                $_POST['id'],
                $_SESSION['user']['id']
            );

            echo json_encode([
                'ok' => true,
                'estado' => $estado
            ]);
        } catch (\Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    // ======================================================
    // DELETE (AJAX)
    // ======================================================
    public function delete()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!Roles::canDelete($rolId)) {
            return print json_encode([
                'ok' => false,
                'error' => 'No autorizado'
            ]);
        }

        try {

            $this->service->delete(
                $_POST['id'],
                $_SESSION['user']['id']
            );

            echo json_encode([
                'ok' => true
            ]);
        } catch (\Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    // ======================================================
    // RESTORE (AJAX)
    // ======================================================
    public function restore()
    {
        header('Content-Type: application/json');

        try {

            // solo validas autenticación + permiso general del módulo
            $this->auth();
            $this->onlyAdmin(); // o Roles::canEdit / canManageColors

            $this->service->restore(
                $_POST['id'],
                $_SESSION['user']['id']
            );

            echo json_encode([
                'ok' => true
            ]);
        } catch (\Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}
