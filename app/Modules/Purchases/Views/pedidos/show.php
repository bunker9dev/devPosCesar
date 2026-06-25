<div class="page-header">
    <!-- <h2>Pedido: <?= htmlspecialchars($pedido['consecutivo']) ?></h2> -->
    <a href="<?= BASE_URL ?>/pedidos" class="btn-secondary">← Volver al listado</a>
</div>

<div class="purchase-summary">
    <div class="summary-item">
        <label>Proveedor</label>
        <strong><?= htmlspecialchars($pedido['proveedor_nombre']) ?></strong>
    </div>
    <div class="summary-item">
        <label>Fecha de solicitud</label>
        <strong><?= htmlspecialchars($pedido['fecha_solicitud']) ?></strong>
    </div>
    <div class="summary-item">
        <label>Estado</label>
        <strong><span class="badge estado-<?= $pedido['estado'] ?>"><?= ucfirst($pedido['estado']) ?></span></strong>
    </div>
    <?php if ($pedido['vencido']): ?>
        <div class="summary-item">
            <label>⚠️ Esperando</label>
            <strong class="text-warning"><?= $pedido['dias_abierto'] ?> días</strong>
        </div>
    <?php endif; ?>
</div>

<?php if ($pedido['observaciones']): ?>
    <p class="purchase-notes"><strong>Observaciones:</strong> <?= htmlspecialchars($pedido['observaciones']) ?></p>
<?php endif; ?>

<!-- ACCIONES SEGÚN ESTADO -->
<div class="card actions-card">
    <?php if ($pedido['estado'] === 'borrador'): ?>
        <?php if ($canApprove): ?>
            <button type="button" id="btnApprovePedido" data-id="<?= $pedido['id'] ?>" class="btn-primary">Aprobar pedido</button>
        <?php endif; ?>
        <?php if ($canEdit): ?>
            <a href="<?= BASE_URL ?>/pedidos/edit?id=<?= $pedido['id'] ?>" class="btn-secondary">Editar</a>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($pedido['estado'] === 'aprobado'): ?>
        <button type="button" class="btn-action btn-mark-pedido" data-id="<?= $pedido['id'] ?>" data-estado="recibido">Marcar como recibido</button>
        <button type="button" class="btn-action delete btn-mark-pedido" data-id="<?= $pedido['id'] ?>" data-estado="cancelado">Cancelar pedido</button>
    <?php endif; ?>
</div>

<div class="card">
    <h3>Telas solicitadas</h3>
    <table class="table-main">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Color</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedido['items'] as $item): ?>
                <tr>
                    <td data-label="Tipo"><?= htmlspecialchars($item['tipo_nombre']) ?></td>
                    <td data-label="Color"><?= htmlspecialchars($item['color_nombre']) ?></td>
                    <td data-label="Cantidad"><?= $item['cantidad'] ?></td>
                    <td data-label="Unidad"><?= ucfirst($item['unidad']) ?></td>
                    <td data-label="Nota"><?= htmlspecialchars($item['nota'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="card">
    <h3>Compras vinculadas a este pedido</h3>
    <?php if (empty($pedido['purchases_vinculadas'])): ?>
        <p class="empty-state">Todavía no se ha registrado ninguna compra para este pedido.</p>
    <?php else: ?>
        <table class="table-main">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedido['purchases_vinculadas'] as $pu): ?>
                    <tr>
                        <td data-label="Documento">
                            <a href="<?= BASE_URL ?>/purchases/show?id=<?= $pu['id'] ?>">
                                <?= htmlspecialchars($pu['numero_documento']) ?>
                            </a>
                        </td>
                        <td data-label="Fecha"><?= htmlspecialchars($pu['fecha']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/pedidos-show.js"></script>