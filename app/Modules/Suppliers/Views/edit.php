<?php

$old = $_SESSION['old'] ?? [];
$errors = $_SESSION['errors'] ?? [];

unset($_SESSION['old'], $_SESSION['errors']);

function oldValue($field, $old, $supplier) {
    return htmlspecialchars($old[$field] ?? $supplier[$field] ?? '');
}
?>

<form method="POST" action="<?= BASE_URL ?>/suppliers/update" class="form-users">

    <input type="hidden" name="id" value="<?= $supplier['id'] ?>">

    <!-- NOMBRE -->
    <div class="form-group">
        <label>Nombre o razón social</label>
        <input 
            id="nombre"
            name="nombre"
            value="<?= oldValue('nombre', $old, $supplier) ?>"
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
        <label>Apellidos</label>
        <input 
            name="apellidos"
            value="<?= oldValue('apellidos', $old, $supplier) ?>"
        >
    </div>

    <!-- NIT -->
    <div class="form-group">
        <label>NIT</label>
        <input 
            id="nit"
            name="nit"
            value="<?= oldValue('nit', $old, $supplier) ?>"
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
            value="<?= oldValue('ciudad', $old, $supplier) ?>"
        >
    </div>

    <!-- CAMPOS EDITABLES -->
    <?php if ($canEdit): ?>

        <div class="form-group">
            <label>Email</label>
            <input 
                name="email"
                value="<?= oldValue('email', $old, $supplier) ?>"
            >
        </div>

        <div class="form-group">
            <label>Teléfono</label>
            <input 
                id="telefono"
                name="telefono"
                value="<?= oldValue('telefono', $old, $supplier) ?>"
            >

            <small id="telefono-msg" class="input-msg"></small>
        </div>

    <?php endif; ?>

    <!-- BOTONES -->
    <div class="form-actions">
        <button class="btn-primary">Actualizar</button>
        <a href="<?= BASE_URL ?>/suppliers" class="btn-secondary">Cancelar</a>
    </div>

</form>

<script>
    window.BASE_URL = "<?= BASE_URL ?>";
</script>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/suppliers-form.js"></script>