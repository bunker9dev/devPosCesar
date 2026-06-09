<?php
$old = $_SESSION['old'] ?? [];
$errors = $_SESSION['errors'] ?? [];

unset($_SESSION['old'], $_SESSION['errors']);

function oldValue($field, $old) {
    return htmlspecialchars($old[$field] ?? '');
}
?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form 
    method="POST" 
    action="<?= BASE_URL ?>/suppliers/store" 
    class="form-suppliers"
    id="formSuppliers"
>

    <!-- NOMBRE -->
    <div class="form-group">
        <label>Nombre o razón social</label>
        <input 
            type="text"
            name="nombre"
            id="nombre"
            value="<?= oldValue('nombre', $old) ?>"
            required
        >
        <small id="nombre-msg" class="input-msg"></small>
    </div>

    <!-- NIT -->
    <div class="form-group">
        <label>NIT</label>
        <input 
            type="text"
            name="nit"
            id="nit"
            data-exists="false"
            value="<?= oldValue('nit', $old) ?>"
            required
        >
        <small id="nit-msg" class="input-msg"></small>
    </div>

    <!-- CIUDAD -->
    <div class="form-group">
        <label>Ciudad</label>
        <input 
            type="text"
            name="ciudad"
            value="<?= oldValue('ciudad', $old) ?>"
        >
    </div>

    <!-- EMAIL -->
    <div class="form-group">
        <label>Email</label>
        <input 
            type="email"
            name="email"
            value="<?= oldValue('email', $old) ?>"
        >
    </div>

    <!-- TELÉFONO -->
    <div class="form-group">
        <label>Teléfono</label>
        <input 
            type="text"
            name="telefono"
            id="telefono"
            value="<?= oldValue('telefono', $old) ?>"
        >
        <small id="telefono-msg" class="input-msg"></small>
    </div>

    <!-- BOTONES -->
    <div class="form-actions">
        <button type="submit" class="btn-primary" id="btnSubmit">
            Guardar
        </button>
        <a href="<?= BASE_URL ?>/suppliers" class="btn-secondary">
            Cancelar
        </a>
    </div>

</form>

<script>
    window.BASE_URL = "<?= BASE_URL ?>";
</script>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/suppliers-create.js"></script>