<?php

namespace App\Modules\Rolls\Services;

use App\Core\Repositories\AuditLogRepository;
use Exception;

class RollService
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
        return $this->model->getAllLotes($includeDeleted);
    }

    public function getFormOptions()
    {
        return [
            'types'      => $this->model->getActiveFabricTypes(),
            'colors'     => $this->model->getActiveFabricColors(),
            'suppliers'  => $this->model->getActiveSuppliers(),
            'warehouses' => $this->model->getActiveWarehouses(),
        ];
    }

    // ======================================================
    // CREAR LOTE + SUS N ROLLOS (con fusión si ya existe)
    // ======================================================
    public function create(array $data, int $userId)
    {
        $fabricTypeId  = (int)($data['fabric_type_id'] ?? 0);
        $fabricColorId = (int)($data['fabric_color_id'] ?? 0);
        $supplierId    = (int)($data['supplier_id'] ?? 0);
        $warehouseId   = (int)($data['warehouse_id'] ?? 0);
        $fechaCompra   = $data['fecha_compra'] ?? '';
        $metraje       = (float)($data['metraje_inicial'] ?? 0);
        $precio        = ($data['precio_compra'] ?? '') !== '' ? (float)$data['precio_compra'] : null;
        $cantidad      = (int)($data['cantidad'] ?? 1);
        $confirmMerge  = !empty($data['confirm_merge']);

        if (!$fabricTypeId || !$fabricColorId || !$supplierId || !$warehouseId) {
            throw new Exception("Tipo de tela, color, proveedor y bodega son obligatorios");
        }

        if (!$fechaCompra) {
            throw new Exception("La fecha de compra es obligatoria");
        }

        if ($metraje <= 0) {
            throw new Exception("El metraje debe ser mayor a cero");
        }

        if ($cantidad < 1 || $cantidad > 200) {
            throw new Exception("La cantidad de rollos debe estar entre 1 y 200");
        }

        $loteCodigo = $this->generateLoteCode($supplierId, $fechaCompra, $fabricTypeId, $fabricColorId, $metraje);

        $existente = $this->model->findLoteByCodigo($loteCodigo);

        // ============================
        // YA EXISTE UN LOTE IDÉNTICO
        // ============================
        if ($existente && !$confirmMerge) {
            return [
                'conflict'    => true,
                'lote_id'     => $existente['id'],
                'lote_codigo' => $existente['codigo'],
                'message'     => "Ya existe un lote con estas mismas características (proveedor, fecha, tipo, color y metraje). ¿Deseas agregar estos {$cantidad} rollo(s) a ese lote existente?",
            ];
        }

        if ($existente && $confirmMerge) {
            $loteId = $existente['id'];
            $consecutivoInicial = $this->model->countRollsInLote($loteId);
        } else {
            $loteId = $this->model->createLote([
                'codigo'            => $loteCodigo,
                'fabric_type_id'    => $fabricTypeId,
                'fabric_color_id'   => $fabricColorId,
                'supplier_id'       => $supplierId,
                'warehouse_id'      => $warehouseId,
                'fecha_compra'      => $fechaCompra,
                'metraje_por_rollo' => $metraje,
                'precio_compra'     => $precio,
                'user_id'           => $userId,
            ]);

            $this->audit->log([
                'usuario_id' => $userId,
                'accion'     => 'create',
                'entidad'    => 'roll_lotes',
                'entidad_id' => $loteId,
                'modulo'     => 'inventory',
                'detalle'    => [
                    'after' => [
                        'codigo' => $loteCodigo,
                        'fabric_type_id' => $fabricTypeId,
                        'fabric_color_id' => $fabricColorId,
                        'supplier_id' => $supplierId,
                        'warehouse_id' => $warehouseId,
                        'fecha_compra' => $fechaCompra,
                        'metraje_por_rollo' => $metraje,
                    ]
                ],
            ]);

            $consecutivoInicial = 0;
        }

        // ============================
        // CREAR LOS N ROLLOS
        // ============================
        $createdCodes = [];

        for ($i = 0; $i < $cantidad; $i++) {

            $consecutivo = str_pad($consecutivoInicial + $i + 1, 4, '0', STR_PAD_LEFT);
            $codigo = $loteCodigo . $consecutivo;

            $rollId = $this->model->createRoll([
                'lote_id'         => $loteId,
                'codigo'          => $codigo,
                'codigo_barra'    => $codigo,
                'fabric_type_id'  => $fabricTypeId,
                'fabric_color_id' => $fabricColorId,
                'supplier_id'     => $supplierId,
                'warehouse_id'    => $warehouseId,
                'fecha_compra'    => $fechaCompra,
                'metraje_inicial' => $metraje,
                'precio_compra'   => $precio,
                'user_id'         => $userId,
            ]);

            $createdCodes[] = $codigo;

            $this->audit->log([
                'usuario_id' => $userId,
                'accion'     => 'create',
                'entidad'    => 'rolls',
                'entidad_id' => $rollId,
                'modulo'     => 'inventory',
                'detalle'    => [
                    'after' => [
                        'codigo'  => $codigo,
                        'lote_id' => $loteId,
                        'lote_codigo' => $loteCodigo,
                        'metraje_inicial' => $metraje,
                    ]
                ],
            ]);
        }

        return [
            'conflict'    => false,
            'lote_id'     => $loteId,
            'lote_codigo' => $loteCodigo,
            'codes'       => $createdCodes,
        ];
    }

    public function update($id, array $data, int $userId)
    {
        $row = $this->model->findLote($id);

        if (!$row) {
            throw new Exception("El lote no existe");
        }

        if ($row['deleted_at'] !== null) {
            throw new Exception("No se puede editar un lote eliminado");
        }

        if ($this->model->hasRollsUsed($id)) {
            throw new Exception("No se puede editar: este lote ya tiene rollos con movimientos de inventario");
        }

        $fabricTypeId  = (int)($data['fabric_type_id'] ?? 0);
        $fabricColorId = (int)($data['fabric_color_id'] ?? 0);
        $supplierId    = (int)($data['supplier_id'] ?? 0);
        $warehouseId   = (int)($data['warehouse_id'] ?? 0);
        $fechaCompra   = $data['fecha_compra'] ?? '';
        $metraje       = (float)($data['metraje_por_rollo'] ?? 0);

        if (array_key_exists('precio_compra', $data)) {
            $precio = ($data['precio_compra'] !== '') ? (float)$data['precio_compra'] : null;
        } else {
            // El usuario no tiene permiso para ver/editar precio — se conserva el valor actual
            $precio = $row['precio_compra'];
        }

        if (!$fabricTypeId || !$fabricColorId || !$supplierId || !$warehouseId) {
            throw new Exception("Tipo de tela, color, proveedor y bodega son obligatorios");
        }

        if (!$fechaCompra) {
            throw new Exception("La fecha de compra es obligatoria");
        }

        if ($metraje <= 0) {
            throw new Exception("El metraje debe ser mayor a cero");
        }

        $nuevoCodigo = $this->generateLoteCode($supplierId, $fechaCompra, $fabricTypeId, $fabricColorId, $metraje);

        if ($nuevoCodigo !== $row['codigo']) {
            $existente = $this->model->findLoteByCodigo($nuevoCodigo);

            if ($existente && (int)$existente['id'] !== (int)$id) {
                throw new Exception("Ya existe otro lote con esos datos (proveedor, fecha, tipo, color y metraje). No se puede duplicar.");
            }
        }

        $payload = [
            'codigo'            => $nuevoCodigo,
            'fabric_type_id'    => $fabricTypeId,
            'fabric_color_id'   => $fabricColorId,
            'supplier_id'       => $supplierId,
            'warehouse_id'      => $warehouseId,
            'fecha_compra'      => $fechaCompra,
            'metraje_por_rollo' => $metraje,
            'precio_compra'     => $precio,
            'user_id'           => $userId,
        ];

        $this->model->updateLoteFull($id, $payload);
        $this->model->updateRollsForLote($id, $payload);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'update',
            'entidad'    => 'roll_lotes',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => [
                'before' => [
                    'codigo'          => $row['codigo'],
                    'fabric_type_id'  => $row['fabric_type_id'],
                    'fabric_color_id' => $row['fabric_color_id'],
                    'supplier_id'     => $row['supplier_id'],
                    'warehouse_id'    => $row['warehouse_id'],
                    'fecha_compra'    => $row['fecha_compra'],
                    'precio_compra'   => $row['precio_compra'],
                ],
                'after' => $payload,
            ],
        ]);

        return ['codigo' => $nuevoCodigo];
    }

    // ============================
    // ELIMINAR ROLLOS
    // ============================
    public function delete($id, $userId)
    {
        $row = $this->model->findLote($id);

        if (!$row) {
            throw new Exception("El lote no existe");
        }

        if ($row['deleted_at'] !== null) {
            throw new Exception("Ya está eliminado");
        }

        $rolls = $this->model->getRollsByLote($id);

        foreach ($rolls as $r) {
            if ((float)$r['metraje_actual'] !== (float)$r['metraje_inicial']) {
                throw new Exception("No se puede eliminar: hay rollos del lote con movimientos de inventario");
            }
        }

        $this->model->deleteLote($id, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'delete',
            'entidad'    => 'roll_lotes',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => ['codigo' => $row['codigo']],
        ]);

        return true;
    }

    // ============================
    // RESTAURAR ROLLOS
    // ============================
    public function restore($id, $userId)
    {
        $row = $this->model->findLote($id);

        if (!$row) {
            throw new Exception("El lote no existe");
        }

        if ($row['deleted_at'] === null) {
            throw new Exception("El lote no está eliminado");
        }

        $this->model->restoreLote($id, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion'     => 'restore',
            'entidad'    => 'roll_lotes',
            'entidad_id' => $id,
            'modulo'     => 'inventory',
            'detalle'    => ['codigo' => $row['codigo']],
        ]);

        return true;
    }

    /**
     * Código determinístico de 22 dígitos:
     * proveedor(3) + fecha YYYYMMDD(8) + tipo(3) + color(3) + metros(3) + centímetros(2)
     */
    public function generateLoteCode($supplierId, $fechaCompra, $fabricTypeId, $fabricColorId, $metraje)
    {
        $proveedorPart = str_pad($supplierId, 3, '0', STR_PAD_LEFT);

        $fechaPart = str_replace('-', '', $fechaCompra);

        $tipoCodigo = $this->model->getFabricTypeCodigo($fabricTypeId);
        preg_match('/(\d+)$/', $tipoCodigo, $mTipo);
        $tipoPart = str_pad($mTipo[1] ?? '0', 3, '0', STR_PAD_LEFT);

        $colorCodigo = $this->model->getFabricColorCodigo($fabricColorId);
        preg_match('/(\d+)$/', $colorCodigo, $mColor);
        $colorPart = str_pad($mColor[1] ?? '0', 3, '0', STR_PAD_LEFT);

        $metrosEnteros = floor($metraje);
        $centimetros = round(($metraje - $metrosEnteros) * 100);

        $metrosPart = str_pad((int)$metrosEnteros, 3, '0', STR_PAD_LEFT);
        $cmPart = str_pad((int)$centimetros, 2, '0', STR_PAD_LEFT);

        return $proveedorPart . $fechaPart . $tipoPart . $colorPart . $metrosPart . $cmPart;
    }

    // ============================
    // EDITAR LOTES
    // ============================
    public function getForEdit($id)
    {
        $row = $this->model->findLote($id);

        if (!$row) {
            throw new Exception("El lote no existe");
        }

        return $row;
    }

    // ======================================================
    // ROLLOS INDIVIDUALES 
    // ======================================================
    public function getAllIndividual($includeDeleted = false)
    {
        return $this->model->getAllIndividual($includeDeleted);
    }
}
