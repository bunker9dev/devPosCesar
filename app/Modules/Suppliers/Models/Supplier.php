<?php

namespace App\Modules\Suppliers\Models;

use Exception;
use App\Core\Status;

class Supplier
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // ======================================================
    // LISTAR
    // ======================================================
    public function getAll($isSuper)
    {
        $query = "
            SELECT 
                id,
                nombre,
                contacto,
                nit,
                ciudad,
                estado,
                created_at
            FROM proveedores
        ";

        if (!$isSuper) {
            $query .= " WHERE estado IN (" . Status::ACTIVO . "," . Status::INACTIVO . ")";
        }

        $query .= " ORDER BY estado ASC, created_at DESC";

        return $this->db->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    // ======================================================
    // BUSCAR
    // ======================================================
    public function find($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM proveedores WHERE id = ?
        ");

        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al obtener proveedor");
        }

        return $stmt->get_result()->fetch_assoc();
    }

    // ======================================================
    // CREAR
    // ======================================================
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO proveedores 
            (nombre, contacto, nit, email, telefono, ciudad, estado, created_by, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param(
            "ssssssii",
            $data['nombre'],
            $data['contacto'],
            $data['nit'],
            $data['email'],
            $data['telefono'],
            $data['ciudad'],
            $data['estado'],
            $data['user_id']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al crear proveedor");
        }

        return $stmt->insert_id;
    }

    // ======================================================
    // ACTUALIZAR
    // ======================================================
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE proveedores 
            SET nombre=?, contacto=?, nit=?, email=?, telefono=?, ciudad=?, updated_by=?, updated_at=NOW()
            WHERE id=?
        ");

        $stmt->bind_param(
            "ssssssii",
            $data['nombre'],
            $data['contacto'],
            $data['nit'],
            $data['email'],
            $data['telefono'],
            $data['ciudad'],
            $data['user_id'],
            $id
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar proveedor");
        }

        return true;
    }

    // ======================================================
    // CAMBIAR ESTADO
    // ======================================================
    public function updateEstado($id, $estado)
    {
        $stmt = $this->db->prepare("
            UPDATE proveedores 
            SET estado=?, updated_at=NOW()
            WHERE id=?
        ");

        $stmt->bind_param("ii", $estado, $id);

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
            UPDATE proveedores 
            SET estado=?, deleted_at=NOW(), deleted_by=?
            WHERE id=?
        ");

        $estado = Status::ELIMINADO;

        $stmt->bind_param("iii", $estado, $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar proveedor");
        }

        return true;
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public function restore($id)
    {
        $stmt = $this->db->prepare("
            UPDATE proveedores 
            SET estado=?, deleted_at=NULL, deleted_by=NULL
            WHERE id=?
        ");

        $estado = Status::ACTIVO;

        $stmt->bind_param("ii", $estado, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al restaurar proveedor");
        }

        return true;
    }
}