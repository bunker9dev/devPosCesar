<?php

namespace App\Modules\Products\Repositories;

use Exception;

class RollRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $sql = "
            SELECT r.*, p.nombre AS producto, ft.nombre AS tipo_tela, ft.codigo AS tipo_codigo,
                   fc.nombre AS color, fc.codigo AS color_codigo, fc.hex,
                   w.nombre AS bodega, s.nombre AS proveedor
            FROM rolls r
            JOIN products p ON p.id = r.product_id
            JOIN fabric_types ft ON ft.id = r.fabric_type_id
            JOIN fabric_colors fc ON fc.id = r.fabric_color_id
            JOIN warehouses w ON w.id = r.warehouse_id
            JOIN proveedores s ON s.id = r.supplier_id
            ORDER BY r.id DESC
        ";

        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function activeByWarehouse($warehouseId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM rolls
            WHERE warehouse_id = ? AND estado = 'activo'
            ORDER BY codigo_barra
        ");
        $stmt->bind_param("i", $warehouseId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("
            SELECT r.*, p.nombre AS producto, ft.nombre AS tipo_tela, ft.codigo AS tipo_codigo,
                   fc.nombre AS color, fc.codigo AS color_codigo, fc.hex,
                   w.nombre AS bodega, s.nombre AS proveedor
            FROM rolls r
            JOIN products p ON p.id = r.product_id
            JOIN fabric_types ft ON ft.id = r.fabric_type_id
            JOIN fabric_colors fc ON fc.id = r.fabric_color_id
            JOIN warehouses w ON w.id = r.warehouse_id
            JOIN proveedores s ON s.id = r.supplier_id
            WHERE r.id = ?
            LIMIT 1
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function findByAnyCode($code)
    {
        $stmt = $this->db->prepare("
            SELECT r.*, p.nombre AS producto, ft.nombre AS tipo_tela, ft.codigo AS tipo_codigo,
                   fc.nombre AS color, fc.codigo AS color_codigo, fc.hex,
                   w.nombre AS bodega, s.nombre AS proveedor
            FROM rolls r
            JOIN products p ON p.id = r.product_id
            JOIN fabric_types ft ON ft.id = r.fabric_type_id
            JOIN fabric_colors fc ON fc.id = r.fabric_color_id
            JOIN warehouses w ON w.id = r.warehouse_id
            JOIN proveedores s ON s.id = r.supplier_id
            WHERE r.codigo_barra = ? OR r.codigo_visible = ?
            LIMIT 1
        ");
        $stmt->bind_param("ss", $code, $code);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function create(array $data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO rolls
            (product_id, fabric_type_id, fabric_color_id, supplier_id, purchase_id, warehouse_id,
             codigo_barra, codigo_visible, metros, centimetros, precio_compra, estado, created_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'activo', ?)
        ");

        $stmt->bind_param(
            "iiiiiissdidi",
            $data['product_id'],
            $data['fabric_type_id'],
            $data['fabric_color_id'],
            $data['supplier_id'],
            $data['purchase_id'],
            $data['warehouse_id'],
            $data['codigo_barra'],
            $data['codigo_visible'],
            $data['metros'],
            $data['centimetros'],
            $data['precio_compra'],
            $data['created_by']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error creando rollo: " . $stmt->error);
        }

        return $stmt->insert_id;
    }

    public function nextBarcode()
    {
        $result = $this->db->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'rolls'");
        $row = $result->fetch_assoc();
        $next = (int) ($row['AUTO_INCREMENT'] ?? 1);

        return 'RL-' . str_pad((string) $next, 9, '0', STR_PAD_LEFT);
    }

    public function updateWarehouse($rollId, $warehouseId)
    {
        $stmt = $this->db->prepare("UPDATE rolls SET warehouse_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $warehouseId, $rollId);
        $stmt->execute();
    }

    public function updateEstado($rollId, $estado)
    {
        $stmt = $this->db->prepare("UPDATE rolls SET estado = ? WHERE id = ?");
        $stmt->bind_param("si", $estado, $rollId);
        $stmt->execute();
    }
}
