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

    public function getAll()
    {
        return $this->model->getAll();
    }

    public function create($data, $userId)
    {
        $nombre = trim($data['nombre']);

        if (!$nombre) {
            throw new Exception("Nombre obligatorio");
        }

        $deleted = $this->model->findDeletedByNombre($nombre);

        if ($deleted) {
            $this->model->restore($deleted['id']);

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

        return $id;
    }

    public function update($id, $data, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("No existe");
        }

        if ($this->model->existsByNombre($data['nombre'], $id)) {
            throw new Exception("Duplicado");
        }

        $this->model->update($id, $data);
    }

    public function toggle($id, $userId)
    {
        $row = $this->model->find($id);

        $new = $row['estado'] == 1 ? 2 : 1;

        $this->model->updateEstado($id, $new);

        return $new;
    }

    public function delete($id, $userId)
    {
        $this->model->delete($id);
        return true;
    }

    public function restore($id, $userId)
    {
        $this->model->restore($id);
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