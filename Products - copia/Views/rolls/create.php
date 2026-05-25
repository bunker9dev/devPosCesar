<?php
$old = $old ?? [];
$errors = $errors ?? [];
?>

<?php if (!empty($errors['general'])): ?>
    <div class="form-alert error"><?= htmlspecialchars($errors['general']) ?></div>
<?php endif; ?>

<form method="POST" action="<?= BASE_URL ?>/rolls/store" class="form-users inventory-form">
    <div class="form-grid">
        <div class="form-group">
            <label>Tipo de tela</label>
            <select name="fabric_type_id" required>
                <option value="">Seleccionar</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= $type['id'] ?>" <?= (($old['fabric_type_id'] ?? '') == $type['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($type['codigo'] . ' - ' . $type['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Color</label>
            <select name="fabric_color_id" required>
                <option value="">Seleccionar</option>
                <?php foreach ($colors as $color): ?>
                    <option value="<?= $color['id'] ?>" <?= (($old['fabric_color_id'] ?? '') == $color['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($color['codigo'] . ' - ' . $color['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Metros</label>
            <input type="number" step="0.01" min="0.01" name="metros" value="<?= htmlspecialchars($old['metros'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Precio compra</label>
            <input type="number" step="0.01" min="0" name="precio_compra" value="<?= htmlspecialchars($old['precio_compra'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>Proveedor</label>
            <select name="supplier_id" required>
                <option value="">Seleccionar</option>
                <?php foreach ($suppliers as $supplier): ?>
                    <option value="<?= $supplier['id'] ?>" <?= (($old['supplier_id'] ?? '') == $supplier['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars(trim($supplier['nombre'] . ' ' . ($supplier['apellidos'] ?? '')) . ' - ' . $supplier['nit']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Bodega</label>
            <select name="warehouse_id" required>
                <option value="">Seleccionar</option>
                <?php foreach ($warehouses as $warehouse): ?>
                    <option value="<?= $warehouse['id'] ?>" <?= (($old['warehouse_id'] ?? '') == $warehouse['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($warehouse['codigo'] . ' - ' . $warehouse['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-actions">
        <button class="btn-primary">Guardar rollo</button>
        <a href="<?= BASE_URL ?>/rolls" class="btn-secondary">Cancelar</a>
    </div>
</form>
