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

    // 🔍 LISTAR
    public function index()
    {
        $this->auth();
        $this->onlyAdmin();

        $isSuper = $_SESSION['user']['rol_nombre'] === 'super';

        $suppliers = $this->service->getAll($isSuper);

        $this->render('Modules/Suppliers/Views/index', [
            'suppliers' => $suppliers,
            'isSuper' => $isSuper
        ]);
    }

    // ➕ FORM CREATE
    public function create()
    {
        $this->auth();
        $this->onlyAdmin();

        $isSuper = ($_SESSION['user']['rol'] == 1);

        $this->render('Modules/Suppliers/Views/create', [
            'isSuper' => $isSuper
        ]);
    }

    // 💾 GUARDAR
    public function store()
    {
        $this->auth();
        $this->onlyAdmin();

        try {

            $this->service->create($_POST);

            $_SESSION['success'] = "Proveedor creado";
            return $this->redirect(BASE_URL . "/suppliers");
        } catch (\Exception $e) {

            // 🔥 ERRORES POR CAMPO (tipo Laravel)
            $errors = json_decode($e->getMessage(), true);

            $_SESSION['errors'] = $errors ?: ['general' => $e->getMessage()];

            // 🔥 MANTENER INPUTS
            $_SESSION['old'] = $_POST;

            return $this->redirect(BASE_URL . "/suppliers/create");
        }
    }

    // ✏️ FORM EDIT
    public function edit()
    {
        $this->auth();
        $this->onlyAdmin();

        global $db;

        $id = $_GET['id'] ?? null;

        if (!$id) {
            die('ID no proporcionado');
        }

        $stmt = $db->prepare("SELECT * FROM proveedores WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $supplier = $stmt->get_result()->fetch_assoc();

        if (!$supplier) {
            die('Proveedor no encontrado');
        }

        $this->render('Modules/Suppliers/Views/edit', [
            'title' => 'Editar proveedor',
            'supplier' => $supplier
        ]);
    }

    // 💾 ACTUALIZAR
    public function update($id)
    {
        $this->auth();
        $this->onlyAdmin();

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

    // 🔄 CAMBIAR ESTADO (AJAX)
    public function toggle()
    {
        header('Content-Type: application/json');

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

    // 🗑️ ELIMINAR (AJAX)

    public function delete()
    {
        // ⚠️ NO usar ob_clean por ahora
        header('Content-Type: application/json');

        try {

            $db = conectarDB();

            if (!isset($_SESSION['user'])) {
                echo json_encode(['ok' => false, 'error' => 'No autenticado']);
                return;
            }

            $rol = $_SESSION['user']['rol_nombre'] ?? '';

            if (!in_array($rol, ['super', 'administrador'])) {
                echo json_encode(['ok' => false, 'error' => 'No autorizado']);
                return;
            }

            $id = $_POST['id'] ?? null;

            if (!$id) {
                echo json_encode(['ok' => false, 'error' => 'ID inválido']);
                return;
            }

            // 🔥 OJO CON ESTE CAMPO (nombre)
            $stmt = $db->prepare("SELECT nombre, estado FROM proveedores WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $supplier = $stmt->get_result()->fetch_assoc();

            if (!$supplier) {
                echo json_encode(['ok' => false, 'error' => 'Proveedor no existe']);
                return;
            }

            // 🔥 SOFT DELETE
            $stmt = $db->prepare("UPDATE proveedores SET estado = 0 WHERE id = ?");
            $stmt->bind_param("i", $id);

            if (!$stmt->execute()) {
                echo json_encode(['ok' => false, 'error' => $stmt->error]);
                return;
            }

            // 🧠 AUDITORÍA
            $admin = $_SESSION['user']['username'] ?? 'Sistema';

            $detalle = "Proveedor: {$supplier['nombre']} | Estado: {$supplier['estado']} → 0 | Por: {$admin}";

            auditoria("DELETE", "proveedores", $id, $detalle, "suppliers");

            // 🔥 ESTA LÍNEA ES LA MÁS IMPORTANTE
            echo json_encode(['ok' => true]);
            return;
        } catch (Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);
            return;
        }
    }

    // ♻️ RESTAURAR (AJAX)
    public function restore()
    {
        header('Content-Type: application/json');

        try {

            $this->service->restore($_POST['id'], $_SESSION['user']['id']);

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    // 🔍 VALIDAR NIT (AJAX)
    public function checkNit()
    {
        header('Content-Type: application/json');

        $nit = $_GET['nit'] ?? '';

        $exists = $this->service->existsByNit($nit);

        echo json_encode([
            'exists' => $exists
        ]);
    }
}
