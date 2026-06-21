<?php use App\Core\Status; ?>

<div class="page-header">
    <h2>Compra: <?= htmlspecialchars($purchase['numero_documento']) ?></h2>
    <a href="<?= BASE_URL ?>/purchases" class="btn-secondary">← Volver al listado</a>
</div>

<div class="purchase-summary">
    <div class="summary-item">
        <label>Proveedor</label>
        <strong><?= htmlspecialchars($purchase['proveedor_nombre']) ?></strong>
    </div>
    <div class="summary-item">
        <label>Fecha de compra</label>
        <strong><?= htmlspecialchars($purchase['fecha']) ?></strong>
    </div>
    <div class="summary-item">
        <label>Condición de pago</label>
        <strong>
            <?= $purchase['condicion_pago'] === 'credito'
                ? "Crédito a {$purchase['plazo_dias']} días (vence {$purchase['fecha_vencimiento']})"
                : 'Contado' ?>
        </strong>
    </div>
    <div class="summary-item">
        <label>Estado</label>
        <strong><span class="badge estado-<?= $purchase['estado'] ?>">
            <?= ucfirst(str_replace('_', ' ', $purchase['estado'])) ?>
        </span></strong>
    </div>
    <div class="summary-item">
        <label>Total</label>
        <strong>$<?= number_format($purchase['total'], 2) ?></strong>
    </div>
    <div class="summary-item">
        <label>Pagado</label>
        <strong>$<?= number_format($purchase['total_pagado'], 2) ?></strong>
    </div>
    <div class="summary-item">
        <label>Saldo pendiente</label>
        <strong class="<?= $purchase['saldo_pendiente'] > 0 ? 'text-warning' : '' ?>">
            $<?= number_format($purchase['saldo_pendiente'], 2) ?>
        </strong>
    </div>
</div>

<?php if ($purchase['observaciones']): ?>
    <p class="purchase-notes"><strong>Observaciones:</strong> <?= htmlspecialchars($purchase['observaciones']) ?></p>
<?php endif; ?>


<!-- =========================
   REGISTRAR PAGO
========================= -->
<?php if ($canManagePayments && (float)$purchase['total'] > 0 && $purchase['saldo_pendiente'] > 0): ?>
<div class="card">
    <h3>Registrar pago</h3>
    <form id="formRegisterPayment" class="form-grid-2col">
        <input type="hidden" id="paymentPurchaseId" value="<?= $purchase['id'] ?>">

        <div class="form-group">
            <label>Fecha de pago</label>
            <input type="date" id="paymentFecha" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="form-group">
            <label>Monto</label>
            <input type="number" step="0.01" min="0.01" max="<?= $purchase['saldo_pendiente'] ?>" id="paymentMonto" required>
        </div>

        <div class="form-group">
            <label>Método de pago</label>
            <select id="paymentMetodo">
                <option value="efectivo">Efectivo</option>
                <option value="transferencia">Transferencia</option>
                <option value="cheque">Cheque</option>
                <option value="otro">Otro</option>
            </select>
        </div>

        <div class="form-group">
            <label>Referencia (opcional)</label>
            <input type="text" id="paymentReferencia">
        </div>

        <div class="form-actions form-actions-full">
            <button type="submit" class="btn-primary">Registrar pago</button>
        </div>
    </form>
</div>
<?php endif; ?>


<!-- =========================
   HISTORIAL DE PAGOS
========================= -->
<div class="card">
    <h3>Historial de pagos</h3>

    <?php if (empty($purchase['pagos'])): ?>
        <p class="empty-state">Todavía no se ha registrado ningún pago.</p>
    <?php else: ?>
        <table class="table-main">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Método</th>
                    <th>Referencia</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchase['pagos'] as $pago): ?>
                    <tr>
                        <td><?= htmlspecialchars($pago['fecha_pago']) ?></td>
                        <td>$<?= number_format($pago['monto'], 2) ?></td>
                        <td><?= htmlspecialchars(ucfirst($pago['metodo_pago'])) ?></td>
                        <td><?= htmlspecialchars($pago['referencia'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>


<!-- =========================
   ROLLOS / LOTES ASOCIADOS A ESTA COMPRA
   (vacío hasta que conectemos Rolls -> Purchases, Fase B)
========================= -->
<div class="card">
    <h3>Rollos ingresados con esta compra</h3>

    <?php if ($canEdit): ?>
        <a href="<?= BASE_URL ?>/rolls/create?purchase_id=<?= $purchase['id'] ?>" class="btn-primary">
            + Agregar rollos a esta compra
        </a>
    <?php endif; ?>

    <?php if (empty($purchase['lotes'])): ?>
        <p class="empty-state">
            Aún no hay rollos vinculados a esta compra.
            (Esto se habilitará cuando conectemos la creación de rollos con compras existentes.)
        </p>
    <?php else: ?>
        <table class="table-main">
            <thead>
                <tr>
                    <th>Código de lote</th>
                    <th>Tipo</th>
                    <th>Color</th>
                    <th>Cantidad de rollos</th>
                    <th>Metraje por rollo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchase['lotes'] as $lote): ?>
                    <tr>
                        <td><?= htmlspecialchars($lote['codigo']) ?></td>
                        <td><?= htmlspecialchars($lote['tipo_nombre']) ?></td>
                        <td><?= htmlspecialchars($lote['color_nombre']) ?></td>
                        <td><?= $lote['cantidad_rollos'] ?></td>
                        <td><?= htmlspecialchars($lote['metraje_por_rollo']) ?> m</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/purchases-show.js"></script>