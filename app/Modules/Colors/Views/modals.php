<!-- ================================
   EDIT COLOR MODAL
================================ -->

<div id="modalEditColor" class="modal hidden">

    <div class="modal-overlay"></div>

    <div class="modal-content">

        <h2 class="modal-title">Editar color</h2>

        <form id="formEditColor">

            <input type="hidden" id="editColorId">

            <div class="form-group">
                <label>Nombre</label>
                <input type="text" id="editColorName" required>
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
   DELETE COLOR MODAL
================================ -->

<div id="modalDeleteColor" class="modal hidden">

    <div class="modal-overlay"></div>

    <div class="modal-content">

        <h2 class="modal-title">Eliminar color</h2>

        <p id="deleteColorMessage">
            ¿Seguro que deseas eliminar este color?
        </p>

        <div class="modal-actions">
            <button type="button" class="btn-secondary btn-cancel">
                Cancelar
            </button>

            <button type="button" id="btnConfirmDeleteColor" class="btn-danger">
                Eliminar
            </button>
        </div>

    </div>

</div>