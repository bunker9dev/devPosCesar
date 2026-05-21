<?php
$old = $_SESSION['old'] ?? [];
$errors = $_SESSION['errors'] ?? [];

unset($_SESSION['old'], $_SESSION['errors']);

// 🔥 Prioridad: old → BD
function oldValue($field, $old, $supplier) {
    return $old[$field] ?? $supplier[$field] ?? '';
}
?>

<form method="POST" action="<?= BASE_URL ?>/suppliers/update?id=<?= $supplier['id'] ?>" class="form-users">

    <!-- NOMBRE -->
    <div class="form-group">
        <label>Nombre o razón social</label>
        <input 
            id="nombre"
            name="nombre"
            value="<?= oldValue('nombre', $old, $supplier) ?>"
            placeholder="Ej: Comercial XYZ SAS"
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
            value="<?= oldValue('apellidos', $old, $supplier) ?>"
            placeholder="Solo si aplica"
        >
    </div>

    <!-- NIT -->
    <div class="form-group">
        <label>Cédula / NIT</label>
        <input 
            id="nit"
            name="nit"
            value="<?= oldValue('nit', $old, $supplier) ?>"
            placeholder="Número de identificación"
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
            placeholder="Medellín"
        >
    </div>

    <!-- CAMPOS SOLO SUPER -->
    <?php if ($isSuper): ?>

        <div class="form-group">
            <label>Email (opcional)</label>
            <input 
                name="email"
                value="<?= oldValue('email', $old, $supplier) ?>"
                placeholder="correo@empresa.com"
            >
        </div>

        <div class="form-group">
            <label>Teléfono (opcional)</label>
            <input 
                id="telefono"
                name="telefono"
                value="<?= oldValue('telefono', $old, $supplier) ?>"
                placeholder="3001234567"
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

<!-- 🔥 REUTILIZAS EL MISMO JS -->
<script type="module" src="<?= BASE_URL ?>/assets/js/pages/suppliers-create.js"></script>