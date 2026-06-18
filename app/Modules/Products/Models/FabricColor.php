<?php

namespace App\Modules\Products\Models;

use Exception;
use App\Core\Status;

class FabricColor
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // ======================================================
    // LISTAR
    // ======================================================
    public function getAll($isSuper = false)
    {
        $query = "
            SELECT 
                id,
                codigo,
                nombre,
                estado,
                created_at
            FROM fabric_colors
        ";

        if (!$isSuper) {
            $query .= " WHERE estado IN (" . Status::ACTIVO . ", " . Status::INACTIVO . ")";
        }

        $query .= " ORDER BY created_at DESC";

        $result = $this->db->query($query);

        if (!$result) {
            throw new Exception("Error al obtener colores");
        }

        $data = $result->fetch_all(MYSQLI_ASSOC);

        // 🔥 NORMALIZAR TIPOS
        foreach ($data as &$row) {
            $row['estado'] = (int)$row['estado'];
        }

        return $data;
    }

    // ======================================================
    // BUSCAR
    // ======================================================
    public function find($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM fabric_colors WHERE id = ?
        ");

        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al obtener color");
        }

        $data = $stmt->get_result()->fetch_assoc();

        if ($data) {
            $data['estado'] = (int)$data['estado'];
        }

        return $data;
    }

    // ======================================================
    // VALIDAR CODIGO
    // ======================================================
    public function existsByCodigo($codigo, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->db->prepare("
                SELECT id FROM fabric_colors 
                WHERE codigo = ? AND id <> ?
            ");
            $stmt->bind_param("si", $codigo, $excludeId);
        } else {
            $stmt = $this->db->prepare("
                SELECT id FROM fabric_colors 
                WHERE codigo = ?
            ");
            $stmt->bind_param("s", $codigo);
        }

        if (!$stmt->execute()) {
            throw new Exception("Error validando código");
        }

        return $stmt->get_result()->num_rows > 0;
    }

    // ======================================================
    // VALIDAR NOMBRE
    // ======================================================
    public function existsByNombre($nombre, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->db->prepare("
                SELECT id FROM fabric_colors 
                WHERE nombre = ? AND id <> ?
            ");
            $stmt->bind_param("si", $nombre, $excludeId);
        } else {
            $stmt = $this->db->prepare("
                SELECT id FROM fabric_colors 
                WHERE nombre = ?
            ");
            $stmt->bind_param("s", $nombre);
        }

        if (!$stmt->execute()) {
            throw new Exception("Error validando nombre");
        }

        return $stmt->get_result()->num_rows > 0;
    }

    // ======================================================
    // CREAR
    // ======================================================
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO fabric_colors 
            (codigo, nombre, estado, created_by, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");

        $estado = isset($data['estado'])
            ? (int)$data['estado']
            : Status::ACTIVO;

        $stmt->bind_param(
            "ssii",
            $data['codigo'],
            $data['nombre'],
            $estado,
            $data['user_id']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al crear color: " . $stmt->error);
        }

        return $stmt->insert_id;
    }

    // ======================================================
    // ACTUALIZAR
    // ======================================================
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
        UPDATE fabric_colors 
        SET nombre=?, updated_by=?, updated_at=NOW()
        WHERE id=?
    ");

        $stmt->bind_param(
            "sii",
            $data['nombre'],
            $data['user_id'],
            $id
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar color: " . $stmt->error);
        }

        return true;
    }

    // ======================================================
    // CAMBIAR ESTADO
    // ======================================================
    public function updateEstado($id, $estado, $userId)
    {
        $stmt = $this->db->prepare("
            UPDATE fabric_colors 
            SET estado=?, updated_by=?, updated_at=NOW()
            WHERE id=?
        ");

        $stmt->bind_param("iii", $estado, $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al cambiar estado");
        }

        return true;
    }

    // ======================================================
    // DELETE (SOFT)
    // ======================================================
    public function delete($id, $userId)
    {
        $stmt = $this->db->prepare("
            UPDATE fabric_colors 
            SET estado=?, deleted_at=NOW(), deleted_by=?
            WHERE id=?
        ");

        $estado = Status::ELIMINADO;

        $stmt->bind_param("iii", $estado, $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar color");
        }

        return true;
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public function restore($id, $userId)
    {
        $stmt = $this->db->prepare("
            UPDATE fabric_colors 
            SET estado=?, deleted_at=NULL, deleted_by=NULL, updated_by=?
            WHERE id=?
        ");

        $estado = Status::ACTIVO;

        $stmt->bind_param("iii", $estado, $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al restaurar color");
        }

        return true;
    }

    // ======================================================
    // OBTENER ÚLTIMO CÓDIGO
    // ======================================================
    public function getLastCode()
    {
        $result = $this->db->query("
            SELECT codigo 
            FROM fabric_colors 
            ORDER BY id DESC 
            LIMIT 1
        ");

        if (!$result) {
            throw new Exception("Error al obtener último código");
        }

        $row = $result->fetch_assoc();

        return $row['codigo'] ?? null;
    }

    // ======================================================
    // VALIDAR SI ESTÁ EN USO
    // ======================================================
    public function isUsed($id): bool
    {
        $stmt = $this->db->prepare("
        SELECT 1 
        FROM rolls 
        WHERE fabric_color_id = ? 
        LIMIT 1
    ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $stmt->store_result();

        return $stmt->num_rows > 0;
    }

    // ======================================================
    // VALIDAR SI ESTA ELIMINADO
    // ======================================================


    public function findDeletedByNombre($nombre)
    {
        $stmt = $this->db->prepare("
        SELECT id, codigo, nombre 
        FROM fabric_colors 
        WHERE nombre = ? 
        AND estado = ?
        LIMIT 1
    ");

        $estado = Status::ELIMINADO;

        $stmt->bind_param("si", $nombre, $estado);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }
}
