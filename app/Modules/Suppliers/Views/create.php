<?php
$old = $_SESSION['old'] ?? [];
$errors = $_SESSION['errors'] ?? [];

unset($_SESSION['old'], $_SESSION['errors']);

function oldValue($field, $old) {
    return htmlspecialchars($old[$field] ?? '');
}
?>

<form method="POST" action="<?= BASE_URL ?>/suppliers/store" class="form-users">

    <!-- NOMBRE -->
    <div class="form-group">
        <label>Nombre o razón social</label>
        <input 
            id="nombre"
            name="nombre"
            placeholder="Ej: Comercial XYZ SAS"
            value="<?= oldValue('nombre', $old) ?>"
            autocomplete="organization"
            required
        >

        <?php if (!empty($errors['nombre'])): ?>
            <small class="input-msg error"><?= $errors['nombre'] ?></small>
        <?php else: ?>
            <small id="nombre-msg" class="input-msg"></small>
        <?php endif; ?>
    </div>

    <!-- APELLIDOS -->
    <div class="form-group">
        <label>Apellidos (opcional)</label>
        <input 
            name="apellidos"
            value="<?= oldValue('apellidos', $old) ?>"
            autocomplete="off"
        >
    </div>

    <!-- NIT -->
    <div class="form-group">
        <label>Cédula / NIT</label>
        <input 
            id="nit"
            name="nit"
            placeholder="Número de identificación"
            value="<?= oldValue('nit', $old) ?>"
            autocomplete="off"
            required
        >

        <?php if (!empty($errors['nit'])): ?>
            <small class="input-msg error"><?= $errors['nit'] ?></small>
        <?php else: ?>
            <small id="nit-msg" class="input-msg"></small>
        <?php endif; ?>
    </div>

    <!-- CIUDAD -->
    <div class="form-group">
        <label>Ciudad</label>
        <input 
            name="ciudad"
            placeholder="Medellín"
            value="<?= oldValue('ciudad', $old) ?>"
            autocomplete="address-level2"
        >
    </div>

    <!-- CAMPOS EDITABLES -->
    <?php if ($canEdit): ?>

        <div class="form-group">
            <label>Email (opcional)</label>
            <input 
                type="email"
                name="email"
                placeholder="correo@empresa.com"
                value="<?= oldValue('email', $old) ?>"
                autocomplete="email"
            >
        </div>

        <div class="form-group">
            <label>Teléfono (opcional)</label>
            <input 
                id="telefono"
                name="telefono"
                placeholder="3001234567"
                value="<?= oldValue('telefono', $old) ?>"
                autocomplete="tel"
            >

            <small id="telefono-msg" class="input-msg"></small>
        </div>

    <?php endif; ?>

    <!-- BOTONES -->
    <div class="form-actions">
        <button class="btn-primary">Guardar</button>
        <a href="<?= BASE_URL ?>/suppliers" class="btn-secondary">Cancelar</a>
    </div>

</form>

<script>
    window.BASE_URL = "<?= BASE_URL ?>";
</script>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/suppliers-form.js"></script>