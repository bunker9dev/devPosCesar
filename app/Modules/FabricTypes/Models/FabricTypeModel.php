<?php

namespace App\Modules\FabricTypes\Models;

class FabricTypeModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll(bool $includeDeleted = false)
    {
        $sql = "SELECT * FROM fabric_types";
        if (!$includeDeleted) {
            $sql .= " WHERE estado != 0";
        }

        $sql .= " ORDER BY id DESC";
        $stmt = $this->db->query($sql);

        return $stmt->fetch_all(MYSQLI_ASSOC);
    }


    public function find($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM fabric_types WHERE id = ?
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function existsByNombre($nombre, $excludeId = null)
    {
        $sql = "SELECT id FROM fabric_types WHERE nombre = ?";

        if ($excludeId) {
            $sql .= " AND id != ?";
        }

        $stmt = $this->db->prepare($sql);

        if ($excludeId) {
            $stmt->bind_param("si", $nombre, $excludeId);
        } else {
            $stmt->bind_param("s", $nombre);
        }

        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    public function getLastCode()
    {
        $stmt = $this->db->query("
            SELECT codigo FROM fabric_types
            ORDER BY id DESC
            LIMIT 1
        ");

        $row = $stmt->fetch_assoc();

        return $row['codigo'] ?? null;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
        INSERT INTO fabric_types 
        (codigo, nombre, estado, created_by)
        VALUES (?, ?, 1, ?)
    ");

        $stmt->bind_param(
            "ssi",
            $data['codigo'],
            $data['nombre'],
            $_SESSION['user']['id']
        );

        $stmt->execute();

        return $stmt->insert_id;
    }


    public function update($id, $data, $userId = null)
    {
        $stmt = $this->db->prepare("
            UPDATE fabric_types
            SET nombre = ?, updated_by = ?
            WHERE id = ?
        ");

        $stmt->bind_param("sii", $data['nombre'], $userId, $id);
        $stmt->execute();
    }

    public function updateEstado($id, $estado, $userId = null)
    {
        $stmt = $this->db->prepare("
        UPDATE fabric_types 
        SET estado = ?, updated_by = ?
        WHERE id = ?
    ");

        $stmt->bind_param("iii", $estado, $userId, $id);
        $stmt->execute();
    }


    public function delete($id, $userId = null)
    {
        $stmt = $this->db->prepare("
            UPDATE fabric_types
            SET estado = 0, deleted_at = NOW(), deleted_by = ?
            WHERE id = ?
        ");

        $stmt->bind_param("ii", $userId, $id);
        $stmt->execute();
    }


    public function restore($id, $userId = null)
    {
        $stmt = $this->db->prepare("
            UPDATE fabric_types
            SET estado = 1, deleted_at = NULL, deleted_by = NULL, updated_by = ?
            WHERE id = ?
        ");

        $stmt->bind_param("ii", $userId, $id);
        $stmt->execute();
    }

    public function findDeletedByNombre($nombre)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM fabric_types
            WHERE nombre = ? AND estado = 0
            LIMIT 1
        ");

        $stmt->bind_param("s", $nombre);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function isInUse($id): bool
    {
        return false;
    }
}
