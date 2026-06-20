<!-- EDIT LOTE MODAL -->
<div id="modalEditLote" class="modal hidden">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <h2 class="modal-title">Editar lote</h2>

        <p class="modal-subtitle">
            Código actual: <strong id="editLoteCodigoActual"></strong>
        </p>

        <form id="formEditLote" class="form-grid-2col">

            <input type="hidden" id="editLoteId">

            <div class="form-group">
                <label>Tipo de tela</label>
                <select id="editLoteFabricType" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($types as $t): ?>
                        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Color</label>
                <select id="editLoteFabricColor" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($colors as $c): ?>
                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Proveedor</label>
                <select id="editLoteSupplier" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($suppliers as $s): ?>
                        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Bodega asignada</label>
                <select id="editLoteWarehouse" required>
                    <option value="">Seleccionar...</option>
                    <?php foreach ($warehouses as $w): ?>
                        <option value="<?= $w['id'] ?>"><?= htmlspecialchars($w['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Fecha de compra</label>
                <input type="date" id="editLoteFecha" required>
            </div>

            <div class="form-group">
                <label>Metros por rollo</label>
                <input type="number" step="0.01" min="0.01" id="editLoteMetraje" required>
            </div>

            <?php if ($canViewPrice ?? false): ?>
                <div class="form-group">
                    <label>Precio de compra por metro (opcional)</label>
                    <input type="number" step="0.01" min="0" id="editLotePrecio">
                </div>
            <?php endif; ?>

            <div class="form-group form-actions-full">
                <small>⚠️ Si cambias tipo, color, proveedor, fecha o metraje, el código del lote y de todos sus rollos se va a regenerar.</small>
            </div>

            <div class="modal-actions form-actions-full">
                <button type="button" class="btn-secondary btn-cancel">Cancelar</button>
                <button type="submit" class="btn-primary">Actualizar</button>
            </div>

        </form>
    </div>
</div>


<!-- DELETE LOTE MODAL -->
<div id="modalDeleteLote" class="modal hidden">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <h2 class="modal-title">Eliminar lote</h2>
        <p id="deleteLoteMessage">¿Seguro que deseas eliminar este lote?</p>
        <div class="modal-actions">
            <button type="button" class="btn-secondary btn-cancel">Cancelar</button>
            <button type="button" id="btnConfirmDeleteLote" class="btn-danger">Eliminar</button>
        </div>
    </div>
</div>