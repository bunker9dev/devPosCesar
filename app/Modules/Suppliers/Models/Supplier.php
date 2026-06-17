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
    // NORMALIZAR
    // ======================================================
    private function clean($value)
    {
        return trim($value ?? '');
    }

    private function cleanLower($value)
    {
        return strtolower(trim($value ?? ''));
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

        // 🔥 SOLO SUPER VE TODO (incluye eliminados)
        if (!$isSuper) {
            $query .= " WHERE estado IN (" . Status::ACTIVO . ", " . Status::INACTIVO . ")";
        }

        $query .= " ORDER BY created_at DESC";

        $result = $this->db->query($query);

        if (!$result) {
            throw new Exception("Error al obtener proveedores");
        }

        $data = $result->fetch_all(MYSQLI_ASSOC);

        // 🔥 NORMALIZAR TIPOS (CLAVE)
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
            SELECT * FROM proveedores 
            WHERE id = ? 
            LIMIT 1
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // ======================================================
    // VALIDAR NIT
    // ======================================================
    public function existsByNit($nit, $excludeId = null)
    {
        $nit = $this->cleanLower($nit);

        if ($excludeId) {
            $stmt = $this->db->prepare("
                SELECT id 
                FROM proveedores 
                WHERE LOWER(nit) = ? AND id <> ?
                LIMIT 1
            ");
            $stmt->bind_param("si", $nit, $excludeId);
        } else {
            $stmt = $this->db->prepare("
                SELECT id 
                FROM proveedores 
                WHERE LOWER(nit) = ?
                LIMIT 1
            ");
            $stmt->bind_param("s", $nit);
        }

        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    // ======================================================
    // CREAR
    // ======================================================
    public function create($data)
    {
        $nombre   = $this->clean($data['nombre']);
        $contacto = $this->clean($data['contacto'] ?? '');
        $nit      = $this->cleanLower($data['nit']);
        $email    = $data['email'] ?? null;
        $telefono = $data['telefono'] ?? null;
        $ciudad   = $data['ciudad'] ?? null;
        $estado   = $data['estado'] ?? Status::ACTIVO;
        $userId   = $data['user_id'];
        $ip       = $_SERVER['REMOTE_ADDR'] ?? null;
        $agent    = $_SERVER['HTTP_USER_AGENT'] ?? null;

        $stmt = $this->db->prepare("
    INSERT INTO proveedores 
    (nombre, contacto, nit, email, telefono, ciudad, estado, created_by, ip_address, user_agent, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
");

        $stmt->bind_param(
            "ssssssisss",
            $nombre,
            $contacto,
            $nit,
            $email,
            $telefono,
            $ciudad,
            $estado,
            $userId,
            $ip,
            $agent
        );

        try {
            $stmt->execute();
        } catch (\mysqli_sql_exception $e) {

            if ($e->getCode() == 1062) {
                throw new Exception("El NIT ya existe");
            }

            throw new Exception("Error al crear proveedor");
        }

        return $stmt->insert_id;
    }

    // ======================================================
    // ACTUALIZAR
    // ======================================================
    public function update($id, $data)
    {
        $nombre   = $this->clean($data['nombre']);
        $contacto = $this->clean($data['contacto'] ?? '');
        $nit      = $this->cleanLower($data['nit']);
        $email    = $data['email'] ?? null;
        $telefono = $data['telefono'] ?? null;
        $ciudad   = $data['ciudad'] ?? null;
        $userId   = $data['user_id'];

        $stmt = $this->db->prepare("
    UPDATE proveedores 
    SET nombre=?, contacto=?, nit=?, email=?, telefono=?, ciudad=?, updated_by=?, updated_at=NOW()
    WHERE id=?
");

        $stmt->bind_param(
            "ssssssii",
            $nombre,
            $contacto,
            $nit,
            $email,
            $telefono,
            $ciudad,
            $userId,
            $id
        );

        try {
            $stmt->execute();
        } catch (\mysqli_sql_exception $e) {

            if ($e->getCode() == 1062) {
                throw new Exception("El NIT ya existe");
            }

            throw new Exception("Error al actualizar proveedor");
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
        $stmt->execute();

        return true;
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public function restore($id, $userId)
    {
        $stmt = $this->db->prepare("
            UPDATE proveedores 
            SET estado=?, deleted_at=NULL, deleted_by=NULL, updated_by=?, updated_at=NOW()
            WHERE id=?
        ");

        $estado = Status::ACTIVO;

        $stmt->bind_param("iii", $estado, $userId, $id);
        $stmt->execute();

        return true;
    }

    // ======================================================
    // CAMBIAR ESTADO
    // ======================================================
    public function updateEstado($id, $estado, $userId)
    {
        $stmt = $this->db->prepare("
        UPDATE proveedores 
        SET estado=?, updated_by=?, updated_at=NOW()
        WHERE id=?
    ");

        $stmt->bind_param("iii", $estado, $userId, $id);

        if (!$stmt->execute()) {
            throw new \Exception("Error al cambiar estado del proveedor");
        }

        return true;
    }
}
