<?php

namespace App\Modules\Products\Services;

use App\Core\Status;
use App\Modules\Products\Repositories\CatalogRepository;
use Exception;

class CatalogService
{
    private $repo;

    // 🔐 TABLAS PERMITIDAS
    private $allowedTables = [
        'fabric_colors',
        'fabric_types',
        'warehouses'
    ];

    // 🔗 RELACIONES FK
    private $relations = [
        'fabric_colors' => [
            'table' => 'products',
            'field' => 'fabric_color_id'
        ],
        'fabric_types' => [
            'table' => 'products',
            'field' => 'fabric_type_id'
        ]
    ];

    public function __construct()
    {
        $this->repo = new CatalogRepository();
    }

    // ======================================================
    // VALIDAR TABLA
    // ======================================================
    private function validateTable($table)
    {
        if (!in_array($table, $this->allowedTables)) {
            throw new Exception("Tabla no permitida");
        }
    }

    // ======================================================
    // LISTAR
    // ======================================================
    public function getAll($table, $isSuper = false)
    {
        $this->validateTable($table);
        return $this->repo->getAll($table, $isSuper);
    }

    // ======================================================
    // CREAR
    // ======================================================
    public function create($table, $nombre)
    {
        $this->validateTable($table);

        $nombre = strtolower(trim($nombre));

        if (!$nombre) {
            throw new Exception("El nombre es obligatorio");
        }

        if ($this->repo->exists($table, $nombre)) {
            throw new Exception("El nombre ya existe");
        }

        $codigo = $this->repo->nextCode($table);
        $userId = $_SESSION['user']['id'] ?? null;

        $id = $this->repo->create($table, $codigo, $nombre, $userId);

        // 🔥 AUDITORÍA PRO
        $this->audit(
            "CREATE",
            $table,
            $id,
            "Registro creado: {$nombre}"
        );

        return $id;
    }

    // ======================================================
    // UPDATE
    // ======================================================
    public function update($table, $id, $nombre)
    {
        $this->validateTable($table);

        $nombre = strtolower(trim($nombre));

        if (!$id) {
            throw new Exception("ID inválido");
        }

        if (!$nombre) {
            throw new Exception("El nombre es obligatorio");
        }

        // 🔥 OBTENER VALOR ANTERIOR
        $old = $this->repo->find($table, $id);

        if (!$old) {
            throw new Exception("Registro no existe");
        }

        if ($this->repo->existsExceptId($table, $nombre, $id)) {
            throw new Exception("El nombre ya existe");
        }

        $this->repo->update($table, $id, $nombre);

        // 🔥 AUDITORÍA PRO (ANTES VS DESPUÉS)
        $this->audit(
            "UPDATE",
            $table,
            $id,
            "Nombre: {$old['nombre']} → {$nombre}"
        );

        return true;
    }

    // ======================================================
    // TOGGLE
    // ======================================================
    public function toggle($table, $id)
    {
        $this->validateTable($table);

        $row = $this->repo->find($table, $id);

        if (!$row) {
            throw new Exception("Registro no existe");
        }

        if ($row['estado'] == Status::ELIMINADO) {
            throw new Exception("No se puede modificar eliminado");
        }

        $nuevoEstado = $row['estado'] == Status::ACTIVO
            ? Status::INACTIVO
            : Status::ACTIVO;

        $this->repo->updateEstado($table, $id, $nuevoEstado);

        // 🔥 AUDITORÍA PRO
        $this->audit(
            "TOGGLE",
            $table,
            $id,
            "Estado: {$row['estado']} → {$nuevoEstado} | {$row['nombre']}"
        );

        return $nuevoEstado;
    }

    // ======================================================
    // DELETE (VALIDA FK)
    // ======================================================
    public function delete($table, $id)
    {
        $this->validateTable($table);

        // 🔥 OBTENER DATA
        $row = $this->repo->find($table, $id);

        if (!$row) {
            throw new Exception("Registro no existe");
        }

        // 🔥 VALIDACIÓN FK REAL
        if (isset($this->relations[$table])) {

            $rel = $this->relations[$table];

            if ($this->repo->isUsedRelation(
                $rel['table'],
                $rel['field'],
                $id
            )) {
                throw new Exception("El registro está en uso");
            }
        }

        $userId = $_SESSION['user']['id'] ?? null;
        $this->repo->softDelete($table, $id, $userId);

        // 🔥 AUDITORÍA PRO
        $this->audit(
            "DELETE",
            $table,
            $id,
            "Registro eliminado: {$row['nombre']}"
        );

        return true;
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public function restore($table, $id)
{
    $this->validateTable($table);

    $row = $this->repo->find($table, $id);

    if (!$row) {
        throw new Exception("Registro no existe");
    }

    $userId = $_SESSION['user']['id'] ?? null;

    $this->repo->restore($table, $id, $userId);

    // 🔥 AUDITORÍA PRO
    $this->audit(
        "RESTORE",
        $table,
        $id,
        "Registro restaurado: {$row['nombre']}"
    );

    return true;
}
    public function getAllForList($table, $rolId)
    {
        $this->validateTable($table);

        // 🔥 permisos del módulo
        $permissions = \App\Services\PermissionService::getModulePermissions($rolId, 'products');

        // 🔥 si puede restaurar → puede ver eliminados (igual que users)
        $includeDeleted = $permissions['restore'];

        return $this->repo->getAll($table, $includeDeleted);
    }


    // ======================================================
    // AUDITORÍA
    // ======================================================
    private function audit($accion, $tabla, $id, $detalle)
    {
        $user = $_SESSION['user']['username'] ?? 'Sistema';

        auditoria(
            $accion,
            $tabla,
            $id,
            "{$detalle} | Usuario: {$user}",
            "products"
        );
    }
}
