<?php

namespace App\Modules\Suppliers\Services;

class SupplierService
{
    public function getAll($isSuper)
    {
        global $db;

        $query = "
            SELECT s.*, u.username AS creado_por
            FROM proveedores s
            LEFT JOIN usuarios u ON s.created_by = u.id
        ";

        if (!$isSuper) {
            $query .= " WHERE s.estado IN (1,2)";
        }

        $query .= " ORDER BY s.estado ASC, s.created_at DESC";

        return $db->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data)
    {
        global $db;

        $stmt = $db->prepare("
            INSERT INTO proveedores 
            (nombre, apellidos, ciudad, telefono, created_by)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssi",
            $data['nombre'],
            $data['apellidos'],
            $data['ciudad'],
            $data['telefono'],
            $data['user_id']
        );

        $stmt->execute();

        return $stmt->insert_id;
    }

    public function toggle($id)
    {
        global $db;

        $stmt = $db->prepare("SELECT estado FROM proveedores WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $prov = $stmt->get_result()->fetch_assoc();

        $nuevo = ($prov['estado'] == 1) ? 2 : 1;

        $stmt = $db->prepare("UPDATE proveedores SET estado=? WHERE id=?");
        $stmt->bind_param("ii", $nuevo, $id);
        $stmt->execute();

        return $nuevo;
    }
}