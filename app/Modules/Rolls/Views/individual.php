<div class="module-header">
    <a href="<?= BASE_URL ?>/rolls" class="btn-secondary">
        ← Volver a lotes
    </a>
    <p class="page-note">
        Vista de solo lectura — cada fila es un rollo físico individual, con su código único completo.
    </p>
</div>

<div class="table-container">
    <table id="tablaRollosIndividual" class="table-main display">
        <thead>
            <tr>
                <th></th>
                <th>#</th>
                <th>Código de rollo</th>
                <th>Código de lote</th>
                <th>Tipo</th>
                <th>Color</th>
                <th>Metros</th>
                <th>Metros actuales</th>
                <th>Proveedor</th>
                <th>Bodega</th>
                <th>Fecha compra</th>
                <?php if ($canViewPrice): ?><th>Valor de compra (por metro)</th><?php endif; ?>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rollos as $i => $r): ?>
                <?php $eliminado = $r['deleted_at'] !== null; ?>
                <tr class="<?= $eliminado ? 'deleted' : '' ?>">
                    <td></td>
                    <td data-label="#"><?= $i + 1 ?></td>
                    <td data-label="Código de rollo"><strong><?= htmlspecialchars($r['codigo']) ?></strong></td>
                    <td data-label="Código de lote"><?= htmlspecialchars($r['lote_codigo']) ?></td>
                    <td data-label="Tipo"><?= htmlspecialchars($r['tipo_nombre']) ?></td>
                    <td data-label="Color"><?= htmlspecialchars($r['color_nombre']) ?></td>
                    <td data-label="Metros"><?= htmlspecialchars($r['metraje_inicial']) ?></td>
                    <td data-label="Metros actuales"><?= htmlspecialchars($r['metraje_actual']) ?></td>
                    <td data-label="Proveedor"><?= htmlspecialchars($r['proveedor_nombre']) ?></td>
                    <td data-label="Bodega"><?= htmlspecialchars($r['bodega_nombre']) ?></td>
                    <td data-label="Fecha compra"><?= htmlspecialchars($r['fecha_compra']) ?></td>
                    <?php if ($canViewPrice): ?>
                    <td data-label="Valor de compra (por metro)">
                        <?= $r['precio_compra'] !== null ? '$' . number_format($r['precio_compra'], 2) : '-' ?>
                    </td>
                    <?php endif; ?>
                    <td data-label="Estado">
                        <?= $eliminado ? '<span class="badge deleted">Eliminado</span>' : '<span class="badge active">Activo</span>' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/rolls-individual.js"></script>