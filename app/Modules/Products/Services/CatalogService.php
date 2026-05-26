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
            throw new \Exception("Este tipo de tela ya existe");
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


    public function find($table, $id)
    {
        return $this->repo->find($table, $id);
    }

    public function update($table, $id, $nombre)
    {
        if (empty($nombre)) {
            throw new \Exception("El nombre es obligatorio");
        }

        $nombre = ucfirst(trim(strtolower($nombre)));

        // 🔥 VALIDAR DUPLICADO (EXCLUYENDO EL MISMO ID)
        if ($this->repo->existsExceptId($table, $nombre, $id)) {
            throw new \Exception("Este tipo de tela ya existe");
        }

        $this->repo->update($table, $id, $nombre);

        auditoria(
            'update',
            $table,
            $id,
            "Actualizó tipo: $nombre",
            'products'
        );
    }
}
