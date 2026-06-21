<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success" id="alertMessage"><?= $_SESSION['success'] ?></div>
<?php unset($_SESSION['success']); endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-error" id="alertMessage"><?= $_SESSION['error'] ?></div>
<?php unset($_SESSION['error']); endif; ?>

<div class="module-header">
    <?php if ($canCreate): ?>
        <a href="<?= BASE_URL ?>/purchases/create" class="btn-primary">
            + Crear compra
        </a>
    <?php endif; ?>
</div>

<div class="table-container">
    <table id="tablaPurchases" class="table-main display">
        <thead>
            <tr>
                <th></th>
                <th>#</th>
                <th>Documento</th>
                <th>Proveedor</th>
                <th>Fecha</th>
                <th>Condición</th>
                <th>Vencimiento</th>
                <th>Total</th>
                <th>Pagado</th>
                <th>Saldo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchases as $i => $p): ?>
                <?php $eliminado = $p['deleted_at'] !== null; ?>
                <tr data-id="<?= $p['id'] ?>" class="<?= $eliminado ? 'deleted' : '' ?>">
                    <td></td>
                    <td data-label="#"><?= $i + 1 ?></td>
                    <td data-label="Documento">
                        <a href="<?= BASE_URL ?>/purchases/show?id=<?= $p['id'] ?>">
                            <?= htmlspecialchars($p['numero_documento']) ?>
                        </a>
                    </td>
                    <td data-label="Proveedor"><?= htmlspecialchars($p['proveedor_nombre']) ?></td>
                    <td data-label="Fecha"><?= htmlspecialchars($p['fecha']) ?></td>
                    <td data-label="Condición">
                        <?= $p['condicion_pago'] === 'credito' ? "Crédito ({$p['plazo_dias']}d)" : 'Contado' ?>
                    </td>
                    <td data-label="Vencimiento"><?= htmlspecialchars($p['fecha_vencimiento'] ?? '-') ?></td>
                    <td data-label="Total">$<?= number_format($p['total'], 2) ?></td>
                    <td data-label="Pagado">$<?= number_format($p['total_pagado'], 2) ?></td>
                    <td data-label="Saldo">
                        <strong class="<?= $p['saldo_pendiente'] > 0 ? 'text-warning' : '' ?>">
                            $<?= number_format($p['saldo_pendiente'], 2) ?>
                        </strong>
                    </td>
                    <td data-label="Estado">
                        <span class="badge estado-<?= $p['estado'] ?>"><?= ucfirst(str_replace('_', ' ', $p['estado'])) ?></span>
                    </td>
                    <td data-label="Acciones">
                        <div class="actions">
                            <?php if (!$eliminado): ?>
                                <a href="<?= BASE_URL ?>/purchases/show?id=<?= $p['id'] ?>" class="btn-action edit">Ver</a>
                                <?php if ($canDelete): ?>
                                    <button class="btn-action delete btn-delete-purchase"
                                        data-id="<?= $p['id'] ?>"
                                        data-doc="<?= htmlspecialchars($p['numero_documento']) ?>">
                                        Eliminar
                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if ($canRestore): ?>
                                    <button class="btn-action restore btn-restore"
                                        data-id="<?= $p['id'] ?>"
                                        data-url="<?= BASE_URL ?>/purchases/restore">
                                        Restaurar
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/modals.php'; ?>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/purchases-index.js"></script>