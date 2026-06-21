<div class="page-header">
    <!-- <h2>Crear compra</h2> -->
    <a href="<?= BASE_URL ?>/purchases" class="btn-secondary">← Volver al listado</a>
</div>

<!-- =========================
   CABECERA DE LA COMPRA
========================= -->
<div class="card">
    <h3>Datos del proveedor</h3>

    <div class="form-grid-2col">

        <div class="form-group">
            <label>Proveedor</label>
            <div class="input-with-button">
                <select id="headerSupplierId" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($suppliers as $s): ?>
                        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nombre']) ?> (<?= htmlspecialchars($s['nit']) ?>)</option>
                    <?php endforeach; ?>
                </select>
                <button type="button" id="btnOpenQuickSupplier" class="btn-secondary">+ Nuevo</button>
            </div>
        </div>

        <div class="form-group">
            <label>Número de documento / factura</label>
            <input type="text" id="headerNumeroDocumento" required>
        </div>

        <div class="form-group">
            <label>Fecha de compra</label>
            <input type="date" id="headerFecha" value="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="form-group">
            <label>Condición de pago</label>
            <select id="headerCondicionPago" required>
                <option value="contado">Contado</option>
                <option value="credito">Crédito</option>
            </select>
        </div>

        <div class="form-group" id="headerPlazoDiasGroup" style="display:none;">
            <label>Plazo de pago</label>
            <select id="headerPlazoDias">
                <option value="30">30 días</option>
                <option value="60">60 días</option>
                <option value="90">90 días</option>
            </select>
        </div>

        <div class="form-group form-actions-full">
            <label>Observaciones (opcional)</label>
            <textarea id="headerObservaciones" rows="2"></textarea>
        </div>

    </div>
</div>


<!-- =========================
   AGREGAR UN LOTE
========================= -->
<div class="card">
    <h3>Agregar tela a esta compra</h3>

    <div class="form-grid-2col">

        <div class="form-group">
            <label>Tipo de tela</label>
            <select id="loteFabricType" required>
                <option value="">Seleccionar...</option>
                <?php foreach ($types as $t): ?>
                    <option value="<?= $t['id'] ?>" data-codigo="<?= htmlspecialchars($t['codigo']) ?>" data-nombre="<?= htmlspecialchars($t['nombre']) ?>">
                        <?= htmlspecialchars($t['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Color</label>
            <select id="loteFabricColor" required>
                <option value="">Seleccionar...</option>
                <?php foreach ($colors as $c): ?>
                    <option value="<?= $c['id'] ?>" data-codigo="<?= htmlspecialchars($c['codigo']) ?>" data-nombre="<?= htmlspecialchars($c['nombre']) ?>">
                        <?= htmlspecialchars($c['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Bodega</label>
            <select id="loteWarehouse" required>
                <option value="">Seleccionar...</option>
                <?php foreach ($warehouses as $w): ?>
                    <option value="<?= $w['id'] ?>" data-nombre="<?= htmlspecialchars($w['nombre']) ?>">
                        <?= htmlspecialchars($w['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Metros por rollo</label>
            <input type="number" step="0.01" min="0.01" id="loteMetraje">
        </div>

        <div class="form-group">
            <label>Cantidad de rollos</label>
            <input type="number" min="1" max="200" id="loteCantidad" value="1">
        </div>

        <?php if ($canViewPrice): ?>
            <div class="form-group">
                <label>Precio por metro (opcional)</label>
                <input type="number" step="0.01" min="0" id="lotePrecio">
            </div>
        <?php endif; ?>

        <div class="form-actions form-actions-full">
            <button type="button" id="btnAgregarLote" class="btn-primary">+ Agregar lote a la compra</button>
        </div>

    </div>
</div>


<!-- =========================
   LOTES YA AGREGADOS (se llena con JS)
========================= -->
<div class="card">
    <h3>Telas agregadas a esta compra</h3>

    <table class="table-main" id="tablaLotesPendientes">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Color</th>
                <th>Bodega</th>
                <th>Metros</th>
                <th>Cantidad</th>
                <?php if ($canViewPrice): ?><th>Precio/m</th>
                    <th>Subtotal</th><?php endif; ?>
                <th></th>
            </tr>
        </thead>
        <tbody id="lotesPendientesBody">
            <tr id="emptyLotesRow">
                <td colspan="<?= $canViewPrice ? 8 : 6 ?>" class="empty-state">
                    Todavía no has agregado ninguna tela.
                </td>
            </tr>
        </tbody>
        <?php if ($canViewPrice): ?>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align:right;"><strong>Total estimado:</strong></td>
                    <td colspan="2"><strong id="totalEstimado">$0.00</strong></td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>
</div>

<div class="form-actions">
    <button type="button" id="btnCerrarCompra" class="btn-primary">Cerrar compra</button>
    <a href="<?= BASE_URL ?>/purchases" class="btn-secondary">Cancelar</a>
</div>

<?php require __DIR__ . '/modals.php'; ?>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/purchases-create.js"></script>