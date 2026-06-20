<div class="module-header">
    <?php if ($canCreate): ?>
        <a href="<?= BASE_URL ?>/rolls/create" class="btn-primary">
            + Crear rollo(s)
        </a>
    <?php endif; ?>
</div>

<div class="table-container">
    <table id="tablaRolls" class="table-main display">
        <thead>
            <tr>
                <th></th>
                <th>#</th>
                <th>Código de lote</th>
                <th>Tipo</th>
                <th>Color</th>
                <th>Metros</th>
                <th>Cantidad de rollos</th>
                <th>Proveedor</th>
                <th>Bodega</th>
                <th>Fecha compra</th>

                <?php if ($canViewPrice): ?>
                    <th>Valor de compra (por metro)</th>
                <?php endif; ?>

                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rolls as $i => $l): ?>
                <?php $eliminado = $l['deleted_at'] !== null; ?>
                <tr data-id="<?= $l['id'] ?>" class="<?= $eliminado ? 'deleted' : '' ?>">
                    <td></td>
                    <td data-label="#"><?= $i + 1 ?></td>
                    <td data-label="Código de lote"><?= htmlspecialchars($l['codigo']) ?></td>
                    <td data-label="Tipo"><?= htmlspecialchars($l['tipo_nombre']) ?></td>
                    <td data-label="Color"><?= htmlspecialchars($l['color_nombre']) ?></td>
                    <td data-label="Metros"><?= htmlspecialchars($l['metraje_por_rollo']) ?></td>
                    <td data-label="Cantidad de rollos"><?= $l['cantidad_rollos'] ?></td>
                    <td data-label="Proveedor"><?= htmlspecialchars($l['proveedor_nombre']) ?></td>
                    <td data-label="Bodega"><?= htmlspecialchars($l['bodega_nombre']) ?></td>
                    <td data-label="Fecha compra"><?= htmlspecialchars($l['fecha_compra']) ?></td>

                    <?php if ($canViewPrice): ?>
                        <td data-label="Valor de compra (por metro)">
                            <?= $l['precio_compra'] !== null ? '$' . number_format($l['precio_compra'], 2) : '-' ?>
                        </td>
                    <?php endif; ?>

                    <td data-label="Acciones">
                        <div class="actions">
                            <?php if (!$eliminado): ?>
                                <?php if ($canEdit): ?>
                                    <button
                                        class="btn-action edit btn-edit-lote"
                                        data-id="<?= $l['id'] ?>">
                                        Editar
                                    </button>
                                <?php endif; ?>
                                <?php if ($canDelete): ?>
                                    <button
                                        class="btn-action delete btn-delete-lote"
                                        data-id="<?= $l['id'] ?>"
                                        data-codigo="<?= htmlspecialchars($l['codigo']) ?>">
                                        Eliminar
                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if ($canRestore): ?>
                                    <button
                                        class="btn-action restore btn-restore"
                                        data-id="<?= $l['id'] ?>"
                                        data-url="<?= BASE_URL ?>/rolls/restore">
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

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/rolls-index.js"></script>