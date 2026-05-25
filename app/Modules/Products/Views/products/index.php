<div class="module-header">
    <a href="<?= BASE_URL ?>/rolls/create" class="btn-primary">+ Crear rollo</a>
    <a href="<?= BASE_URL ?>/products/types" class="btn-secondary">Tipos de tela</a>
    <a href="<?= BASE_URL ?>/products/colors" class="btn-secondary">Colores</a>
</div>

<div class="table-container">
    <table id="tablaProducts" class="table-main display">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Color</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <th></th>
                    <td data-label="ID"><?= $product['id'] ?></td>
                    <td data-label="Producto"><?= htmlspecialchars($product['nombre']) ?></td>
                    <td data-label="Tipo"><?= htmlspecialchars($product['tipo_codigo'] . ' - ' . $product['tipo_nombre']) ?></td>
                    <td data-label="Color">
                        <span class="color-chip" style="--swatch: <?= htmlspecialchars($product['hex'] ?: '#6b7280') ?>"></span>
                        <?= htmlspecialchars($product['color_codigo'] . ' - ' . $product['color_nombre']) ?>
                    </td>
                    <td data-label="Estado"><?= $product['estado'] ? 'Activo' : 'Inactivo' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
