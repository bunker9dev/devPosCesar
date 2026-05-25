<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Models\InventoryMovement;
use App\Modules\Products\Repositories\AuditLogRepository;
use App\Modules\Products\Repositories\CatalogRepository;
use App\Modules\Products\Repositories\InventoryMovementRepository;
use App\Modules\Products\Repositories\RollRepository;
use Exception;

class RollService
{
    private $db;
    private $catalog;
    private $rolls;
    private $movements;
    private $audit;

    public function __construct(
        $db,
        CatalogRepository $catalog,
        RollRepository $rolls,
        InventoryMovementRepository $movements,
        AuditLogRepository $audit
    ) {
        $this->db = $db;
        $this->catalog = $catalog;
        $this->rolls = $rolls;
        $this->movements = $movements;
        $this->audit = $audit;
    }

    public function indexData()
    {
        return [
            'rolls' => $this->rolls->all(),
        ];
    }

    public function createData()
    {
        return [
            'types' => $this->catalog->fabricTypes(),
            'colors' => $this->catalog->colors(),
            'suppliers' => $this->catalog->suppliers(),
            'warehouses' => $this->catalog->warehouses(),
        ];
    }

    public function createManual(array $data, $userId)
    {
        $fabricTypeId = (int) ($data['fabric_type_id'] ?? 0);
        $colorId = (int) ($data['fabric_color_id'] ?? 0);
        $supplierId = (int) ($data['supplier_id'] ?? 0);
        $warehouseId = (int) ($data['warehouse_id'] ?? 0);
        $metros = round((float) str_replace(',', '.', $data['metros'] ?? 0), 2);
        $precio = round((float) str_replace(',', '.', $data['precio_compra'] ?? 0), 2);

        if (!$fabricTypeId || !$colorId || !$supplierId || !$warehouseId) {
            throw new Exception("Tipo de tela, color, proveedor y bodega son obligatorios");
        }

        if ($metros <= 0) {
            throw new Exception("Los metros deben ser mayores a cero");
        }

        if ($precio < 0) {
            throw new Exception("El precio no puede ser negativo");
        }

        $type = $this->catalog->findFabricType($fabricTypeId);
        $color = $this->catalog->findColor($colorId);
        $supplier = $this->catalog->findSupplier($supplierId);
        $warehouse = $this->catalog->findWarehouse($warehouseId);

        if (!$type || !$color || !$supplier || !$warehouse) {
            throw new Exception("Datos de catálogo inválidos");
        }

        $this->db->begin_transaction();

        try {
            $product = $this->catalog->findOrCreateProduct($fabricTypeId, $colorId);
            $centimetros = (int) round($metros * 100);
            $barcode = $this->rolls->nextBarcode();
            $visible = $this->buildVisibleCode($type['codigo'], $color['codigo'], $centimetros);

            $rollId = $this->rolls->create([
                'product_id' => (int) $product['id'],
                'fabric_type_id' => $fabricTypeId,
                'fabric_color_id' => $colorId,
                'supplier_id' => $supplierId,
                'purchase_id' => null,
                'warehouse_id' => $warehouseId,
                'codigo_barra' => $barcode,
                'codigo_visible' => $visible,
                'metros' => $metros,
                'centimetros' => $centimetros,
                'precio_compra' => $precio,
                'created_by' => $userId,
            ]);

            $movementId = $this->movements->create([
                'roll_id' => $rollId,
                'tipo' => InventoryMovement::ENTRADA,
                'metros' => $metros,
                'precio' => $precio,
                'warehouse_origin_id' => null,
                'warehouse_destination_id' => $warehouseId,
                'usuario_id' => $userId,
                'nota' => 'Entrada por creación de rollo',
            ]);

            $this->audit->log('CREATE', 'rolls', $rollId, [
                'codigo_barra' => $barcode,
                'codigo_visible' => $visible,
                'movement_id' => $movementId,
            ]);

            $this->db->commit();

            return $this->rolls->find($rollId);
        } catch (\Throwable $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function findByCode($code)
    {
        $code = trim($code);
        if (!$code) {
            throw new Exception("Código requerido");
        }

        return $this->rolls->findByAnyCode($code);
    }

    private function buildVisibleCode($typeCode, $colorCode, $centimeters)
    {
        return date('ymd') . '-' . $typeCode . '-' . $colorCode . '-' . str_pad((string) $centimeters, 5, '0', STR_PAD_LEFT);
    }
}
