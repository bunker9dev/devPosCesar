<?php

namespace App\Modules\Suppliers\Services;

use Exception;

class SupplierService
{
    private $model;

    public function __construct($model, $db)
    {
        $this->model = $model;
    }

    // 🔍 LISTAR
    public function getAll($isSuper)
    {
        return $this->model->getAll($isSuper);
    }

    // 💾 CREAR
    public function create($data)
    {
        $errors = [];

        $nombreRaw    = trim($data['nombre'] ?? '');
        $apellidosRaw = trim($data['apellidos'] ?? '');
        $nitRaw       = trim($data['nit'] ?? '');
        $ciudadRaw    = trim($data['ciudad'] ?? '');

        // 🔥 VALIDACIONES
        if (!$nombreRaw) {
            $errors['nombre'] = "El nombre es obligatorio";
        }

        if (!$nitRaw) {
            $errors['nit'] = "El NIT es obligatorio";
        }

        if (!empty($nitRaw) && !ctype_digit(preg_replace('/\D/', '', $nitRaw))) {
            $errors['nit'] = "El NIT debe ser numérico";
        }

        if (!empty($errors)) {
            throw new Exception(json_encode($errors));
        }

        // 🔥 NORMALIZAR
        $data = $this->normalizarProveedor($data);

        $nombre = $data['nombre'];
        $nit    = $data['nit'];

        if ($this->model->existsByNit($nit)) {
            throw new Exception(json_encode([
                'nit' => "Ya existe un proveedor con ese NIT"
            ]));
        }

        $id = $this->model->create($data);

        auditoria(
            'CREAR',
            'proveedores',
            $id,
            "Creó proveedor {$nombre}",
            'suppliers'
        );

        return $id;
    }

    // ✏️ ACTUALIZAR
    public function update($id, $data)
    {
        $errors = [];

        $nombreRaw    = trim($data['nombre'] ?? '');
        $apellidosRaw = trim($data['apellidos'] ?? '');
        $nitRaw       = trim($data['nit'] ?? '');

        if (!$nombreRaw) {
            $errors['nombre'] = "El nombre es obligatorio";
        }

        if (!$nitRaw) {
            $errors['nit'] = "El NIT es obligatorio";
        }

        if (!empty($nitRaw) && !ctype_digit(preg_replace('/\D/', '', $nitRaw))) {
            $errors['nit'] = "El NIT debe ser numérico";
        }

        if (!empty($errors)) {
            throw new Exception(json_encode($errors));
        }

        $data = $this->normalizarProveedor($data);

        $nombre = $data['nombre'];
        $nit    = $data['nit'];

        $prov = $this->model->find($id);

        if (!$prov) {
            throw new Exception("Proveedor no existe");
        }

        if ($prov['nit'] !== $nit && $this->model->existsByNit($nit, $id)) {
            throw new Exception(json_encode([
                'nit' => "Ya existe otro proveedor con ese NIT"
            ]));
        }

        $this->model->update($id, $data);

        auditoria(
            'EDITAR',
            'proveedores',
            $id,
            "Actualizó proveedor {$nombre}",
            'suppliers'
        );

        return true;
    }

    // 🔄 CAMBIAR ESTADO
    public function toggle($id, $userId)
    {
        $prov = $this->model->find($id);

        if (!$prov) {
            throw new Exception("Proveedor no existe");
        }

        if ($prov['estado'] == 0) {
            throw new Exception("No se puede modificar un proveedor eliminado");
        }

        $nuevo = ($prov['estado'] == 1) ? 2 : 1;

        $this->model->updateEstado($id, $nuevo);

        auditoria(
            'ESTADO',
            'proveedores',
            $id,
            "Cambio estado a {$nuevo}",
            'suppliers'
        );

        return $nuevo;
    }

    // 🗑️ ELIMINAR
    public function delete($id, $userId)
    {
        $prov = $this->model->find($id);

        if (!$prov) {
            throw new Exception("Proveedor no existe");
        }

        $this->model->delete($id);

        auditoria(
            'ELIMINAR',
            'proveedores',
            $id,
            "Eliminó proveedor {$prov['nombre']}",
            'suppliers'
        );

        return true;
    }

    // ♻️ RESTAURAR
    public function restore($id, $userId)
    {
        $prov = $this->model->find($id);

        if (!$prov) {
            throw new Exception("Proveedor no existe");
        }

        $this->model->restore($id);

        auditoria(
            'RESTAURAR',
            'proveedores',
            $id,
            "Restauró proveedor {$prov['nombre']}",
            'suppliers'
        );

        return true;
    }

    // 🔍 VALIDAR NIT (AJAX)
    public function existsByNit($nit, $excludeId = null)
    {
        $nit = $this->normalizarNit($nit);
        return $this->model->existsByNit($nit, $excludeId);
    }

    // =========================
    // 🔥 NORMALIZACIÓN
    // =========================

    private function normalizarProveedor($data)
    {
        $data['nombre']    = $this->normalizarTexto($data['nombre'] ?? '');
        $data['apellidos'] = $this->normalizarTexto($data['apellidos'] ?? '');
        $data['ciudad']    = $this->normalizarCiudad($data['ciudad'] ?? '');
        $data['nit']       = $this->normalizarNit($data['nit'] ?? '');
        $data['email']     = trim($data['email'] ?? '');
        $data['telefono']  = $this->normalizarNit($data['telefono'] ?? '');

        return $data;
    }

    private function normalizarTexto($texto)
    {
        $texto = trim($texto);

        $texto = preg_replace('/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\.\-&]/', '', $texto);

        $texto = mb_strtolower($texto, 'UTF-8');

        return mb_convert_case($texto, MB_CASE_TITLE, "UTF-8");
    }

    private function normalizarCiudad($ciudad)
    {
        $ciudad = trim($ciudad);
        $ciudad = mb_strtolower($ciudad, 'UTF-8');

        $map = [
            'medellin' => 'Medellín',
            'bogota' => 'Bogotá',
            'cali' => 'Cali'
        ];

        return $map[$ciudad] ?? ucfirst($ciudad);
    }

    private function normalizarNit($nit)
    {
        return preg_replace('/[^0-9]/', '', $nit);
    }
}
