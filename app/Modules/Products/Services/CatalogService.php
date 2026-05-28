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

    // ================================
    // GET ALL
    // ================================
    public function getAll($table)
    {
        return $this->repo->getAll($table);
    }

    // ================================
    // CREATE
    // ================================
    public function create($table, $nombre)
    {
        if (empty($nombre)) {
            throw new \Exception("El nombre es obligatorio");
        }

        $nombre = ucfirst(trim(strtolower($nombre)));

        if ($this->repo->exists($table, $nombre)) {
            throw new \Exception("El registro ya existe");
        }

        $codigo = $this->repo->nextCode($table);

        $this->repo->create($table, $codigo, $nombre);

        auditoria(
            'create',
            $table,
            null,
            "Creó: $nombre ($codigo)",
            'products'
        );
    }

    // ================================
    // DELETE (SOFT)
    // ================================
    public function delete($table, $id)
    {
        if (!$id) {
            throw new \Exception("ID inválido");
        }

        if ($this->repo->isUsed($table, $id)) {
            throw new \Exception("No puedes eliminar este registro porque está en uso");
        }

        $this->repo->softDelete($table, $id);

        auditoria(
            'delete',
            $table,
            $id,
            "Eliminó registro ID $id",
            'products'
        );
    }

    // ================================
    // RESTORE
    // ================================
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

    // ================================
    // FIND
    // ================================
    public function find($table, $id)
    {
        return $this->repo->find($table, $id);
    }

    // ================================
    // UPDATE
    // ================================
    public function update($table, $id, $nombre)
    {
        if (empty($nombre)) {
            throw new \Exception("El nombre es obligatorio");
        }

        $nombre = ucfirst(trim(strtolower($nombre)));

        if ($this->repo->existsExceptId($table, $nombre, $id)) {
            throw new \Exception("El registro ya existe");
        }

        $this->repo->update($table, $id, $nombre);

        auditoria(
            'update',
            $table,
            $id,
            "Actualizó: $nombre",
            'products'
        );
    }
}
