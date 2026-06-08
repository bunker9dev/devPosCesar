<?php

$old = $_SESSION['old'] ?? [];
$errors = $_SESSION['errors'] ?? [];

unset($_SESSION['old'], $_SESSION['errors']);

function oldValue($field, $old, $supplier) {
    return htmlspecialchars($old[$field] ?? $supplier[$field] ?? '');
}
?>

<form method="POST" 
      action="<?= BASE_URL ?>/suppliers/update" 
      class="form-suppliers"
      data-id="<?= $supplier['id'] ?>">

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

    <!-- CONTACTO -->
    <div class="form-group">
        <label>Contacto</label>
        <input 
            name="contacto"
            value="<?= oldValue('contacto', $old, $supplier) ?>"
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

    <?php if ($canEdit): ?>

        <!-- EMAIL -->
        <div class="form-group">
            <label>Email</label>
            <input 
                name="email"
                value="<?= oldValue('email', $old, $supplier) ?>"
            >
        </div>

        <!-- TELÉFONO -->
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

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/suppliers-edit.js"></script>