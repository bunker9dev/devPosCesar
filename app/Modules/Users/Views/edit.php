<div class="form-container">

    <form method="POST" action="<?= BASE_URL ?>/users/update" enctype="multipart/form-data" class="form-users">

        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <!-- Usuario -->
        <div class="form-group">
            <label>Usuario</label>
            <input
                type="text"
                value="<?= htmlspecialchars($user['username']) ?>"
                disabled>
            <input type="hidden" name="username" value="<?= htmlspecialchars($user['username']) ?>">
        </div>

        <!-- Nombre -->
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($user['nombre']) ?>" required>
        </div>

        <!-- Apellido -->
        <div class="form-group">
            <label>Apellido</label>
            <input type="text" name="apellido" value="<?= htmlspecialchars($user['apellido']) ?>">
        </div>

        <!-- Password -->
        <div class="form-group">
            <label>Nueva contraseña</label>
            <input
                id="password"
                type="password"
                name="password"
                placeholder="Nueva contraseña">
            <small class="input-msg"></small>
        </div>

        <!-- Avatar -->
        <div class="form-group">
            <label>Avatar actual</label>

            <img
                src="<?= $user['avatar_url'] ?>"
                class="avatar-preview"
                id="preview"> 
        </div>

        <div class="form-group">
            <label>Cambiar Avatar</label>

            <input
                type="file"
                name="imagen"
                id="input-imagen" 
            accept="image/*">
        </div>

        <!-- Rol -->
        <div class="form-group">
            <label>Rol</label>

            <select name="rol_id" <?= !$canEdit ? 'disabled' : '' ?>>

                <?php foreach ($roles as $r): ?>

                    <option
                        value="<?= $r['id'] ?>"
                        <?= $r['id'] == $user['rol_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['nombre']) ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <!-- mantener valor si está deshabilitado -->
            <?php if (!$canEdit): ?>
                <input type="hidden" name="rol_id" value="<?= $user['rol_id'] ?>">
            <?php endif; ?>

        </div>

        <!-- Botones -->
        <div class="form-actions">

            <?php if ($canEdit): ?>
                <button type="submit" class="btn-primary">Actualizar</button>
            <?php endif; ?>

            <a href="<?= BASE_URL ?>/users" class="btn-secondary">Cancelar</a>
        </div>

    </form>

</div>

<!-- CONFIG GLOBAL -->
<script>
    window.BASE_URL = "<?= BASE_URL ?>";
</script>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/users-edit.js"></script>