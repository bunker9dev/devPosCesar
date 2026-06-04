<?php

namespace App\Modules\Suppliers\Services;

use App\Core\Status;
use Exception;

class SupplierService
{
    private $model;
    private $db;

    public function __construct($model, $db)
    {
        $this->model = $model;
        $this->db = $db;
    }

    // ======================================================
    // LISTAR
    // ======================================================
    public function getAll($isSuper = false)
    {
        return $this->model->getAll($isSuper);
    }

    // ======================================================
    // BUSCAR
    // ======================================================
    public function find($id)
    {
        return $this->model->find($id);
    }

    // ======================================================
    // CREAR
    // ======================================================
    public function create($data)
    {
        $this->validate($data);

        $id = $this->model->create($data);

        // 🧠 AUDITORÍA
        $this->audit(
            "CREATE",
            $id,
            "Proveedor creado: {$data['nombre']}"
        );

        return $id;
    }

    // ======================================================
    // ACTUALIZAR
    // ======================================================
    public function update($id, $data)
    {
        $this->validate($data, $id);

        $this->model->update($id, $data);

        $this->audit(
            "UPDATE",
            $id,
            "Proveedor actualizado: {$data['nombre']}"
        );

        return true;
    }

    // ======================================================
    // TOGGLE ESTADO
    // ======================================================
    public function toggle($id, $userId)
    {
        $supplier = $this->model->find($id);

        if (!$supplier) {
            throw new Exception("Proveedor no existe");
        }

        if ($supplier['estado'] == Status::ELIMINADO) {
            throw new Exception("No se puede modificar un eliminado");
        }

        $nuevoEstado = $supplier['estado'] == Status::ACTIVO
            ? Status::INACTIVO
            : Status::ACTIVO;

        $this->model->updateEstado($id, $nuevoEstado);

        $this->audit(
            "TOGGLE",
            $id,
            "Estado {$supplier['estado']} → {$nuevoEstado}",
            $userId
        );

        return $nuevoEstado;
    }

    // ======================================================
    // DELETE (SOFT)
    // ======================================================
    public function delete($id, $userId)
    {
        $supplier = $this->model->find($id);

        if (!$supplier) {
            throw new Exception("Proveedor no existe");
        }

        if ($supplier['estado'] == Status::ELIMINADO) {
            throw new Exception("Ya está eliminado");
        }

        $this->model->delete($id);

        $this->audit(
            "DELETE",
            $id,
            "Proveedor eliminado: {$supplier['nombre']}",
            $userId
        );

        return true;
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public function restore($id, $userId)
    {
        $supplier = $this->model->find($id);

        if (!$supplier) {
            throw new Exception("Proveedor no existe");
        }

        if ($supplier['estado'] != Status::ELIMINADO) {
            throw new Exception("El proveedor no está eliminado");
        }

        $this->model->restore($id);

        $this->audit(
            "RESTORE",
            $id,
            "Proveedor restaurado: {$supplier['nombre']}",
            $userId
        );

        return true;
    }

    // ======================================================
    // VALIDAR NIT
    // ======================================================
    public function existsByNit($nit, $excludeId = null)
    {
        return $this->model->existsByNit($nit, $excludeId);
    }

    // ======================================================
    // VALIDACIONES CENTRALIZADAS
    // ======================================================
    private function validate($data, $id = null)
    {
        $errors = [];

        if (empty($data['nombre'])) {
            $errors['nombre'] = "El nombre es obligatorio";
        }

        if (empty($data['nit'])) {
            $errors['nit'] = "El NIT es obligatorio";
        }

        // 🔥 NIT ÚNICO
        if (!empty($data['nit']) && $this->model->existsByNit($data['nit'], $id)) {
            $errors['nit'] = "El NIT ya está registrado";
        }

        if (!empty($data['telefono']) && strlen($data['telefono']) < 7) {
            $errors['telefono'] = "Teléfono inválido";
        }

        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email inválido";
        }

        if (!empty($errors)) {
            throw new Exception(json_encode($errors));
        }
    }

    // ======================================================
    // AUDITORÍA CENTRALIZADA
    // ======================================================
    private function audit($accion, $id, $detalle, $userId = null)
    {
        $userId = $userId ?? ($_SESSION['user']['id'] ?? null);

        if (!$userId) return;

        auditoria(
            $accion,
            "proveedores",
            $id,
            $detalle,
            "suppliers"
        );
    }
}