<?php

$old = $_SESSION['old'] ?? [];
$errors = $_SESSION['errors'] ?? [];

unset($_SESSION['old'], $_SESSION['errors']);

// 🔥 helper tipo Laravel
function oldValue($field, $old, $type) {
    return htmlspecialchars($old[$field] ?? $type[$field] ?? '');
}
?>

<form method="POST" action="<?= BASE_URL ?>/products/types/update" class="form-users">

    <input type="hidden" name="id" value="<?= $type['id'] ?>">

    <!-- NOMBRE -->
    <div class="form-group">
        <label>Nombre del tipo de tela</label>

        <input 
            id="nombre"
            type="text" 
            name="nombre"
            value="<?= oldValue('nombre', $old, $type) ?>"
            placeholder="Ej: Algodón, Denim, Poliester..."
            required
            autofocus
        >

        <?php if (!empty($errors['nombre'])): ?>
            <small class="input-msg error"><?= $errors['nombre'] ?></small>
        <?php else: ?>
            <small id="nombre-msg" class="input-msg"></small>
        <?php endif; ?>
    </div>

    <!-- ACCIONES -->
    <div class="form-actions">

        <button type="submit" class="btn-primary">
            Actualizar
        </button>

        <a href="<?= BASE_URL ?>/products/types" class="btn-secondary">
            Cancelar
        </a>

    </div>

</form>

<!-- 🔥 BASE URL GLOBAL -->
<script>
    window.BASE_URL = "<?= BASE_URL ?>";
</script>

<!-- 🔥 REUTILIZA MISMO JS DE CREATE -->
<script type="module" src="<?= BASE_URL ?>/assets/js/pages/products-types-form.js"></script>