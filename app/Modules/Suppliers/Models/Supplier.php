<?php

namespace App\Modules\Suppliers\Models;

use Exception;

class Supplier
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // 🔍 LISTAR
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
            $query .= " WHERE estado IN (1,2)";
        }

        $query .= " ORDER BY estado ASC, created_at DESC";

        return $this->db->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    // 🔍 BUSCAR
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

    // 🔍 VALIDAR NIT
    public function existsByNit($nit)
    {
        $stmt = $this->db->prepare("
            SELECT id FROM proveedores WHERE nit=?
        ");

        $stmt->bind_param("s", $nit);

        if (!$stmt->execute()) {
            throw new Exception("Error validando NIT");
        }

        return $stmt->get_result()->num_rows > 0;
    }

    // 💾 CREAR
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO proveedores 
            (nombre, apellidos, nit, ciudad, estado, created_by)
            VALUES (?, ?, ?, ?, 1, ?)
        ");

        $stmt->bind_param(
            "ssssi",
            $data['nombre'],
            $data['apellidos'],
            $data['nit'],
            $data['ciudad'],
            $data['user_id']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al crear proveedor");
        }

        return $stmt->insert_id;
    }

    // ✏️ ACTUALIZAR
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE proveedores 
            SET nombre=?, apellidos=?, nit=?, ciudad=?, updated_by=?, updated_at=NOW()
            WHERE id=?
        ");

        $stmt->bind_param(
            "ssssii",
            $data['nombre'],
            $data['apellidos'],
            $data['nit'],
            $data['ciudad'],
            $data['user_id'],
            $id
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar proveedor");
        }

        return true;
    }

    // 🔄 CAMBIAR ESTADO
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

    // 🗑️ ELIMINAR (SOFT)
    public function delete($id)
    {
        return $this->updateEstado($id, 0);
    }

    // ♻️ RESTAURAR
    public function restore($id)
    {
        return $this->updateEstado($id, 1);
    }
}