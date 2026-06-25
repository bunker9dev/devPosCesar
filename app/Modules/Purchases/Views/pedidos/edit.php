<div class="page-header">

    <!-- <h2>Editar pedido: <?= htmlspecialchars($pedido['consecutivo']) ?></h2> -->

    <a href="<?= BASE_URL ?>/pedidos/show?id=<?= $pedido['id'] ?>" class="btn-secondary">← Volver al pedido</a>
    
</div>

<div class="card">
    <h3>Datos del pedido</h3>
    <div class="form-grid-2col">
        <div class="form-group">
            <label>Proveedor</label>
            <select id="headerSupplierId" required>
                <option value="">Seleccionar...</option>
                <?php foreach ($suppliers as $s): ?>
                    <option value="<?= $s['id'] ?>" <?= $s['id'] == $pedido['supplier_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Fecha de solicitud</label>
            <input type="date" id="headerFecha" value="<?= htmlspecialchars($pedido['fecha_solicitud']) ?>" required>
        </div>

        <div class="form-group form-actions-full">
            <label>Observaciones (opcional)</label>
            <textarea id="headerObservaciones" rows="2"><?= htmlspecialchars($pedido['observaciones'] ?? '') ?></textarea>
        </div>
    </div>
</div>

<div class="card">
    <h3>Agregar tela al pedido</h3>
    <div class="form-grid-2col">
        <div class="form-group">
            <label>Tipo de tela</label>
            <select id="itemFabricType" required>
                <option value="">Seleccionar...</option>
                <?php foreach ($types as $t): ?>
                    <option value="<?= $t['id'] ?>" data-nombre="<?= htmlspecialchars($t['nombre']) ?>"><?= htmlspecialchars($t['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Color</label>
            <select id="itemFabricColor" required>
                <option value="">Seleccionar...</option>
                <?php foreach ($colors as $c): ?>
                    <option value="<?= $c['id'] ?>" data-nombre="<?= htmlspecialchars($c['nombre']) ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Cantidad</label>
            <input type="number" step="0.01" min="0.01" id="itemCantidad">
        </div>

        <div class="form-group">
            <label>Unidad</label>
            <select id="itemUnidad">
                <option value="metros">Metros</option>
                <option value="rollos">Rollos</option>
            </select>
        </div>

        <div class="form-group form-actions-full">
            <label>Nota (opcional)</label>
            <input type="text" id="itemNota">
        </div>

        <div class="form-actions form-actions-full">
            <button type="button" id="btnAgregarItem" class="btn-primary">+ Agregar tela al pedido</button>
        </div>
    </div>
</div>

<div class="card">
    <h3>Telas en este pedido</h3>
    <table class="table-main" id="tablaItemsPendientes">
        <thead>
            <tr><th>Tipo</th><th>Color</th><th>Cantidad</th><th>Unidad</th><th>Nota</th><th></th></tr>
        </thead>
        <tbody id="itemsPendientesBody"></tbody>
    </table>
</div>

<div class="form-actions">
    <button type="button" id="btnGuardarPedido" class="btn-primary">Guardar cambios</button>
    <a href="<?= BASE_URL ?>/pedidos/show?id=<?= $pedido['id'] ?>" class="btn-secondary">Cancelar</a>
</div>

<!-- Datos existentes del pedido, para que el JS los cargue en memoria al iniciar -->
<script type="application/json" id="itemsExistentes">
<?= json_encode(array_map(function ($item) {
    return [
        'fabric_type_id' => $item['fabric_type_id'],
        'fabric_color_id' => $item['fabric_color_id'],
        'tipo_nombre' => $item['tipo_nombre'],
        'color_nombre' => $item['color_nombre'],
        'cantidad' => $item['cantidad'],
        'unidad' => $item['unidad'],
        'nota' => $item['nota'],
    ];
}, $pedido['items'])) ?>
</script>

<script>
    window.PEDIDO_ID = <?= $pedido['id'] ?>;
</script>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/pedidos-edit.js"></script>