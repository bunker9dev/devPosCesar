<!-- ================================
   EDIT FABRIC TYPE MODAL
================================ -->

<div id="modalEditType" class="modal hidden">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <h2 class="modal-title">Editar tipo de tela</h2>
        <form id="formEditType">
            <input type="hidden" id="editTypeId">
            
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" id="editTypeName" required>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-secondary btn-cancel">
                    Cancelar
                </button>

                <button type="submit" class="btn-primary">
                    Actualizar
                </button>
            </div>
        </form>
    </div>

</div>


<!-- ================================
   DELETE FABRIC TYPE MODAL
================================ -->

<div id="modalDeleteType" class="modal hidden">

    <div class="modal-overlay"></div>

    <div class="modal-content">

        <h2 class="modal-title">Eliminar tipo de tela</h2>

        <p id="deleteTypeMessage">
            ¿Seguro que deseas eliminar este tipo de tela?
        </p>

        <div class="modal-actions">
            <button type="button" class="btn-secondary btn-cancel">
                Cancelar
            </button>

            <button type="button" id="btnConfirmDeleteType" class="btn-danger">
                Eliminar
            </button>
        </div>

    </div>

</div>