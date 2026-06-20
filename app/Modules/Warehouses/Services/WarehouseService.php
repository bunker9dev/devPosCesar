<?php

namespace App\Modules\Warehouses\Services;

use App\Core\Status;
use App\Core\Repositories\AuditLogRepository;
use Exception;

class WarehouseService
{
    private $model;
    private $audit;

    public function __construct($model, $db)
    {
        $this->model = $model;
        $this->audit = new AuditLogRepository($db);
    }

    public function getAll($includeDeleted = false)
    {
        return $this->model->getAll($includeDeleted);
    }

    public function create($data, $userId)
    {
        $nombre = trim($data['nombre'] ?? '');
        $ubicacion = trim($data['ubicacion'] ?? '');

        if (!$nombre) {
            throw new Exception("El nombre es obligatorio");
        }

        $deleted = $this->model->findDeletedByNombre($nombre);

        if ($deleted) {
            $this->model->restore($deleted['id'], $userId);

            $this->audit->log([
                'usuario_id' => $userId,
                'accion'     => 'restore_auto',
                'entidad'    => 'warehouses',
                'entidad_id' => $deleted['id'],
                'modulo'     => 'inventory',
                'detalle'    => ['reason' => 'auto-restore on create'],
            ]);

            return $deleted['id'];
        }

        if ($this->model->existsByNombre($nombre)) {
            throw new Exception("El nombre ya existe");
        }

        $id = $this->model->create([
            'codigo'    => $this->generateCode(),
            'nombre'    => $nombre,
            'ubicacion' => $ubicacion,
            'user_id'   => $userId,
        ]);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'create',
            'entidad'    => 'warehouses',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => ['after' => ['nombre' => $nombre, 'ubicacion' => $ubicacion]],
        ]);

        return $id;
    }

    public function update($id, $data, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("No existe");
        }

        if ((int)$row['estado'] === Status::ELIMINADO) {
            throw new Exception("No se puede editar un registro eliminado");
        }

        $nombre = trim($data['nombre'] ?? '');
        $ubicacion = trim($data['ubicacion'] ?? '');

        if (!$nombre) {
            throw new Exception("El nombre es obligatorio");
        }

        if ($this->model->existsByNombre($nombre, $id)) {
            throw new Exception("El nombre ya existe");
        }

        $this->model->update($id, [
            'nombre'    => $nombre,
            'ubicacion' => $ubicacion,
            'user_id'   => $userId,
        ]);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'update',
            'entidad'    => 'warehouses',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => [
                'before' => ['nombre' => $row['nombre'], 'ubicacion' => $row['ubicacion']],
                'after'  => ['nombre' => $nombre, 'ubicacion' => $ubicacion],
            ],
        ]);

        return true;
    }

    public function toggle($id, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("No existe");
        }

        if ((int)$row['estado'] === Status::ELIMINADO) {
            throw new Exception("No se puede modificar un registro eliminado");
        }

        $nuevo = (int)$row['estado'] === Status::ACTIVO ? Status::INACTIVO : Status::ACTIVO;

        $this->model->updateEstado($id, $nuevo, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'toggle',
            'entidad'    => 'warehouses',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => ['before' => $row['estado'], 'after' => $nuevo],
        ]);

        return $nuevo;
    }

    public function delete($id, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("No existe");
        }

        if ((int)$row['estado'] === Status::ELIMINADO) {
            throw new Exception("Ya está eliminado");
        }

        if ($this->model->isUsed($id)) {
            throw new Exception("La bodega está en uso y no se puede eliminar");
        }

        $this->model->delete($id, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'delete',
            'entidad'    => 'warehouses',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => ['nombre' => $row['nombre']],
        ]);

        return true;
    }

    public function restore($id, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("No existe");
        }

        if ((int)$row['estado'] !== Status::ELIMINADO) {
            throw new Exception("No está eliminado");
        }

        $this->model->restore($id, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'restore',
            'entidad'    => 'warehouses',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => ['nombre' => $row['nombre']],
        ]);

        return true;
    }

    private function generateCode()
    {
        $last = $this->model->getLastCode();

        if (!$last) {
            return 'BOD-001';
        }

        preg_match('/(\d+)$/', $last, $m);

        $num = isset($m[1]) ? (int)$m[1] + 1 : 1;

        return 'BOD-' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }
}