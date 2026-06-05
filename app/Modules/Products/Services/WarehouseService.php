<?php

namespace App\Modules\Products\Services;

use App\Core\Status;
use Exception;

class WarehouseService extends CatalogService
{
    private $table = 'warehouses';

    // ======================================================
    // ➕ CREAR (EXTENDIDO)
    // ======================================================
    public function createWarehouse($data)
    {
        $nombre = trim($data['nombre'] ?? '');
        $ubicacion = trim($data['ubicacion'] ?? '');

        if (!$nombre) {
            throw new Exception("El nombre es obligatorio");
        }

        //  reutiliza validación base
        if ($this->existsByName($this->table, $nombre)) {
            throw new Exception("El nombre ya existe");
        }

        $stmt = $this->db->prepare("
            INSERT INTO {$this->table} 
            (nombre, ubicacion, estado, created_at)
            VALUES (?, ?, ?, NOW())
        ");

        $estado = Status::ACTIVO;

        $stmt->bind_param("ssi", $nombre, $ubicacion, $estado);

        if (!$stmt->execute()) {
            throw new Exception("Error al crear bodega");
        }

        $id = $stmt->insert_id;

        $this->audit("CREATE", $this->table, $id, "Creó bodega: {$nombre}");

        return $id;
    }

    // ======================================================
    //  ACTUALIZAR (EXTENDIDO)
    // ======================================================
    public function updateWarehouse($id, $data)
    {
        $nombre = trim($data['nombre'] ?? '');
        $ubicacion = trim($data['ubicacion'] ?? '');

        if (!$id) {
            throw new Exception("ID inválido");
        }

        if (!$nombre) {
            throw new Exception("El nombre es obligatorio");
        }

        if ($this->existsByName($this->table, $nombre, $id)) {
            throw new Exception("El nombre ya existe");
        }

        $stmt = $this->db->prepare("
            UPDATE {$this->table}
            SET nombre=?, ubicacion=?, updated_at=NOW()
            WHERE id=?
        ");

        $stmt->bind_param("ssi", $nombre, $ubicacion, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar bodega");
        }

        $this->audit("UPDATE", $this->table, $id, "Actualizó bodega: {$nombre}");

        return true;
    }

    // ======================================================
    //  LISTAR (OPCIONAL PERSONALIZADO)
    // ======================================================
    public function getAllWarehouses($includeDeleted = true)
    {
        return $this->getAll($this->table, $includeDeleted);
    }

    // ======================================================
    // DELETE
    // ======================================================
    public function deleteWarehouse($id)
    {
        return $this->delete($this->table, $id);
    }

    // ======================================================
    //  RESTORE
    // ======================================================
    public function restoreWarehouse($id)
    {
        return $this->restore($this->table, $id);
    }

    // ======================================================
    // TOGGLE
    // ======================================================
    public function toggleWarehouse($id)
    {
        return $this->toggle($this->table, $id);
    }
}