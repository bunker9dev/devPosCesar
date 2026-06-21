<!-- DELETE PURCHASE MODAL -->
<div id="modalDeletePurchase" class="modal hidden">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <h2 class="modal-title">Eliminar compra</h2>
        <p id="deletePurchaseMessage">¿Seguro que deseas eliminar esta compra?</p>
        <div class="modal-actions">
            <button type="button" class="btn-secondary btn-cancel">Cancelar</button>
            <button type="button" id="btnConfirmDeletePurchase" class="btn-danger">Eliminar</button>
        </div>
    </div>
</div>


<!-- QUICK CREATE SUPPLIER MODAL (reutilizado en create.php) -->
<div id="modalQuickSupplier" class="modal hidden">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <h2 class="modal-title">Crear proveedor rápido</h2>

        <form id="formQuickSupplier">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre" id="quickSupplierNombre" required>
            </div>

            <div class="form-group">
                <label>NIT</label>
                <input type="text" name="nit" id="quickSupplierNit" required>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-secondary btn-cancel">Cancelar</button>
                <button type="submit" class="btn-primary">Crear y seleccionar</button>
            </div>
        </form>
    </div>
</div>