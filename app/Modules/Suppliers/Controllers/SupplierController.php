<?php

namespace App\Modules\Suppliers\Controllers;

use App\Core\Controller;
use App\Core\Roles;
use App\Core\Status;
use App\Modules\Suppliers\Services\SupplierService;
use App\Modules\Suppliers\Models\Supplier;

class SupplierController extends Controller
{
    private $service;

    public function __construct()
    {
        global $db;
        $model = new Supplier($db);
        $this->service = new SupplierService($model, $db);
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

        $suppliers = $this->service->getAll($isSuper);

        $this->render('Modules/Suppliers/Views/index', compact('suppliers'));
    }

    // ======================================================
    // CREATE
    // ======================================================
    public function create()
    {
        $this->auth();
        $this->onlyAdmin();

        $this->render('Modules/Suppliers/Views/create');
    }

    // ======================================================
    // STORE
    // ======================================================
    public function store()
    {
        $this->auth();
        $this->onlyAdmin();

        try {

            $_POST['user_id'] = $_SESSION['user']['id'];

            $this->service->create($_POST);

            $_SESSION['success'] = "Proveedor creado";
            return $this->redirect(BASE_URL . "/suppliers");
        } catch (\Exception $e) {

            $errors = json_decode($e->getMessage(), true);

            $_SESSION['errors'] = $errors ?: ['general' => $e->getMessage()];
            $_SESSION['old'] = $_POST;

            return $this->redirect(BASE_URL . "/suppliers/create");
        }
    }

    // ======================================================
    // EDIT
    // ======================================================
    public function edit()
    {
        $this->auth();
        $this->onlyAdmin();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            return $this->redirect(BASE_URL . "/suppliers");
        }

        $supplier = $this->service->find($id);

        if (!$supplier) {
            return $this->redirect(BASE_URL . "/suppliers");
        }

        $this->render('Modules/Suppliers/Views/edit', compact('supplier'));
    }

    // ======================================================
    // UPDATE
    // ======================================================
    public function update()
    {
        $this->auth();
        $this->onlyAdmin();

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $_SESSION['errors'] = ['general' => 'ID no proporcionado'];
            return $this->redirect(BASE_URL . "/suppliers");
        }

        try {

            $_POST['user_id'] = $_SESSION['user']['id'];

            $this->service->update($id, $_POST);

            $_SESSION['success'] = "Proveedor actualizado";
            return $this->redirect(BASE_URL . "/suppliers");
        } catch (\Exception $e) {

            $errors = json_decode($e->getMessage(), true);

            $_SESSION['errors'] = $errors ?: ['general' => $e->getMessage()];
            $_SESSION['old'] = $_POST;

            return $this->redirect(BASE_URL . "/suppliers/edit?id=" . $id);
        }
    }

    // ======================================================
    // TOGGLE
    // ======================================================
    public function toggle()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!Roles::canEdit($rolId)) {
            return print json_encode(['ok' => false, 'error' => 'No autorizado']);
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
    // DELETE (SOFT)
    // ======================================================
    public function delete()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!Roles::canDelete($rolId)) {
            return print json_encode(['ok' => false, 'error' => 'No autorizado']);
        }

        try {

            $this->service->delete(
                $_POST['id'],
                $_SESSION['user']['id']
            );

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public function restore()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!Roles::canRestore($rolId)) {
            return print json_encode(['ok' => false, 'error' => 'No autorizado']);
        }

        try {

            $this->service->restore(
                $_POST['id'],
                $_SESSION['user']['id']
            );

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function checkNit()
    {
        header('Content-Type: application/json');

        try {

            $nit = $_POST['nit'] ?? '';

            if (!$nit) {
                echo json_encode(['exists' => false]);
                return;
            }

            $db = conectarDB();

            $stmt = $db->prepare("
            SELECT id FROM proveedores WHERE nit = ?
            LIMIT 1
        ");

            $stmt->bind_param("s", $nit);
            $stmt->execute();

            $exists = $stmt->get_result()->num_rows > 0;

            echo json_encode([
                'ok' => true,
                'exists' => $exists
            ]);
        } catch (\Exception $e) {

            echo json_encode([
                'exists' => false
            ]);
        }

        exit;
    }
}
