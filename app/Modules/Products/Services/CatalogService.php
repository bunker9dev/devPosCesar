<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Repositories\CatalogRepository;

class CatalogService
{
    private $repo;

    public function __construct()
    {
        $this->repo = new CatalogRepository();
    }

    public function getAll($table)
    {
        return $this->repo->getAll($table);
    }

    public function create($table, $nombre)
    {
        if (empty($nombre)) {
            throw new \Exception("El nombre es obligatorio");
        }
         // sanitizar
        $nombre = ucfirst(trim(strtolower($nombre)));

        // validar duplicado
        if ($this->repo->exists($table, $nombre)) {
            throw new \Exception("El registro ya existe");
        }
         // generar código
        $codigo = $this->repo->nextCode($table);

         // guardar
        $this->repo->create($table, $codigo, $nombre);

         // auditoría
        auditoria(
            'create',
            $table,
            null,
            "Creó: $nombre ($codigo)",
            'products'
        );
    }

    public function delete($table, $id)
    {
        $this->repo->softDelete($table, $id);

        auditoria(
            'delete',
            $table,
            $id,
            "Eliminó ID $id",
            'products'
        );
    }

    public function restore($table, $id)
    {
        $this->repo->restore($table, $id);

        auditoria(
            'restore',
            $table,
            $id,
            "Restauró ID $id",
            'products'
        );
    }
}