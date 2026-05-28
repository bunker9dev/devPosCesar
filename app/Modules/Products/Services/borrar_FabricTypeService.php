<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Repositories\FabricTypeRepository;
use App\Modules\Products\Repositories\AuditLogRepository;

class FabricTypeService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new FabricTypeRepository();
    }

    public function getAll($table)
    {
        return $this->repo->getAllWithUsage($table);
    }

    public function create($nombre)
    {
        if (empty($nombre)) {
            throw new \Exception("El nombre es obligatorio");
        }

        $nombre = trim(strtolower($nombre));

        if ($this->repo->exists($nombre)) {
            throw new \Exception("El tipo de tela ya existe");
        }

        $codigo = $this->repo->nextCode();

        $this->repo->create($codigo, ucfirst($nombre));

        // 🔥 AUDITORÍA (tu modelo)
        auditoria(
            'create',
            'fabric_types',
            null,
            "Creó tipo de tela: " . ucfirst($nombre) . " ($codigo)",
            'products'
        );
    }

    public function delete($id)
    {
        // 👉 1. buscar datos antes de eliminar
        $data = $this->repo->find($id);

        // 👉 2. eliminar
        $this->repo->softDelete($id);

        // 👉 3. auditar
        auditoria(
            'delete',
            'fabric_types',
            $id,
            "Eliminó tipo: {$data['nombre']} ({$data['codigo']})",
            'products'
        );
    }

    public function restore($id)
    {
        $data = $this->repo->find($id);

        $this->repo->restore($id);

        auditoria(
            'restore',
            'fabric_types',
            $id,
            "Restauró tipo: {$data['nombre']} ({$data['codigo']})",
            'products'
        );
    }
}
