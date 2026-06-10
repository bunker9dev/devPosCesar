<?php

namespace App\Modules\Products\Repositories;

use Exception;
use App\Core\Status;

class CatalogRepository
{
    private $db;

    // 🔐 WHITELIST DE TABLAS
    private $allowedTables = [
        'fabric_colors',
        'fabric_types'
    ];

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    // ======================================================
    // VALIDAR TABLA (SEGURIDAD)
    // ======================================================
    private function validateTable($table)
    {
        if (!in_array($table, $this->allowedTables)) {
            throw new Exception("Tabla no permitida");
        }
    }

    // ======================================================
    // LISTAR
    // ======================================================
    // public function getAll($table, $includeDeleted = false)
    // {
    //     $this->validateTable($table);

    //     if ($includeDeleted) {
    //         $sql = "SELECT * FROM $table ORDER BY id DESC";
    //     } else {
    //         $sql = "SELECT * FROM $table WHERE estado != ? ORDER BY id DESC";
    //     }

    //     $stmt = $this->db->prepare($sql);

    //     if (!$includeDeleted) {
    //         $estado = Status::ELIMINADO;
    //         $stmt->bind_param("i", $estado);
    //     }

    //     $stmt->execute();

    //     return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    // }
    public function getAll($table, $includeDeleted = false)
    {
        if ($includeDeleted) {
            $sql = "SELECT * FROM $table ORDER BY id DESC";
        } else {
            $sql = "SELECT * FROM $table WHERE deleted_at IS NULL ORDER BY id DESC";
        }

        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    // ======================================================
    // BUSCAR
    // ======================================================
    public function find($table, $id)
    {
        $this->validateTable($table);

        $stmt = $this->db->prepare("
            SELECT * FROM $table WHERE id = ?
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // ======================================================
    // VALIDAR EXISTENCIA (NOMBRE)
    // ======================================================
    public function exists($table, $nombre)
    {
        $this->validateTable($table);

        $stmt = $this->db->prepare("
            SELECT id 
            FROM $table 
            WHERE LOWER(nombre) = LOWER(?)
            AND estado != ?
            LIMIT 1
        ");

        $estado = Status::ELIMINADO;

        $stmt->bind_param("si", $nombre, $estado);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    // ======================================================
    // VALIDAR EXISTENCIA EXCLUYENDO ID
    // ======================================================
    public function existsExceptId($table, $nombre, $id)
    {
        $this->validateTable($table);

        $stmt = $this->db->prepare("
            SELECT id 
            FROM $table 
            WHERE LOWER(nombre) = LOWER(?) 
            AND id != ?
            AND estado != ?
        ");

        $estado = Status::ELIMINADO;

        $stmt->bind_param("sii", $nombre, $id, $estado);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    // ======================================================
    // GENERAR CÓDIGO
    // ======================================================
    public function nextCode($table)
    {
        $this->validateTable($table);

        $result = $this->db->query("SELECT MAX(id) as max FROM $table");
        $row = $result->fetch_assoc();

        return str_pad(($row['max'] + 1), 3, '0', STR_PAD_LEFT);
    }

    // ======================================================
    // CREAR
    // ======================================================
    public function create($table, $codigo, $nombre, $userId)
    {
        $this->validateTable($table);

        $estado = Status::ACTIVO;

        $stmt = $this->db->prepare("
            INSERT INTO $table 
            (codigo, nombre, estado, created_at, created_by)
            VALUES (?, ?, ?, NOW(), ?)
        ");

        $stmt->bind_param("ssii", $codigo, $nombre, $estado, $userId);

        if (!$stmt->execute()) {
            throw new Exception("Error al crear registro");
        }

        return $stmt->insert_id;
    }

    // ======================================================
    // ACTUALIZAR
    // ======================================================
    public function update($table, $id, $nombre)
    {
        $stmt = $this->db->prepare("
                UPDATE $table 
                SET nombre = ?
                WHERE id = ?
            ");

        $stmt->bind_param("si", $nombre, $id);

        if (!$stmt->execute()) {
            throw new \Exception("Error al actualizar");
        }

        return true;
    }

    // ======================================================
    // CAMBIAR ESTADO (TOGGLE)
    // ======================================================
    public function toggle($table, $id, $estado, $userId)
    {
        $this->validateTable($table);

        $stmt = $this->db->prepare("
            UPDATE $table 
            SET estado = ?, updated_at = NOW(), updated_by = ?
            WHERE id = ?
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
    public function softDelete($table, $id, $userId)
    {
        $this->validateTable($table);

        $estado = Status::ELIMINADO;

        $stmt = $this->db->prepare("
            UPDATE $table 
            SET estado = ?, deleted_at = NOW(), deleted_by = ?
            WHERE id = ?
        ");

        $stmt->bind_param("iii", $estado, $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar");
        }

        return true;
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public function restore($table, $id, $userId)
{
    $this->validateTable($table);

    $estado = Status::ACTIVO;

    $stmt = $this->db->prepare("
        UPDATE {$table}
        SET 
            estado = ?,
            deleted_at = NULL,
            deleted_by = NULL,
            updated_at = NOW(),
            updated_by = ?
        WHERE id = ? 
        AND deleted_at IS NOT NULL
    ");

    if (!$stmt) {
        throw new Exception("Error preparando restore");
    }

    $stmt->bind_param("iii", $estado, $userId, $id);

    if (!$stmt->execute()) {
        throw new Exception("Error al restaurar");
    }

    //  VALIDACIÓN REAL
    if ($stmt->affected_rows === 0) {
        throw new Exception("El registro no estaba eliminado o no existe");
    }

    return true;
}

    // ======================================================
    // VALIDAR USO (RELACIONES)
    // ======================================================
    public function isUsed($table, $id)
    {
        $relations = [
            'fabric_types' => ['table' => 'products', 'field' => 'fabric_type_id'],
            'fabric_colors' => ['table' => 'products', 'field' => 'fabric_color_id'],
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

    // ======================================================
    // LISTAR CON USO
    // ======================================================
    public function getAllWithUsage($table, $includeDeleted = false)
    {
        $data = $this->getAll($table, $includeDeleted);

        foreach ($data as &$row) {
            $row['is_used'] = $this->isUsed($table, $row['id']);
        }

        return $data;
    }

    public function updateEstado($table, $id, $estado)
    {
        $stmt = $this->db->prepare("
        UPDATE $table 
        SET estado=? 
        WHERE id=?
    ");

        $stmt->bind_param("ii", $estado, $id);
        return $stmt->execute();
    }

    public function isUsedRelation($table, $field, $id)
    {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) as total
        FROM {$table}
        WHERE {$field} = ?
    ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();

        return $result['total'] > 0;
    }
}
