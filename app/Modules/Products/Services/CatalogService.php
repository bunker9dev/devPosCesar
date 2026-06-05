<?php

namespace App\Modules\Products\Services;

use App\Core\Status;
use Exception;

class CatalogService
{
    private $db;

    // 🔥 TABLAS PERMITIDAS (SEGURIDAD)
    private $allowedTables = [
        'fabric_colors',
        'fabric_types',
        'warehouses'
    ];

    // 🔥 RELACIONES (FK)
    private $catalogMap = [
        'fabric_colors' => [
            'related' => 'products',
            'fk' => 'fabric_color_id'
        ],
        'fabric_types' => [
            'related' => 'products',
            'fk' => 'fabric_type_id'
        ]
    ];

    public function __construct()
    {
        global $db;
        $this->db = $db;
    }

    // ======================================================
    // 🔐 VALIDAR TABLA
    // ======================================================
    private function validateTable($table)
    {
        if (!in_array($table, $this->allowedTables)) {
            throw new Exception("Tabla no permitida");
        }
    }

    // ======================================================
    // 📋 LISTAR
    // ======================================================
    public function getAll($table, $includeDeleted = false)
    {
        $this->validateTable($table);

        $where = $includeDeleted ? "" : "WHERE estado <> " . Status::ELIMINADO;

        $query = "
            SELECT *
            FROM {$table}
            {$where}
            ORDER BY estado ASC, id DESC
        ";

        return $this->db->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    // ======================================================
    // ➕ CREAR
    // ======================================================
    public function create($table, $nombre)
    {
        $this->validateTable($table);

        $nombre = trim($nombre);

        if (!$nombre) {
            throw new Exception("El nombre es obligatorio");
        }

        if ($this->existsByName($table, $nombre)) {
            throw new Exception("El nombre ya existe");
        }

        $stmt = $this->db->prepare("
            INSERT INTO {$table} (nombre, estado, created_at)
            VALUES (?, ?, NOW())
        ");

        $estado = Status::ACTIVO;

        $stmt->bind_param("si", $nombre, $estado);

        if (!$stmt->execute()) {
            throw new Exception("Error al crear registro");
        }

        $id = $stmt->insert_id;

        $this->audit("CREATE", $table, $id, "Creó: {$nombre}");

        return $id;
    }

    // ======================================================
    // ✏️ ACTUALIZAR
    // ======================================================
    public function update($table, $id, $nombre)
    {
        $this->validateTable($table);

        $nombre = trim($nombre);

        if (!$id) {
            throw new Exception("ID inválido");
        }

        if (!$nombre) {
            throw new Exception("El nombre es obligatorio");
        }

        if ($this->existsByName($table, $nombre, $id)) {
            throw new Exception("El nombre ya existe");
        }

        $stmt = $this->db->prepare("
            UPDATE {$table}
            SET nombre=?, updated_at=NOW()
            WHERE id=?
        ");

        $stmt->bind_param("si", $nombre, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar");
        }

        $this->audit("UPDATE", $table, $id, "Actualizó a: {$nombre}");

        return true;
    }

    // ======================================================
    // 🔄 TOGGLE
    // ======================================================
    public function toggle($table, $id)
    {
        $this->validateTable($table);

        $stmt = $this->db->prepare("
            SELECT estado, nombre FROM {$table} WHERE id=?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();

        if (!$row) {
            throw new Exception("Registro no existe");
        }

        if ($row['estado'] == Status::ELIMINADO) {
            throw new Exception("No se puede modificar eliminado");
        }

        $nuevoEstado = $row['estado'] == Status::ACTIVO
            ? Status::INACTIVO
            : Status::ACTIVO;

        $stmt = $this->db->prepare("
            UPDATE {$table}
            SET estado=?
            WHERE id=?
        ");
        $stmt->bind_param("ii", $nuevoEstado, $id);
        $stmt->execute();

        $this->audit(
            "TOGGLE",
            $table,
            $id,
            "Estado {$row['estado']} → {$nuevoEstado}"
        );

        return $nuevoEstado;
    }

    // ======================================================
    // 🗑️ DELETE (SOFT + VALIDACIÓN FK)
    // ======================================================
    public function delete($table, $id)
    {
        $this->validateTable($table);

        // 🔥 VALIDAR RELACIÓN AUTOMÁTICA
        if (isset($this->catalogMap[$table])) {

            $rel = $this->catalogMap[$table];

            if ($this->isUsed($rel['related'], $rel['fk'], $id)) {
                throw new Exception("El registro está en uso");
            }
        }

        $stmt = $this->db->prepare("
            UPDATE {$table}
            SET estado=?, deleted_at=NOW()
            WHERE id=?
        ");

        $estado = Status::ELIMINADO;

        $stmt->bind_param("ii", $estado, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar");
        }

        $this->audit("DELETE", $table, $id, "Eliminado");

        return true;
    }

    // ======================================================
    // ♻️ RESTORE
    // ======================================================
    public function restore($table, $id)
    {
        $this->validateTable($table);

        $stmt = $this->db->prepare("
            UPDATE {$table}
            SET estado=?, deleted_at=NULL
            WHERE id=?
        ");

        $estado = Status::ACTIVO;

        $stmt->bind_param("ii", $estado, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al restaurar");
        }

        $this->audit("RESTORE", $table, $id, "Restaurado");

        return true;
    }

    // ======================================================
    // 🔍 VALIDAR USO (FK)
    // ======================================================
    private function isUsed($relatedTable, $fk, $id)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM {$relatedTable}
            WHERE {$fk} = ?
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();

        return $result['total'] > 0;
    }

    // ======================================================
    // 🔁 VALIDAR DUPLICADOS
    // ======================================================
    private function existsByName($table, $nombre, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->db->prepare("
                SELECT id FROM {$table}
                WHERE nombre=? AND id<>?
            ");
            $stmt->bind_param("si", $nombre, $excludeId);
        } else {
            $stmt = $this->db->prepare("
                SELECT id FROM {$table}
                WHERE nombre=?
            ");
            $stmt->bind_param("s", $nombre);
        }

        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    // ======================================================
    // 🧠 AUDITORÍA
    // ======================================================
    private function audit($accion, $tabla, $id, $detalle)
    {
        $user = $_SESSION['user']['username'] ?? 'Sistema';

        auditoria(
            $accion,
            $tabla,
            $id,
            "{$detalle} | Por: {$user}",
            "products"
        );
    }
}