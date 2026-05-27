<?php

namespace App\Modules\Products\Repositories;

class CatalogRepository
{
    private $db;

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    public function getAll($table)
    {
        $result = $this->db->query("
            SELECT * FROM $table
            ORDER BY id DESC
        ");

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function exists($table, $nombre)
    {
        $stmt = $this->db->prepare("
            SELECT id 
            FROM $table 
            WHERE LOWER(nombre) = ?
            AND deleted_at IS NULL
            LIMIT 1
        ");

        $stmt->bind_param("s", $nombre);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    public function nextCode($table)
    {
        $result = $this->db->query("SELECT MAX(id) as max FROM $table");
        $row = $result->fetch_assoc();

        return str_pad(($row['max'] + 1), 3, '0', STR_PAD_LEFT);
    }

    public function create($table, $codigo, $nombre)
    {
        $stmt = $this->db->prepare("
            INSERT INTO $table (codigo, nombre)
            VALUES (?, ?)
        ");

        $stmt->bind_param("ss", $codigo, $nombre);
        return $stmt->execute();
    }

    public function softDelete($table, $id)
    {
        $stmt = $this->db->prepare("
            UPDATE $table 
            SET estado = 0, deleted_at = NOW()
            WHERE id = ?
        ");

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function restore($table, $id)
    {
        $stmt = $this->db->prepare("
            UPDATE $table 
            SET estado = 1, deleted_at = NULL
            WHERE id = ?
        ");

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }


    public function find($table, $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM $table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function update($table, $id, $nombre)
    {
        $stmt = $this->db->prepare("
        UPDATE $table 
        SET nombre = ?
        WHERE id = ?
    ");

        $stmt->bind_param("si", $nombre, $id);
        return $stmt->execute();
    }

    public function existsExceptId($table, $nombre, $id)
    {
        $stmt = $this->db->prepare("
        SELECT id 
        FROM $table 
        WHERE nombre = ? AND id != ?
    ");

        $stmt->bind_param("si", $nombre, $id);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }




    public function isUsed($table, $id)
    {
        // 🔥 MAPEO DE USO POR TABLA
        $relations = [
            'fabric_types' => ['table' => 'products', 'field' => 'fabric_type_id'],
            'colors'       => ['table' => 'products', 'field' => 'color_id'],
            // agrega más aquí
        ];

        if (!isset($relations[$table])) {
            return false;
        }

        $rel = $relations[$table];

        $stmt = $this->db->prepare("
        SELECT COUNT(*) as total
        FROM {$rel['table']}
        WHERE {$rel['field']} = ?
    ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();

        return $result['total'] > 0;
    }
}
