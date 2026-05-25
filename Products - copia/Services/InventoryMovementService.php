<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Models\InventoryMovement;
use App\Modules\Products\Models\Roll;
use App\Modules\Products\Repositories\AuditLogRepository;
use App\Modules\Products\Repositories\CatalogRepository;
use App\Modules\Products\Repositories\InventoryMovementRepository;
use App\Modules\Products\Repositories\RollRepository;
use Exception;

class InventoryMovementService
{
    private $db;
    private $rolls;
    private $movements;
    private $catalog;
    private $audit;

    public function __construct(
        $db,
        RollRepository $rolls,
        InventoryMovementRepository $movements,
        CatalogRepository $catalog,
        AuditLogRepository $audit
    ) {
        $this->db = $db;
        $this->rolls = $rolls;
        $this->movements = $movements;
        $this->catalog = $catalog;
        $this->audit = $audit;
    }

    public function indexData()
    {
        return [
            'movements' => $this->movements->all(),
            'warehouses' => $this->catalog->warehouses(),
        ];
    }

    public function create(array $data, $userId)
    {
        $rollId = (int) ($data['roll_id'] ?? 0);
        $tipo = $data['tipo'] ?? '';
        $metros = round((float) str_replace(',', '.', $data['metros'] ?? 0), 2);
        $precio = isset($data['precio']) && $data['precio'] !== '' ? round((float) str_replace(',', '.', $data['precio']), 2) : null;
        $origin = !empty($data['warehouse_origin_id']) ? (int) $data['warehouse_origin_id'] : null;
        $destination = !empty($data['warehouse_destination_id']) ? (int) $data['warehouse_destination_id'] : null;
        $nota = trim($data['nota'] ?? '');

        if (!$rollId || !in_array($tipo, InventoryMovement::TYPES, true)) {
            throw new Exception("Rollo y tipo de movimiento son obligatorios");
        }

        if ($metros <= 0) {
            throw new Exception("Los metros deben ser mayores a cero");
        }

        $roll = $this->rolls->find($rollId);
        if (!$roll) {
            throw new Exception("Rollo no existe");
        }

        if ($roll['estado'] === Roll::ESTADO_ELIMINADO) {
            throw new Exception("No se puede mover un rollo eliminado");
        }

        if ($tipo === InventoryMovement::TRASLADO) {
            $origin = (int) $roll['warehouse_id'];
            if (!$destination) {
                throw new Exception("La bodega destino es obligatoria para traslados");
            }
            if ($origin === $destination) {
                throw new Exception("La bodega destino debe ser diferente");
            }
        }

        if ($tipo === InventoryMovement::SALIDA) {
            $origin = (int) $roll['warehouse_id'];
        }

        if (in_array($tipo, [InventoryMovement::ENTRADA, InventoryMovement::DEVOLUCION], true) && !$destination) {
            $destination = (int) $roll['warehouse_id'];
        }

        $this->db->begin_transaction();

        try {
            $movementId = $this->movements->create([
                'roll_id' => $rollId,
                'tipo' => $tipo,
                'metros' => $metros,
                'precio' => $precio,
                'warehouse_origin_id' => $origin,
                'warehouse_destination_id' => $destination,
                'usuario_id' => $userId,
                'nota' => $nota,
            ]);

            if ($tipo === InventoryMovement::TRASLADO) {
                $this->rolls->updateWarehouse($rollId, $destination);
            }

            $this->audit->log('CREATE', 'inventory_movements', $movementId, [
                'roll_id' => $rollId,
                'tipo' => $tipo,
                'origen' => $origin,
                'destino' => $destination,
            ]);

            $this->db->commit();

            return $movementId;
        } catch (\Throwable $e) {
            $this->db->rollback();
            throw $e;
        }
    }
}
