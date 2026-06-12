<?php

namespace App\Modules\Products\Repositories;

class ColorRepository
{
    private $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT 
            id, 
            codigo, 
            nombre, 
            hex, 
            estado
            FROM fabric_colors
            ORDER BY id DESC
        ");

        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    
    public function create($codigo, $nombre, $hex)
    {
        $stmt = $this->db->prepare("
            INSERT INTO fabric_colors (codigo, nombre, hex, estado)
            VALUES (?, ?, ?, 1)
        ");

        $stmt->bind_param("sss", $codigo, $nombre, $hex);
        return $stmt->execute();
    }

    public function nextCode()
    {
        $stmt = $this->db->prepare("
            SELECT MAX(id) as last_id FROM fabric_colors
        ");

        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        $next = ($result['last_id'] ?? 0) + 1;

        return str_pad($next, 3, "0", STR_PAD_LEFT);
    }

    
    public function softDelete($id)
    {
        $stmt = $this->db->prepare("
            UPDATE fabric_colors 
            SET estado = 0, deleted_at = NOW()
            WHERE id = ?
        ");

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

   
    public function restore($id)
    {
        $stmt = $this->db->prepare("
            UPDATE fabric_colors 
            SET estado = 1, deleted_at = NULL
            WHERE id = ?
        ");

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    
    public function exists($nombre)
    {
        $nombre = strtolower($nombre);

        $stmt = $this->db->prepare("
            SELECT id 
            FROM fabric_colors 
            WHERE LOWER(nombre) = ?
            AND estado != 0
            LIMIT 1
        ");

        $stmt->bind_param("s", $nombre);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    
    public function find($id)
    {
        $stmt = $this->db->prepare("
            SELECT nombre, codigo, hex 
            FROM fabric_colors 
            WHERE id = ?
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
}