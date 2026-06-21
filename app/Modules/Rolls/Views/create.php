<div class="page-header">
    <!-- <h2>Crear rollo(s)</h2> -->
    <?php if ($purchaseId): ?>
        <a href="<?= BASE_URL ?>/purchases/show?id=<?= $purchaseId ?>" class="btn-secondary">← Volver a la compra</a>
    <?php else: ?>
        <a href="<?= BASE_URL ?>/rolls" class="btn-secondary">← Volver al listado</a>
    <?php endif; ?>
</div>

<form id="formCreateRoll" class="form-grid-2col">

    <div class="form-group">
        <label>Tipo de tela</label>
        <select name="fabric_type_id" id="createFabricType" required>
            <option value="">Seleccionar...</option>
            <?php foreach ($types as $t): ?>
                <option value="<?= $t['id'] ?>" data-codigo="<?= htmlspecialchars($t['codigo']) ?>">
                    <?= htmlspecialchars($t['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Color</label>
        <select name="fabric_color_id" id="createFabricColor" required>
            <option value="">Seleccionar...</option>
            <?php foreach ($colors as $c): ?>
                <option value="<?= $c['id'] ?>" data-codigo="<?= htmlspecialchars($c['codigo']) ?>">
                    <?= htmlspecialchars($c['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Proveedor</label>
        <select name="supplier_id" id="createSupplier" required>
            <option value="">Seleccionar...</option>
            <?php foreach ($suppliers as $s): ?>
                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Bodega asignada</label>
        <select name="warehouse_id" id="createWarehouse" required>
            <option value="">Seleccionar...</option>
            <?php foreach ($warehouses as $w): ?>
                <option value="<?= $w['id'] ?>"><?= htmlspecialchars($w['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Fecha de compra / ingreso</label>
        <input
            type="date"
            name="fecha_compra"
            id="createFechaCompra"
            value="<?= date('Y-m-d') ?>"
            required>
    </div>

    <div class="form-group">
        <label>Metraje por rollo</label>
        <input type="number" step="0.01" min="0.01" name="metraje_inicial" id="createMetraje" required>
    </div>

    <div class="form-group">
        <label>Cantidad de rollos</label>
        <input type="number" min="1" max="200" name="cantidad" id="createCantidad" value="1" required>
    </div>

    <?php if ($canViewPrice): ?>
        <div class="form-group">
            <label>Precio de compra por metro (opcional)</label>
            <input type="number" step="0.01" min="0" name="precio_compra" id="createPrecio">
        </div>
    <?php endif; ?>

    <div class="form-group form-actions-full">
        <label>Código de lote (vista previa)</label>
        <input type="text" id="lotePreview" readonly placeholder="Se genera automáticamente al completar los datos...">
        <!-- <small id="rollPreviewHint"></small> -->
    </div>

    <div class="form-actions form-actions-full">
        <button type="submit" class="btn-primary">Crear</button>
        <a href="<?= BASE_URL ?>/rolls" class="btn-secondary">Cancelar</a>
    </div>

</form>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/rolls-create.js"></script>