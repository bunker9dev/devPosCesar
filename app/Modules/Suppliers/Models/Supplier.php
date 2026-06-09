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
    // VALIDAR NIT
    // ======================================================
    public function existsByNit($nit, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->db->prepare("
                SELECT id FROM proveedores WHERE nit = ? AND id <> ?
            ");
            $stmt->bind_param("si", $nit, $excludeId);
        } else {
            $stmt = $this->db->prepare("
                SELECT id FROM proveedores WHERE nit = ?
            ");
            $stmt->bind_param("s", $nit);
        }

        if (!$stmt->execute()) {
            throw new Exception("Error validando NIT");
        }

        return $stmt->get_result()->num_rows > 0;
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

        // 🔥 FIX CLAVE: valores por defecto seguros
        $contacto = $data['contacto'] ?? '';
        $email = $data['email'] ?? null;
        $telefono = $data['telefono'] ?? null;
        $ciudad = $data['ciudad'] ?? null;
        $estado = $data['estado'] ?? Status::ACTIVO;

        $stmt->bind_param(
            "ssssssii",
            $data['nombre'],
            $contacto,
            $data['nit'],
            $email,
            $telefono,
            $ciudad,
            $estado,
            $data['user_id']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al crear proveedor: " . $stmt->error);
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

        $contacto = $data['contacto'] ?? '';
        $email = $data['email'] ?? null;
        $telefono = $data['telefono'] ?? null;
        $ciudad = $data['ciudad'] ?? null;

        $stmt->bind_param(
            "ssssssii",
            $data['nombre'],
            $contacto,
            $data['nit'],
            $email,
            $telefono,
            $ciudad,
            $data['user_id'],
            $id
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar proveedor: " . $stmt->error);
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