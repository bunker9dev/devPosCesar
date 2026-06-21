<?php

namespace App\Modules\Purchases\Services;

use App\Core\Repositories\AuditLogRepository;
use Exception;

class PurchaseService
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

    public function getFormOptions()
    {
        return [
            'suppliers' => $this->model->getActiveSuppliers(),
        ];
    }

    public function find($id)
    {
        $row = $this->model->findWithSaldo($id);

        if (!$row) {
            throw new Exception("La compra no existe");
        }

        $row['pagos'] = $this->model->getPayments($id);
        $row['lotes'] = $this->model->getLotesByPurchase($id);

        return $row;
    }

    // ======================================================
    // CREAR
    // ======================================================
    public function create(array $data, int $userId, bool $canManagePrice)
    {
        $supplierId = (int)($data['supplier_id'] ?? 0);
        $numeroDocumento = trim($data['numero_documento'] ?? '');
        $fecha = $data['fecha'] ?? '';
        $condicionPago = ($data['condicion_pago'] ?? 'contado') === 'credito' ? 'credito' : 'contado';
        $plazoDias = $condicionPago === 'credito' ? (int)($data['plazo_dias'] ?? 0) : null;
        $observaciones = trim($data['observaciones'] ?? '');

        if (!$supplierId) {
            throw new Exception("Debes seleccionar un proveedor");
        }

        if (!$numeroDocumento) {
            throw new Exception("El número de documento es obligatorio");
        }

        if (!$fecha) {
            throw new Exception("La fecha es obligatoria");
        }

        if ($this->model->existsDocumento($numeroDocumento, $supplierId)) {
            throw new Exception("Ya existe una compra con ese número de documento para este proveedor");
        }

        if ($condicionPago === 'credito' && $plazoDias <= 0) {
            throw new Exception("Debes indicar el plazo de pago en días");
        }

        $fechaVencimiento = null;

        if ($condicionPago === 'credito') {
            $fechaVencimiento = date('Y-m-d', strtotime("{$fecha} +{$plazoDias} days"));
        }

        // ============================
        // 🔒 DEFENSA EN PROFUNDIDAD:
        // sin manage_price, el total SIEMPRE es 0 y el estado
        // queda en "recibida_sin_valorizar", sin importar qué
        // venga en el POST (no confiamos en el campo oculto del form)
        // ============================
        if ($canManagePrice) {
            $total = (float)($data['total'] ?? 0);
            $estado = $total > 0 ? 'pendiente_pago' : 'abierta';
        } else {
            $total = 0;
            $estado = 'recibida_sin_valorizar';
        }

        $id = $this->model->create([
            'supplier_id' => $supplierId,
            'numero_documento' => $numeroDocumento,
            'fecha' => $fecha,
            'condicion_pago' => $condicionPago,
            'plazo_dias' => $plazoDias,
            'fecha_vencimiento' => $fechaVencimiento,
            'total' => $total,
            'observaciones' => $observaciones ?: null,
            'estado' => $estado,
            'user_id' => $userId,
        ]);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion' => 'create',
            'entidad' => 'purchases',
            'entidad_id' => $id,
            'modulo' => 'purchases',
            'detalle' => [
                'after' => [
                    'numero_documento' => $numeroDocumento,
                    'supplier_id' => $supplierId,
                    'total' => $total,
                    'estado' => $estado,
                ]
            ],
        ]);

        return $id;
    }

    // ======================================================
    // ACTUALIZAR DATOS BÁSICOS (no toca total ni estado)
    // ======================================================
    public function update($id, array $data, int $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("La compra no existe");
        }

        if ($row['deleted_at'] !== null) {
            throw new Exception("No se puede editar una compra eliminada");
        }

        $supplierId = (int)($data['supplier_id'] ?? 0);
        $numeroDocumento = trim($data['numero_documento'] ?? '');
        $fecha = $data['fecha'] ?? '';
        $condicionPago = ($data['condicion_pago'] ?? 'contado') === 'credito' ? 'credito' : 'contado';
        $plazoDias = $condicionPago === 'credito' ? (int)($data['plazo_dias'] ?? 0) : null;
        $observaciones = trim($data['observaciones'] ?? '');

        if (!$supplierId || !$numeroDocumento || !$fecha) {
            throw new Exception("Proveedor, documento y fecha son obligatorios");
        }

        if ($this->model->existsDocumento($numeroDocumento, $supplierId, $id)) {
            throw new Exception("Ya existe otra compra con ese número de documento para este proveedor");
        }

        $fechaVencimiento = null;

        if ($condicionPago === 'credito') {
            if ($plazoDias <= 0) {
                throw new Exception("Debes indicar el plazo de pago en días");
            }
            $fechaVencimiento = date('Y-m-d', strtotime("{$fecha} +{$plazoDias} days"));
        }

        $this->model->update($id, [
            'supplier_id' => $supplierId,
            'numero_documento' => $numeroDocumento,
            'fecha' => $fecha,
            'condicion_pago' => $condicionPago,
            'plazo_dias' => $plazoDias,
            'fecha_vencimiento' => $fechaVencimiento,
            'observaciones' => $observaciones ?: null,
            'user_id' => $userId,
        ]);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion' => 'update',
            'entidad' => 'purchases',
            'entidad_id' => $id,
            'modulo' => 'purchases',
            'detalle' => [
                'before' => ['numero_documento' => $row['numero_documento'], 'fecha' => $row['fecha']],
                'after' => ['numero_documento' => $numeroDocumento, 'fecha' => $fecha],
            ],
        ]);

        return true;
    }

   
    // ======================================================
    // REGISTRAR PAGO (requiere manage_payments — verificado en el Controller)
    // ======================================================
    public function registerPayment($purchaseId, array $data, int $userId)
    {
        $row = $this->model->find($purchaseId);

        if (!$row) {
            throw new Exception("La compra no existe");
        }

        if ($row['deleted_at'] !== null) {
            throw new Exception("No se puede registrar un pago en una compra eliminada");
        }

        if ((float)$row['total'] <= 0) {
            throw new Exception("Esta compra todavía no ha sido valorizada — no se puede registrar un pago");
        }

        $monto = (float)($data['monto'] ?? 0);
        $fechaPago = $data['fecha_pago'] ?? '';
        $metodoPago = $data['metodo_pago'] ?? 'efectivo';
        $referencia = trim($data['referencia'] ?? '');
        $nota = trim($data['nota'] ?? '');

        if ($monto <= 0) {
            throw new Exception("El monto del pago debe ser mayor a cero");
        }

        if (!$fechaPago) {
            throw new Exception("La fecha de pago es obligatoria");
        }

        $totalPagadoActual = $this->model->getTotalPagado($purchaseId);
        $saldoPendiente = (float)$row['total'] - $totalPagadoActual;

        if ($monto > $saldoPendiente + 0.01) { // pequeña tolerancia por redondeo
            throw new Exception("El monto del pago (\${$monto}) supera el saldo pendiente (\${$saldoPendiente})");
        }

        $paymentId = $this->model->createPayment([
            'purchase_id' => $purchaseId,
            'fecha_pago' => $fechaPago,
            'monto' => $monto,
            'metodo_pago' => $metodoPago,
            'referencia' => $referencia ?: null,
            'nota' => $nota ?: null,
            'user_id' => $userId,
        ]);

        $nuevoTotalPagado = $totalPagadoActual + $monto;
        $nuevoEstado = $this->calcularEstado((float)$row['total'], $nuevoTotalPagado);

        $this->model->updateEstado($purchaseId, $nuevoEstado, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion' => 'create',
            'entidad' => 'purchase_payments',
            'entidad_id' => $paymentId,
            'modulo' => 'purchases',
            'detalle' => [
                'after' => [
                    'purchase_id' => $purchaseId,
                    'monto' => $monto,
                    'metodo_pago' => $metodoPago,
                    'nuevo_estado' => $nuevoEstado,
                ]
            ],
        ]);

        return [
            'estado' => $nuevoEstado,
            'saldo_pendiente' => round((float)$row['total'] - $nuevoTotalPagado, 2),
        ];
    }

    // ======================================================
    // ELIMINAR / RESTAURAR
    // ======================================================
    public function delete($id, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("La compra no existe");
        }

        if ($row['deleted_at'] !== null) {
            throw new Exception("Ya está eliminada");
        }

        $totalPagado = $this->model->getTotalPagado($id);

        if ($totalPagado > 0) {
            throw new Exception("No se puede eliminar: esta compra ya tiene pagos registrados");
        }

        $this->model->delete($id, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion' => 'delete',
            'entidad' => 'purchases',
            'entidad_id' => $id,
            'modulo' => 'purchases',
            'detalle' => ['numero_documento' => $row['numero_documento']],
        ]);

        return true;
    }

    public function restore($id, $userId)
    {
        $row = $this->model->find($id);

        if (!$row) {
            throw new Exception("La compra no existe");
        }

        if ($row['deleted_at'] === null) {
            throw new Exception("No está eliminada");
        }

        $this->model->restore($id, $userId);

        $this->audit->log([
            'usuario_id' => $userId,
            'accion' => 'restore',
            'entidad' => 'purchases',
            'entidad_id' => $id,
            'modulo' => 'purchases',
            'detalle' => ['numero_documento' => $row['numero_documento']],
        ]);

        return true;
    }

    // ======================================================
    // CALCULAR ESTADO SEGÚN TOTAL VS. PAGADO
    // ======================================================
    private function calcularEstado(float $total, float $totalPagado): string
    {
        if ($total <= 0) {
            return 'recibida_sin_valorizar';
        }

        if ($totalPagado <= 0) {
            return 'pendiente_pago';
        }

        if ($totalPagado >= $total - 0.01) {
            return 'pagada_total';
        }

        return 'pagada_parcial';
    }
}