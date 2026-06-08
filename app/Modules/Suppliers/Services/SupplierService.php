<?php

namespace App\Modules\Suppliers\Services;

use App\Core\Status;
use App\Services\CatalogService;
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

        CatalogService::audit(
            "CREATE",
            "proveedores",
            $id,
            "Proveedor creado: {$data['nombre']}",
            "suppliers",
            $_SESSION['user']['id'] ?? null
        );

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

        CatalogService::audit(
            "UPDATE",
            "proveedores",
            $id,
            "Proveedor actualizado: {$data['nombre']}",
            "suppliers",
            $_SESSION['user']['id'] ?? null
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

        CatalogService::audit(
            "TOGGLE",
            "proveedores",
            $id,
            "Estado {$supplier['estado']} → {$nuevoEstado}",
            "suppliers",
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

        // 🔥 VALIDACIÓN DE NEGOCIO
        if ($this->hasPurchases($id)) {
            throw new Exception("No se puede eliminar, tiene compras asociadas");
        }

        $this->model->delete($id);

        CatalogService::audit(
            "DELETE",
            "proveedores",
            $id,
            "Proveedor eliminado: {$supplier['nombre']}",
            "suppliers",
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

        CatalogService::audit(
            "RESTORE",
            "proveedores",
            $id,
            "Proveedor restaurado: {$supplier['nombre']}",
            "suppliers",
            $userId
        );

        return true;
    }

    // ======================================================
    // VALIDAR NIT
    // ======================================================
    public function existsByNit($nit, $excludeId = null)
    {
        return CatalogService::exists('proveedores', 'nit', $nit, $excludeId);
    }

    // ======================================================
    // VALIDAR SI TIENE COMPRAS
    // ======================================================
    private function hasPurchases($id): bool
    {
        $stmt = $this->db->prepare("
            SELECT id FROM purchases WHERE proveedor_id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    // ======================================================
    // NORMALIZAR DATOS
    // ======================================================
    private function normalize(&$data)
    {
        $data['nit'] = strtolower(trim($data['nit'] ?? ''));
        $data['email'] = strtolower(trim($data['email'] ?? ''));
        $data['nombre'] = trim($data['nombre'] ?? '');
        $data['contacto'] = trim($data['contacto'] ?? '');
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
        if (!empty($data['nit']) && $this->existsByNit($data['nit'], $id)) {
            $errors['nit'] = "El NIT ya está registrado";
        }

        // 🔥 VALIDACIÓN EMAIL
        if (!empty($data['email'])) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email inválido";
            }

            if (CatalogService::exists('proveedores', 'email', $data['email'], $id)) {
                $errors['email'] = "Email ya registrado";
            }
        }

        // 🔥 TELÉFONO
        if (!empty($data['telefono']) && strlen($data['telefono']) < 7) {
            $errors['telefono'] = "Teléfono inválido";
        }

        // 🔥 NIT LÓGICO
        if (!empty($data['nit']) && strlen($data['nit']) < 5) {
            $errors['nit'] = "NIT inválido";
        }

        if (!empty($errors)) {
            throw new Exception(json_encode([
                'type' => 'validation',
                'errors' => $errors
            ]));
        }
    }
}