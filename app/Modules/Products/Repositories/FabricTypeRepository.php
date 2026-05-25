<?php

namespace App\Modules\Products\Repositories;

class FabricTypeRepository
{
    private $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    public function getAll()
    {
        $result = $this->db->query("
            SELECT 
                id,
                codigo,
                nombre,
                estado,
                deleted_at
            FROM fabric_types
            ORDER BY id DESC
        ");

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($codigo, $nombre)
    {
        $stmt = $this->db->prepare("
            INSERT INTO fabric_types (codigo, nombre)
            VALUES (?, ?)
        ");

        $stmt->bind_param("ss", $codigo, $nombre);
        return $stmt->execute();
    }

    public function nextCode()
    {
        $result = $this->db->query("
            SELECT MAX(id) as last_id FROM fabric_types
        ");

        $row = $result->fetch_assoc();
        $next = ($row['last_id'] ?? 0) + 1;

        return str_pad($next, 3, "0", STR_PAD_LEFT);
    }

    public function softDelete($id)
    {
        $stmt = $this->db->prepare("
        UPDATE fabric_types 
        SET estado = 0, deleted_at = NOW()
        WHERE id = ?
    ");

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function restore($id)
    {
        $stmt = $this->db->prepare("
        UPDATE fabric_types 
        SET estado = 1, deleted_at = NULL
        WHERE id = ?
    ");

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function exists($nombre)
    {
        $stmt = $this->db->prepare("
        SELECT id 
        FROM fabric_types 
        WHERE LOWER(nombre) = ?
        AND deleted_at IS NULL
        LIMIT 1
    ");

        $stmt->bind_param("s", $nombre);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    public function find($id)
{
    $stmt = $this->db->prepare("
        SELECT nombre, codigo FROM fabric_types WHERE id = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}
}
