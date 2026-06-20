<!-- EDIT WAREHOUSE MODAL -->
<div id="modalEditWarehouse" class="modal hidden">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <h2 class="modal-title">Editar bodega</h2>
        <form id="formEditWarehouse">
            <input type="hidden" id="editWarehouseId">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" id="editWarehouseName" required>
            </div>
            <div class="form-group">
                <label>Ubicación</label>
                <input type="text" id="editWarehouseUbicacion">
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-secondary btn-cancel">Cancelar</button>
                <button type="submit" class="btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<!-- DELETE WAREHOUSE MODAL -->
<div id="modalDeleteWarehouse" class="modal hidden">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <h2 class="modal-title">Eliminar bodega</h2>
        <p id="deleteWarehouseMessage">¿Seguro que deseas eliminar esta bodega?</p>
        <div class="modal-actions">
            <button type="button" class="btn-secondary btn-cancel">Cancelar</button>
            <button type="button" id="btnConfirmDeleteWarehouse" class="btn-danger">Eliminar</button>
        </div>
    </div>
</div>