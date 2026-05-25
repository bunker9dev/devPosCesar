<?php

namespace App\Modules\Products\Repositories;

class PurchaseRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $sql = "
            SELECT p.*, s.nombre AS proveedor, u.username AS usuario
            FROM purchases p
            LEFT JOIN proveedores s ON s.id = p.supplier_id
            JOIN usuarios u ON u.id = p.usuario_id
            ORDER BY p.id DESC
        ";

        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }
}
