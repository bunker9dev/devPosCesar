<?php

namespace App\Modules\FabricTypes\Services;

use App\Modules\FabricTypes\Models\FabricTypeModel;
use App\Core\Repositories\AuditLogRepository;
use Exception;

class FabricTypeService
{
    private $model;
    private $audit;

    public function __construct($model, $db)
    {
        $this->model = $model;
        $this->audit = new AuditLogRepository($db);
    }

    public function getAll(bool $includeDeleted = false)
    {
        return $this->model->getAll($includeDeleted);
    }

    public function create($data, $userId)
    {
        $nombre = trim($data['nombre']);

        if (!$nombre) {
            throw new Exception("Nombre obligatorio");
        }

        $deleted = $this->model->findDeletedByNombre($nombre);

        if ($deleted) {
            $this->model->restore($deleted['id'], $userId);

            $this->audit->log([
                'usuario_id' => $userId,
                'accion'     => 'restore',
                'entidad'    => 'fabric_types',
                'entidad_id' => $deleted['id'],
                'modulo'     => 'inventory',
                'detalle'    => ['mensaje' => 'Restaurado automáticamente al recrear con el mismo nombre'],
            ]);

            return $deleted['id'];
        }

        if ($this->model->existsByNombre($nombre)) {
            throw new Exception("Ya existe");
        }

        $codigo = $this->generateCode();

        $id = $this->model->create([
            'codigo' => $codigo,
            'nombre' => $nombre
        ]);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'create',
            'entidad'    => 'fabric_types',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => ['after' => ['codigo' => $codigo, 'nombre' => $nombre]],
        ]);

        return $id;
    }

    public function update($id, $data, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("No existe");
        }

        $nombre = trim($data['nombre'] ?? '');

        if (!$nombre) {
            throw new Exception("Nombre obligatorio");
        }

        if ($this->model->isInUse($id)) {
            throw new Exception("No se puede modificar: el tipo de tela está en uso");
        }


        if ($this->model->existsByNombre($nombre, $id)) {
            throw new Exception("Nombre ya existe");
        }

        $this->model->update($id, ['nombre' => $nombre], $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'update',
            'entidad'    => 'fabric_types',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => [
                'before' => ['nombre' => $row['nombre']],
                'after'  => ['nombre' => $nombre],
            ],
        ]);
    }

    public function toggle($id, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("Registro no existe");
        }

        $new = $row['estado'] == 1 ? 2 : 1;

        $this->model->updateEstado($id, $new, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'toggle',
            'entidad'    => 'fabric_types',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => ['before' => $row['estado'], 'after' => $new],
        ]);

        return $new;
    }

    public function delete($id, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("No existe");
        }

        if ($this->model->isInUse($id)) {
            throw new Exception("No se puede eliminar: el tipo de tela está en uso");
        }


        $this->model->delete($id, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'delete',
            'entidad'    => 'fabric_types',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => ['before' => $row],
        ]);

        return true;
    }

    public function restore($id, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("No existe");
        }

        $this->model->restore($id, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'restore',
            'entidad'    => 'fabric_types',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => ['after' => $row],
        ]);

        return true;
    }

    private function generateCode()
    {
        $last = $this->model->getLastCode();

        if (!$last) return 'TEL-001';

        preg_match('/(\d+)$/', $last, $m);

        $num = (int)$m[1] + 1;

        return 'TEL-' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }
}
