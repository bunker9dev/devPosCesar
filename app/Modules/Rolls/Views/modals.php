<!-- EDIT LOTE MODAL -->
<div id="modalEditLote" class="modal hidden">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <h2 class="modal-title">Editar lote</h2>

        <form id="formEditLote">
            <input type="hidden" id="editLoteId">

            <div class="form-group">
                <label>Bodega asignada</label>
                <select id="editLoteWarehouse" required>
                    <?php foreach ($warehouses ?? [] as $w): ?>
                        <option value="<?= $w['id'] ?>"><?= htmlspecialchars($w['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Precio de compra por metro (opcional)</label>
                <input type="number" step="0.01" min="0" id="editLotePrecio">
            </div>

            <div class="modal-actions">
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