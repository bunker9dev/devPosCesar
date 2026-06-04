<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;

class RollController extends Controller
{
    public function index()
    {
        $db = conectarDB();

        $query = "
            SELECT r.*,
                   t.nombre AS tipo,
                   c.nombre AS color,
                   s.nombre AS proveedor
            FROM rolls r
            JOIN fabric_types t ON r.fabric_type_id = t.id
            JOIN fabric_colors c ON r.fabric_color_id = c.id
            JOIN proveedores s ON r.supplier_id = s.id
            WHERE r.estado != 'eliminado'
            ORDER BY r.id DESC
        ";

        $rolls = $db->query($query)->fetch_all(MYSQLI_ASSOC);

        $types = $db->query("SELECT * FROM fabric_types WHERE deleted_at IS NULL")->fetch_all(MYSQLI_ASSOC);
        $colors = $db->query("SELECT * FROM fabric_colors WHERE deleted_at IS NULL")->fetch_all(MYSQLI_ASSOC);
        $suppliers = $db->query("SELECT * FROM proveedores WHERE estado = 1")->fetch_all(MYSQLI_ASSOC);

        $this->render('Modules/Products/Views/rolls/index', compact('rolls', 'types', 'colors', 'suppliers'));
    }

    // =========================
    // CREATE + CODIGOS AUTO
    // =========================
    public function store()
    {
        $db = conectarDB();

        // 1. Insert base
        $stmt = $db->prepare("
            INSERT INTO rolls 
            (fabric_type_id, fabric_color_id, supplier_id, metros, precio_compra, estado)
            VALUES (?, ?, ?, ?, ?, 'activo')
        ");

        $stmt->bind_param(
            "iiidd",
            $_POST['fabric_type_id'],
            $_POST['fabric_color_id'],
            $_POST['supplier_id'],
            $_POST['metros'],
            $_POST['precio_compra']
        );

        $stmt->execute();

        // 2. Obtener ID
        $id = $db->insert_id;

        // 3. Generar códigos
        $codigo_visible = 'ROL-' . str_pad($id, 5, '0', STR_PAD_LEFT);

        $codigo_barra = '100000000' . str_pad($id, 3, '0', STR_PAD_LEFT);

        // 4. Guardar códigos
        $stmt = $db->prepare("
            UPDATE rolls 
            SET codigo_visible = ?, codigo_barra = ?
            WHERE id = ?
        ");

        $stmt->bind_param("ssi", $codigo_visible, $codigo_barra, $id);
        $stmt->execute();

        header("Location: " . BASE_URL . "/rolls");
    }

    // =========================
    // DELETE (SOFT)
    // =========================
    public function delete()
    {
        header('Content-Type: application/json');

        $db = conectarDB();
        $id = $_POST['id'] ?? null;

        $stmt = $db->prepare("
            UPDATE rolls 
            SET estado = 'eliminado'
            WHERE id = ?
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo json_encode(['ok' => true]);
    }
}