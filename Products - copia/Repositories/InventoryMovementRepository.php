<?php

namespace App\Modules\Products\Repositories;

use Exception;

class InventoryMovementRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $sql = "
            SELECT m.*, r.codigo_barra, r.codigo_visible, ft.nombre AS tipo_tela,
                   fc.nombre AS color, wo.nombre AS bodega_origen, wd.nombre AS bodega_destino,
                   u.username AS usuario
            FROM inventory_movements m
            JOIN rolls r ON r.id = m.roll_id
            JOIN fabric_types ft ON ft.id = r.fabric_type_id
            JOIN fabric_colors fc ON fc.id = r.fabric_color_id
            LEFT JOIN warehouses wo ON wo.id = m.warehouse_origin_id
            LEFT JOIN warehouses wd ON wd.id = m.warehouse_destination_id
            JOIN usuarios u ON u.id = m.usuario_id
            ORDER BY m.id DESC
        ";

        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function create(array $data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO inventory_movements
            (roll_id, tipo, metros, precio, warehouse_origin_id, warehouse_destination_id, usuario_id, nota)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "isddiiis",
            $data['roll_id'],
            $data['tipo'],
            $data['metros'],
            $data['precio'],
            $data['warehouse_origin_id'],
            $data['warehouse_destination_id'],
            $data['usuario_id'],
            $data['nota']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error creando movimiento: " . $stmt->error);
        }

        return $stmt->insert_id;
    }
}
