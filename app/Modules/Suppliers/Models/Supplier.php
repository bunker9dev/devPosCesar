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
                apellidos,
                CONCAT(nombre, ' ', IFNULL(apellidos, '')) AS nombre_completo,
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
            SELECT * FROM proveedores WHERE id=?
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
                SELECT id FROM proveedores WHERE nit=? AND id<>?
            ");
            $stmt->bind_param("si", $nit, $excludeId);
        } else {
            $stmt = $this->db->prepare("
                SELECT id FROM proveedores WHERE nit=?
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
        // 🔒 VALIDACIÓN
        if (empty($data['nombre']) || empty($data['nit'])) {
            throw new Exception(json_encode([
                'general' => 'Nombre y NIT son obligatorios'
            ]));
        }

        //  NIT ÚNICO
        if ($this->existsByNit($data['nit'])) {
            throw new Exception(json_encode([
                'nit' => 'El NIT ya está registrado'
            ]));
        }

        //  CAMPOS OPCIONALES
        $apellidos = $data['apellidos'] ?? null;
        $email     = $data['email'] ?? null;
        $telefono  = $data['telefono'] ?? null;
        $ciudad    = $data['ciudad'] ?? null;

        $estado = Status::ACTIVO;

        $stmt = $this->db->prepare("
            INSERT INTO proveedores 
            (nombre, apellidos, nit, email, telefono, ciudad, estado, created_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssssii",
            $data['nombre'],
            $apellidos,
            $data['nit'],
            $email,
            $telefono,
            $ciudad,
            $estado,
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
        if (empty($data['nombre']) || empty($data['nit'])) {
            throw new Exception(json_encode([
                'general' => 'Nombre y NIT son obligatorios'
            ]));
        }

        // VALIDAR NIT ÚNICO (EXCLUYENDO EL MISMO)
        if ($this->existsByNit($data['nit'], $id)) {
            throw new Exception(json_encode([
                'nit' => 'El NIT ya está registrado'
            ]));
        }

        $apellidos = $data['apellidos'] ?? null;
        $email     = $data['email'] ?? null;
        $telefono  = $data['telefono'] ?? null;
        $ciudad    = $data['ciudad'] ?? null;

        $stmt = $this->db->prepare("
            UPDATE proveedores 
            SET nombre=?, apellidos=?, nit=?, email=?, telefono=?, ciudad=?, updated_by=?, updated_at=NOW()
            WHERE id=?
        ");

        $stmt->bind_param(
            "ssssssii",
            $data['nombre'],
            $apellidos,
            $data['nit'],
            $email,
            $telefono,
            $ciudad,
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
            UPDATE proveedores SET estado=? WHERE id=?
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
    public function delete($id)
    {
        return $this->updateEstado($id, Status::ELIMINADO);
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public function restore($id)
    {
        return $this->updateEstado($id, Status::ACTIVO);
    }
}