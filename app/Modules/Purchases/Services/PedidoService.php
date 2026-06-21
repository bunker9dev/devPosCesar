<?php

namespace App\Modules\Purchases\Services;

use App\Core\Repositories\AuditLogRepository;
use Exception;

class PedidoService
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

    public function find($id)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("El pedido no existe");
        }

        return $row;
    }

    public function countVencidos()
    {
        return $this->model->countVencidos();
    }

    // ======================================================
    // CREAR PEDIDO + ITEMS (todo en una transacción, igual que Purchases)
    // ======================================================
    public function create(array $header, array $items, int $userId)
    {
        $supplierId = (int)($header['supplier_id'] ?? 0);
        $fecha = $header['fecha_solicitud'] ?? '';
        $observaciones = trim($header['observaciones'] ?? '');

        if (!$supplierId) {
            throw new Exception("Debes seleccionar un proveedor");
        }

        if (!$fecha) {
            throw new Exception("La fecha de solicitud es obligatoria");
        }

        if (count($items) === 0) {
            throw new Exception("Debes agregar al menos una tela al pedido");
        }

        $consecutivo = $this->generateCode();

        $pedidoId = $this->model->create([
            'consecutivo' => $consecutivo,
            'supplier_id' => $supplierId,
            'fecha_solicitud' => $fecha,
            'observaciones' => $observaciones ?: null,
            'user_id' => $userId,
        ]);

        foreach ($items as $index => $item) {
            $fabricTypeId = (int)($item['fabric_type_id'] ?? 0);
            $fabricColorId = (int)($item['fabric_color_id'] ?? 0);
            $cantidad = (float)($item['cantidad'] ?? 0);
            $unidad = ($item['unidad'] ?? 'metros') === 'rollos' ? 'rollos' : 'metros';
            $nota = trim($item['nota'] ?? '');

            if (!$fabricTypeId || !$fabricColorId || $cantidad <= 0) {
                throw new Exception("Ítem #" . ($index + 1) . " incompleto: tipo, color y cantidad son obligatorios");
            }

            $this->model->createItem([
                'pedido_id' => $pedidoId,
                'fabric_type_id' => $fabricTypeId,
                'fabric_color_id' => $fabricColorId,
                'cantidad' => $cantidad,
                'unidad' => $unidad,
                'nota' => $nota ?: null,
            ]);
        }

        $this->audit->log([
            'usuario_id' => $userId,
            'accion' => 'create',
            'entidad' => 'pedidos',
            'entidad_id' => $pedidoId,
            'modulo' => 'purchases',
            'detalle' => [
                'after' => [
                    'consecutivo' => $consecutivo,
                    'supplier_id' => $supplierId,
                    'cantidad_items' => count($items),
                ]
            ],
        ]);

        return ['id' => $pedidoId, 'consecutivo' => $consecutivo];
    }

    // ======================================================
    // APROBAR
    // ======================================================
    public function approve($id, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("El pedido no existe");
        }

        if ($row['estado'] !== 'borrador') {
            throw new Exception("Solo se pueden aprobar pedidos en estado borrador");
        }

        $this->model->approve($id, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion' => 'update',
            'entidad' => 'pedidos',
            'entidad_id' => $id,
            'modulo' => 'purchases',
            'detalle' => ['after' => ['estado' => 'aprobado']],
        ]);

        return true;
    }

    // ======================================================
    // MARCAR COMO RECIBIDO / CANCELADO (manual)
    // ======================================================
    public function markAs($id, string $estado, int $userId)
    {
        if (!in_array($estado, ['recibido', 'cancelado'], true)) {
            throw new Exception("Estado inválido");
        }

        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("El pedido no existe");
        }

        if ($row['estado'] !== 'aprobado') {
            throw new Exception("Solo se pueden cerrar pedidos que ya fueron aprobados");
        }

        $this->model->updateEstado($id, $estado, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion' => 'update',
            'entidad' => 'pedidos',
            'entidad_id' => $id,
            'modulo' => 'purchases',
            'detalle' => ['before' => ['estado' => $row['estado']], 'after' => ['estado' => $estado]],
        ]);

        return true;
    }

    // ======================================================
    // ELIMINAR / RESTAURAR
    // ======================================================
    public function delete($id, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("El pedido no existe");
        }

        if ($row['estado'] !== 'borrador') {
            throw new Exception("Solo se pueden eliminar pedidos que aún están en borrador");
        }

        $this->model->delete($id, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion' => 'delete',
            'entidad' => 'pedidos',
            'entidad_id' => $id,
            'modulo' => 'purchases',
            'detalle' => ['consecutivo' => $row['consecutivo']],
        ]);

        return true;
    }

    public function restore($id, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("El pedido no existe");
        }

        if ($row['deleted_at'] === null) {
            throw new Exception("No está eliminado");
        }

        $this->model->restore($id, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion' => 'restore',
            'entidad' => 'pedidos',
            'entidad_id' => $id,
            'modulo' => 'purchases',
            'detalle' => ['consecutivo' => $row['consecutivo']],
        ]);

        return true;
    }

    public function getAprobadosBySupplier($supplierId)
    {
        return $this->model->getAprobadosBySupplier($supplierId);
    }

    private function generateCode()
    {
        $last = $this->model->getLastCode();

        if (!$last) return 'PED-000001';

        preg_match('/(\d+)$/', $last, $m);
        $num = isset($m[1]) ? (int)$m[1] + 1 : 1;

        return 'PED-' . str_pad($num, 6, '0', STR_PAD_LEFT);
    }
}