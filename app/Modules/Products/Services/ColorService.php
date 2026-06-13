<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Repositories\ColorRepository;
use App\Core\Repositories\AuditLogRepository;
use Exception;

class ColorService
{
    private $repo;
    private $audit;

    public function __construct($db)
    {
        $this->repo = new ColorRepository($db);
        $this->audit = new AuditLogRepository($db);
    }

    // ==================================================
    // LISTAR
    // ==================================================
    public function getAll()
    {
        return $this->repo->getAll();
    }

    // ==================================================
    // CREAR
    // ==================================================
    public function create($nombre)
    {
        $nombre = strtolower(trim($nombre));

        if (!$nombre) {
            throw new Exception("El nombre es obligatorio");
        }

        if ($this->repo->exists($nombre)) {
            throw new Exception("El nombre ya existe");
        }

        $codigo = $this->repo->nextCode();

        $id = $this->repo->create($codigo, $nombre, null);

        // 🔥 AUDITORÍA PRO
        $this->audit->log([
            'usuario_id' => $_SESSION['user']['id'] ?? null,
            'accion' => 'create',
            'entidad' => 'fabric_colors',
            'entidad_id' => $id,
            'modulo' => 'products',
            'detalle' => [
                'after' => [
                    'codigo' => $codigo,
                    'nombre' => $nombre
                ]
            ]
        ]);

        return true;
    }

    // ==================================================
    // UPDATE
    // ==================================================
    public function update($id, $nombre)
    {
        $nombre = strtolower(trim($nombre));

        if (!$id) {
            throw new Exception("ID inválido");
        }

        if (!$nombre) {
            throw new Exception("El nombre es obligatorio");
        }

        $old = $this->repo->find($id);

        if (!$old) {
            throw new Exception("Registro no existe");
        }

        if ($this->repo->exists($nombre)) {
            throw new Exception("El nombre ya existe");
        }

        $this->repo->update($id, [
            'codigo' => $old['codigo'],
            'nombre' => $nombre,
            'hex'    => $old['hex'],
            'estado' => 1,
            'updated_by' => $_SESSION['user']['id'] ?? null
        ]);

        // 🔥 AUDITORÍA PRO
        $this->audit->log([
            'usuario_id' => $_SESSION['user']['id'] ?? null,
            'accion' => 'update',
            'entidad' => 'fabric_colors',
            'entidad_id' => $id,
            'modulo' => 'products',
            'detalle' => [
                'before' => $old,
                'after' => ['nombre' => $nombre]
            ]
        ]);

        return true;
    }

    // ==================================================
    // TOGGLE
    // ==================================================
    public function toggle($id)
    {
        if (!$id) {
            throw new Exception("ID inválido");
        }

        $row = $this->repo->find($id);

        if (!$row) {
            throw new Exception("Registro no existe");
        }

        if ($row['estado'] == 0) {
            throw new Exception("No se puede modificar eliminado");
        }

        $nuevoEstado = $row['estado'] == 1 ? 2 : 1;

        $this->repo->update($id, [
            'codigo' => $row['codigo'],
            'nombre' => $row['nombre'],
            'hex'    => $row['hex'],
            'estado' => $nuevoEstado,
            'updated_by' => $_SESSION['user']['id'] ?? null
        ]);

        // 🔥 AUDITORÍA PRO
        $this->audit->log([
            'usuario_id' => $_SESSION['user']['id'] ?? null,
            'accion' => 'toggle',
            'entidad' => 'fabric_colors',
            'entidad_id' => $id,
            'modulo' => 'products',
            'detalle' => [
                'before' => ['estado' => $row['estado']],
                'after' => ['estado' => $nuevoEstado]
            ]
        ]);

        return $nuevoEstado;
    }

    // ==================================================
    // DELETE
    // ==================================================
    public function delete($id)
    {
        if (!$id) {
            throw new Exception("ID inválido");
        }

        $row = $this->repo->find($id);

        if (!$row) {
            throw new Exception("Registro no existe");
        }

        // 🔥 VALIDAR USO
        $stmt = $this->repo->db->prepare("
            SELECT id FROM products WHERE color_id = ? LIMIT 1
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) {
            throw new Exception("El color está en uso");
        }

        $this->repo->softDelete($id);

        // 🔥 AUDITORÍA PRO
        $this->audit->log([
            'usuario_id' => $_SESSION['user']['id'] ?? null,
            'accion' => 'delete',
            'entidad' => 'fabric_colors',
            'entidad_id' => $id,
            'modulo' => 'products',
            'detalle' => [
                'before' => $row
            ]
        ]);

        return true;
    }

    // ==================================================
    // RESTORE
    // ==================================================
    public function restore($id)
    {
        if (!$id) {
            throw new Exception("ID inválido");
        }

        $row = $this->repo->find($id);

        if (!$row) {
            throw new Exception("Registro no existe");
        }

        $this->repo->restore($id);

        // 🔥 AUDITORÍA PRO
        $this->audit->log([
            'usuario_id' => $_SESSION['user']['id'] ?? null,
            'accion' => 'restore',
            'entidad' => 'fabric_colors',
            'entidad_id' => $id,
            'modulo' => 'products',
            'detalle' => [
                'after' => $row
            ]
        ]);

        return true;
    }
}