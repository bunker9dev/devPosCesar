<?php

namespace App\Modules\Products\Services;

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

    // ==================================================
    // LISTAR
    // ==================================================
    public function getAll($isSuper = false)
    {
        return $this->model->getAll($isSuper);
    }

    // ==================================================
    // CREAR
    // ==================================================
    public function create($data)
    {
        $this->normalize($data);

        if (empty($data['nombre'])) {
            throw new Exception("El nombre es obligatorio");
        }

        //  1. SI EXISTE ELIMINADO → RESTAURAR
        $deleted = $this->model->findDeletedByNombre($data['nombre']);

        if ($deleted) {

            $this->model->restore(
                $deleted['id'],
                $_SESSION['user']['id']
            );

            $this->audit->log([
                'usuario_id' => $_SESSION['user']['id'] ?? null,
                'accion' => 'restore_auto',
                'entidad' => 'fabric_colors',
                'entidad_id' => $deleted['id'],
                'modulo' => 'products',
                'detalle' => [
                    'reason' => 'auto-restore on create'
                ]
            ]);

            return $deleted['id'];
        }

        // 2. SI EXISTE ACTIVO/INACTIVO → ERROR
        if ($this->model->existsByNombre($data['nombre'])) {
            throw new Exception("El color ya existe");
        }

        // 3. CREAR NUEVO
        $data['codigo'] = $this->generateCode();

        $id = $this->model->create($data);

        $this->audit->log([
            'usuario_id' => $_SESSION['user']['id'] ?? null,
            'accion' => 'create',
            'entidad' => 'fabric_colors',
            'entidad_id' => $id,
            'modulo' => 'products',
            'detalle' => [
                'after' => $data
            ]
        ]);

        return $id;
    }
    // ==================================================
    // UPDATE
    // ==================================================
    public function update($id, $data)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("Registro no existe");
        }

        if ($row['estado'] == Status::ELIMINADO) {
            throw new Exception("No se puede editar eliminado");
        }

        $before = $row;

        $this->normalize($data);
        $this->validateUpdate($data, $id);

        $this->model->update($id, $data);

        $this->audit->log([
            'usuario_id' => $_SESSION['user']['id'] ?? null,
            'accion' => 'update',
            'entidad' => 'fabric_colors',
            'entidad_id' => $id,
            'modulo' => 'products',
            'detalle' => [
                'before' => $before,
                'after'  => $data
            ]
        ]);

        return true;
    }

    // ==================================================
    // TOGGLE
    // ==================================================
    public function toggle($id, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("Registro no existe");
        }

        if ($row['estado'] == Status::ELIMINADO) {
            throw new Exception("No se puede modificar eliminado");
        }

        $nuevoEstado = $row['estado'] == Status::ACTIVO
            ? Status::INACTIVO
            : Status::ACTIVO;

        $this->model->updateEstado($id, $nuevoEstado, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion' => 'toggle',
            'entidad' => 'fabric_colors',
            'entidad_id' => $id,
            'modulo' => 'products',
            'detalle' => [
                'before' => $row['estado'],
                'after'  => $nuevoEstado
            ]
        ]);

        return $nuevoEstado;
    }

    // ==================================================
    // DELETE (SOFT)
    // ==================================================
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
            throw new Exception("El color está en uso");
        }

        $this->model->delete($id, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion' => 'delete',
            'entidad' => 'fabric_colors',
            'entidad_id' => $id,
            'modulo' => 'products',
            'detalle' => [
                'nombre' => $row['nombre']
            ]
        ]);

        return true;
    }

    // ==================================================
    // RESTORE
    // ==================================================
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
            'accion' => 'restore',
            'entidad' => 'fabric_colors',
            'entidad_id' => $id,
            'modulo' => 'products',
            'detalle' => [
                'nombre' => $row['nombre']
            ]
        ]);

        return true;
    }

    // ==================================================
    // VALIDACIÓN RESTAURAR
    // ==================================================

    private function validate($data, $excludeId = null)
    {
        if (empty($data['nombre'])) {
            throw new Exception("El nombre es obligatorio");
        }

        if ($this->model->existsByNombre($data['nombre'], $excludeId)) {
            throw new Exception("El color ya existe");
        }
    }

    // ==================================================
    // VALIDACIÓN CREAR
    // ==================================================
    private function validateCreate($data)
    {
        if (empty($data['nombre'])) {
            throw new Exception("El nombre es obligatorio");
        }

        if ($this->model->existsByNombre($data['nombre'])) {
            throw new Exception("El color ya existe");
        }
    }

    // ==================================================
    // VALIDACIÓN UPDATE
    // ==================================================
    private function validateUpdate($data, $id)
    {
        if (empty($data['nombre'])) {
            throw new Exception("El nombre es obligatorio");
        }

        if ($this->model->existsByNombre($data['nombre'], $id)) {
            throw new Exception("El color ya existe");
        }
    }

    // ==================================================
    // GENERAR CÓDIGO
    // ==================================================
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

    // ==================================================
    // NORMALIZAR
    // ==================================================
    private function normalize(&$data)
    {
        $data['nombre'] = strtolower(trim($data['nombre'] ?? ''));
    }
}
