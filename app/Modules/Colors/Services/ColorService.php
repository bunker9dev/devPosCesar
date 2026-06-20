<?php

namespace App\Modules\Colors\Services;

use App\Core\Status;
use App\Core\Repositories\AuditLogRepository;
use Exception;

class ColorService
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
        $this->normalize($data);

        if (empty($data['nombre'])) {
            throw new Exception("El nombre es obligatorio");
        }

        $data['user_id'] = $userId;

        // Si existe eliminado con el mismo nombre → restaurar
        $deleted = $this->model->findDeletedByNombre($data['nombre']);

        if ($deleted) {
            $this->model->restore($deleted['id'], $userId);

            $this->audit->log([
                'usuario_id' => $userId,
                'accion'     => 'restore_auto',
                'entidad'    => 'fabric_colors',
                'entidad_id' => $deleted['id'],
                'modulo'     => 'inventory',
                'detalle'    => ['reason' => 'auto-restore on create'],
            ]);

            return $deleted['id'];
        }

        if ($this->model->existsByNombre($data['nombre'])) {
            throw new Exception("El color ya existe");
        }

        $data['codigo'] = $this->generateCode();

        $id = $this->model->create($data);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'create',
            'entidad'    => 'fabric_colors',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => ['after' => $data],
        ]);

        return $id;
    }

    public function update($id, $data, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("Registro no existe");
        }

        if ($row['estado'] == Status::ELIMINADO) {
            throw new Exception("No se puede editar un registro eliminado");
        }

        $this->normalize($data);

        if (empty($data['nombre'])) {
            throw new Exception("El nombre es obligatorio");
        }

        if ($this->model->existsByNombre($data['nombre'], $id)) {
            throw new Exception("El color ya existe");
        }

        $data['user_id'] = $userId;

        $this->model->update($id, $data);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'update',
            'entidad'    => 'fabric_colors',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => [
                'before' => ['nombre' => $row['nombre']],
                'after'  => ['nombre' => $data['nombre']],
            ],
        ]);

        return true;
    }

    public function toggle($id, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("Registro no existe");
        }

        if ($row['estado'] == Status::ELIMINADO) {
            throw new Exception("No se puede modificar un registro eliminado");
        }

        $nuevoEstado = $row['estado'] == Status::ACTIVO
            ? Status::INACTIVO
            : Status::ACTIVO;

        $this->model->updateEstado($id, $nuevoEstado, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'toggle',
            'entidad'    => 'fabric_colors',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => ['before' => $row['estado'], 'after' => $nuevoEstado],
        ]);

        return $nuevoEstado;
    }

    public function delete($id, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("Registro no existe");
        }

        if ($row['estado'] == Status::ELIMINADO) {
            throw new Exception("Ya está eliminado");
        }

        if ($this->model->isUsed($id)) {
            throw new Exception("El color está en uso y no se puede eliminar");
        }

        $this->model->delete($id, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'delete',
            'entidad'    => 'fabric_colors',
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
            throw new Exception("Registro no existe");
        }

        if ($row['estado'] != Status::ELIMINADO) {
            throw new Exception("No está eliminado");
        }

        $this->model->restore($id, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'restore',
            'entidad'    => 'fabric_colors',
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
            return 'COL-001';
        }

        preg_match('/(\d+)$/', $last, $matches);

        $num = isset($matches[1]) ? (int)$matches[1] + 1 : 1;

        return 'COL-' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    private function normalize(&$data)
    {
        $data['nombre'] = strtolower(trim($data['nombre'] ?? ''));
    }
}