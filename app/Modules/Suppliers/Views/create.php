<form method="POST" action="<?= BASE_URL ?>/suppliers/store" class="form-users">

    <div class="form-group">
        <label>Nombre</label>
        <input id="nombre" name="nombre" required>
        <small id="nombre-msg" class="input-msg"></small>
    </div>

    <div class="form-group">
        <label>Apellidos</label>
        <input name="apellidos">
    </div>

    <div class="form-group">
        <label>Ciudad</label>
        <input id="ciudad" name="ciudad">
    </div>

    <div class="form-group">
        <label>Teléfono</label>
        <input id="telefono" name="telefono">
        <small id="telefono-msg" class="input-msg"></small>
    </div>

    <div class="form-actions">
        <button class="btn-primary">Guardar</button>
        <a href="<?= BASE_URL ?>/suppliers" class="btn-secondary">Cancelar</a>
    </div>

</form>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/suppliers-create.js"></script>