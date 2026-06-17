<?php

namespace App\Modules\Suppliers\Services;

use App\Core\Status;
use App\Core\Repositories\AuditLogRepository;
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
        $this->normalize($data);
        $this->validate($data);

        $id = $this->model->create($data);

        // AUDITORÍA 
        (new AuditLogRepository($this->db))->log([
            'usuario_id' => $_SESSION['user']['id'] ?? null,
            'accion'     => 'create',
            'entidad'    => 'proveedores',
            'entidad_id' => $id,
            'modulo'     => 'suppliers',
            'detalle'    => [
                'after' => $data
            ]
        ]);

        return $id;
    }

    // ======================================================
    // ACTUALIZAR
    // ======================================================
    public function update($id, $data)
    {
        $supplier = $this->model->find($id);

        if (!$supplier) {
            throw new Exception("Proveedor no existe");
        }

        if ($supplier['estado'] == Status::ELIMINADO) {
            throw new Exception("No se puede editar un proveedor eliminado");
        }

        $this->normalize($data);
        $this->validate($data, $id);

        $this->model->update($id, $data);

        (new AuditLogRepository($this->db))->log([
            'usuario_id' => $_SESSION['user']['id'] ?? null,
            'accion'     => 'update',
            'entidad'    => 'proveedores',
            'entidad_id' => $id,
            'modulo'     => 'suppliers',
            'detalle'    => [
                'before' => $supplier,
                'after'  => $data
            ]
        ]);

        return true;
    }

    // ======================================================
    // TOGGLE
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

        $this->model->updateEstado($id, $nuevoEstado, $userId);

        (new AuditLogRepository($this->db))->log([
            'usuario_id' => $userId,
            'accion'     => 'toggle',
            'entidad'    => 'proveedores',
            'entidad_id' => $id,
            'modulo'     => 'suppliers',
            'detalle'    => [
                'estado_anterior' => $supplier['estado'],
                'estado_nuevo'    => $nuevoEstado
            ]
        ]);

        return $nuevoEstado;
    }

    // ======================================================
    // DELETE  (SOFT)
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

        if ($this->hasPurchases($id)) {
            throw new Exception("No se puede eliminar, tiene compras asociadas");
        }

        $this->model->delete($id, $userId);

        (new AuditLogRepository($this->db))->log([
            'usuario_id' => $userId,
            'accion'     => 'delete',
            'entidad'    => 'proveedores',
            'entidad_id' => $id,
            'modulo'     => 'suppliers',
            'detalle'    => [
                'before' => $supplier
            ]
        ]);

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

        $this->model->restore($id, $userId);

        (new AuditLogRepository($this->db))->log([
            'usuario_id' => $userId,
            'accion'     => 'restore',
            'entidad'    => 'proveedores',
            'entidad_id' => $id,
            'modulo'     => 'suppliers',
            'detalle'    => [
                'after' => $supplier
            ]
        ]);

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
    // VALIDAR COMPRAS
    // ======================================================
    private function hasPurchases($id): bool
    {
        $stmt = $this->db->prepare("
            SELECT id FROM purchases WHERE supplier_id = ? LIMIT 1
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    // ======================================================
    // NORMALIZAR
    // ======================================================
    private function normalize(&$data)
    {
        $data['nit'] = strtolower(trim($data['nit'] ?? ''));
        $data['email'] = strtolower(trim($data['email'] ?? ''));
        $data['nombre'] = trim($data['nombre'] ?? '');
        $data['telefono'] = trim($data['telefono'] ?? '');
        $data['ciudad'] = trim($data['ciudad'] ?? '');
    }

    // ======================================================
    // VALIDAR
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

        if (!empty($data['nit']) && strlen($data['nit']) < 5) {
            $errors['nit'] = "NIT inválido";
        }

        if (!empty($data['nit']) && $this->existsByNit($data['nit'], $id)) {
            $errors['nit'] = "El NIT ya está registrado";
        }

        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email inválido";
        }

        if (!empty($data['telefono']) && strlen($data['telefono']) < 7) {
            $errors['telefono'] = "Teléfono inválido";
        }

        if (!empty($errors)) {
            throw new Exception(json_encode($errors));
        }
    }
}