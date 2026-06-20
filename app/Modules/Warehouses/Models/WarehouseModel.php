<?php

namespace App\Modules\Warehouses\Models;

use Exception;
use App\Core\Status;

class WarehouseModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll($includeDeleted = false)
    {
        $sql = "SELECT * FROM warehouses";

        if (!$includeDeleted) {
            $sql .= " WHERE estado != " . Status::ELIMINADO;
        }

        $sql .= " ORDER BY id DESC";

        $result = $this->db->query($sql);

        if (!$result) {
            throw new Exception("Error al obtener bodegas");
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM warehouses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function existsByNombre($nombre, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->db->prepare("SELECT id FROM warehouses WHERE LOWER(nombre) = LOWER(?) AND id != ?");
            $stmt->bind_param("si", $nombre, $excludeId);
        } else {
            $stmt = $this->db->prepare("SELECT id FROM warehouses WHERE LOWER(nombre) = LOWER(?)");
            $stmt->bind_param("s", $nombre);
        }

        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    public function getLastCode()
    {
        $result = $this->db->query("SELECT codigo FROM warehouses ORDER BY id DESC LIMIT 1");
        $row = $result->fetch_assoc();

        return $row['codigo'] ?? null;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO warehouses (codigo, nombre, ubicacion, estado, created_by, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");

        $estado = Status::ACTIVO;

        $stmt->bind_param(
            "sssii",
            $data['codigo'],
            $data['nombre'],
            $data['ubicacion'],
            $estado,
            $data['user_id']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al crear bodega: " . $stmt->error);
        }

        return $stmt->insert_id;
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE warehouses
            SET nombre = ?, ubicacion = ?, updated_by = ?, updated_at = NOW()
            WHERE id = ?
        ");

        $stmt->bind_param("ssii", $data['nombre'], $data['ubicacion'], $data['user_id'], $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar bodega: " . $stmt->error);
        }

        return true;
    }

    public function updateEstado($id, $estado, $userId)
    {
        $stmt = $this->db->prepare("
            UPDATE warehouses SET estado = ?, updated_by = ?, updated_at = NOW() WHERE id = ?
        ");

        $stmt->bind_param("iii", $estado, $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al cambiar estado");
        }

        return true;
    }

    public function delete($id, $userId)
    {
        $stmt = $this->db->prepare("
            UPDATE warehouses SET estado = ?, deleted_at = NOW(), deleted_by = ? WHERE id = ?
        ");

        $estado = Status::ELIMINADO;

        $stmt->bind_param("iii", $estado, $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar bodega");
        }

        return true;
    }

    public function restore($id, $userId)
    {
        $stmt = $this->db->prepare("
            UPDATE warehouses SET estado = ?, deleted_at = NULL, deleted_by = NULL, updated_by = ? WHERE id = ?
        ");

        $estado = Status::ACTIVO;

        $stmt->bind_param("iii", $estado, $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al restaurar bodega");
        }

        return true;
    }

    /**
     * 🔧 Preparado para el futuro, igual que en FabricTypes/Colors:
     * hoy siempre false porque fabric_rolls aún no existe.
     */
    public function isUsed($id): bool
    {
        return false;
    }

    public function findDeletedByNombre($nombre)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM warehouses WHERE LOWER(nombre) = LOWER(?) AND estado = ? LIMIT 1
        ");

        $estado = Status::ELIMINADO;

        $stmt->bind_param("si", $nombre, $estado);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
}