<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;
use App\Modules\Products\Services\CatalogService;

class FabricTypeController extends Controller
{
    private $service;
    private $table = 'fabric_types';

    public function __construct()
    {
        $this->auth();
        $this->onlyAdmin();

        $this->service = new CatalogService();
    }

    public function index()
    {
        $types = $this->service->getAll($this->table);

        $this->render('Modules/Products/Views/products/types', [
            'types' => $types,
            'title' => 'Tipos de tela'
        ]);
    }

    public function store()
    {
        try {
            $this->service->create($this->table, $_POST['nombre']);
            $_SESSION['success'] = "Tipo creado correctamente";
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: ' . BASE_URL . '/products/types');
    }

    public function delete()
    {
        header('Content-Type: application/json');

        try {

            $db = conectarDB();

            $id = $_POST['id'] ?? null;

            if (!$id) {
                echo json_encode(['ok' => false, 'error' => 'ID inválido']);
                exit;
            }

            // 🔍 obtener tipo
            $stmt = $db->prepare("SELECT nombre, estado FROM fabric_types WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $type = $stmt->get_result()->fetch_assoc();

            if (!$type) {
                echo json_encode(['ok' => false, 'error' => 'Tipo no existe']);
                exit;
            }

            // 🔥 validar uso
            $stmt = $db->prepare("
            SELECT COUNT(*) as total
            FROM products
            WHERE fabric_type_id = ?
        ");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $result = $stmt->get_result()->fetch_assoc();

            if ($result['total'] > 0) {
                echo json_encode([
                    'ok' => false,
                    'error' => 'Este tipo de tela está en uso'
                ]);
                exit;
            }

            // 🔥 soft delete
            $stmt = $db->prepare("
            UPDATE fabric_types 
            SET estado = 0, deleted_at = NOW()
            WHERE id = ?
        ");
            $stmt->bind_param("i", $id);

            if (!$stmt->execute()) {
                echo json_encode(['ok' => false, 'error' => $stmt->error]);
                exit;
            }

            // 🧠 auditoría
            $admin = $_SESSION['user']['username'] ?? 'Sistema';

            $detalle = "Tipo: {$type['nombre']} | Estado: {$type['estado']} → 0 | Por: {$admin}";

            auditoria("DELETE", "fabric_types", $id, $detalle, "products");

            echo json_encode([
                'ok' => true,
                'message' => 'Tipo eliminado correctamente'
            ]);

            exit;
        } catch (\Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);

            exit;
        }
    }

    public function restore()
    {
        header('Content-Type: application/json');

        try {

            $id = $_POST['id'] ?? null;

            if (!$id) {
                echo json_encode(['ok' => false, 'error' => 'ID inválido']);
                exit;
            }

            $this->service->restore($this->table, $id);

            echo json_encode([
                'ok' => true,
                'message' => 'Registro restaurado correctamente'
            ]);

            exit;
        } catch (\Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);

            exit;
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $this->redirect(BASE_URL . '/products/types');
        }

        $type = $this->service->find($this->table, $id);

        $this->render('Modules/Products/Views/products/edit-type', [
            'type' => $type,
            'title' => 'Editar tipo de tela'
        ]);
    }



    public function update()
    {
        header('Content-Type: application/json'); // 🔥 CLAVE

        try {

            $id = $_POST['id'] ?? null;
            $nombre = $_POST['nombre'] ?? '';

            if (!$id) {
                throw new \Exception("ID inválido");
            }

            $this->service->update($this->table, $id, $nombre);

            echo json_encode([
                'success' => true,
                'message' => 'Tipo actualizado correctamente'
            ]);
        } catch (\Throwable $e) { // 🔥 mejor que Exception

            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        exit; // 🔥 OBLIGATORIO
    }
}
