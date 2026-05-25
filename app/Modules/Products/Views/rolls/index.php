<div class="module-header inventory-header">
    <div>
        <a href="<?= BASE_URL ?>/rolls/create" class="btn-primary">+ Crear rollo</a>
        <a href="<?= BASE_URL ?>/movements" class="btn-secondary">Kardex</a>
    </div>
</div>

<section class="inventory-scan">
    <input id="globalRollScanner" autocomplete="off" autofocus placeholder="Escanear o escribir código de barra / código visible">
    <div id="scannerResult" class="scan-result">Esperando lectura</div>
</section>

<div class="table-container">
    <table id="tablaRolls" class="table-main display">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Código barra</th>
                <th>Código visible</th>
                <th>Tela</th>
                <th>Color</th>
                <th>Metros</th>
                <th>Bodega</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rolls as $roll): ?>
                <tr>
                    <th></th>
                    <td data-label="ID"><?= $roll['id'] ?></td>
                    <td data-label="Código barra"><?= htmlspecialchars($roll['codigo_barra']) ?></td>
                    <td data-label="Código visible"><?= htmlspecialchars($roll['codigo_visible']) ?></td>
                    <td data-label="Tela"><?= htmlspecialchars($roll['tipo_tela']) ?></td>
                    <td data-label="Color">
                        <span class="color-chip" style="--swatch: <?= htmlspecialchars($roll['hex'] ?: '#6b7280') ?>"></span>
                        <?= htmlspecialchars($roll['color']) ?>
                    </td>
                    <td data-label="Metros"><?= number_format((float) $roll['metros'], 2) ?></td>
                    <td data-label="Bodega"><?= htmlspecialchars($roll['bodega']) ?></td>
                    <td data-label="Estado">
                        <span class="badge <?= $roll['estado'] === 'activo' ? 'active' : ($roll['estado'] === 'eliminado' ? 'deleted' : 'inactive') ?>">
                            <?= htmlspecialchars(ucfirst($roll['estado'])) ?>
                        </span>
                    </td>
                    <td data-label="Acciones">
                        <div class="actions">
                            <a href="<?= BASE_URL ?>/rolls/label?id=<?= $roll['id'] ?>" class="btn-action edit">Etiqueta</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
