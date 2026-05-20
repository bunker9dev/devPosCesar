<div class="form-container">

    <form method="POST" action="<?= BASE_URL ?>/users/update" enctype="multipart/form-data" class="form-users">

        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <!-- Usuario -->
        <div class="form-group">
            <label>Usuario</label>
            <input
                type="text"
                value="<?= $user['username'] ?>"
                disabled>
            <input type="hidden" name="username" value="<?= $user['username'] ?>">
        </div>

        <!-- Nombre -->
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" value="<?= $user['nombre'] ?>" required>
        </div>

        <!-- Apellido -->
        <div class="form-group">
            <label>Apellido</label>
            <input type="text" name="apellido" value="<?= $user['apellido'] ?>">
        </div>

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
                src="<?= BASE_URL ?>/assets/img/users/<?= $user['imagen'] ?>"
                class="avatar-preview"
                id="preview">
        </div>

        <div class="form-group">
            <label>Cambiar Avatar</label>
            <input type="file" name="imagen" accept="image/*">
        </div>

        <!-- Rol -->
        <div class="form-group">
            <label>Rol</label>
            <select name="rol_id">
                <?php foreach ($roles as $r): ?>

                    <?php if ($r['id'] == 1 && $_SESSION['user']['rol'] != 1) continue; ?>

                    <option
                        value="<?= $r['id'] ?>"
                        <?= $r['id'] == $user['rol_id'] ? 'selected' : '' ?>>
                        <?= $r['nombre'] ?>
                    </option>

                <?php endforeach; ?>
            </select>
        </div>

        <!-- Botones -->
        <div class="form-actions">
            <button type="submit" class="btn-primary">Actualizar</button>
            <a href="<?= BASE_URL ?>/users" class="btn-secondary">Cancelar</a>
        </div>

    </form>

</div>



<!-- scritps para ajax -->
<script>
    window.BASE_URL = "<?= BASE_URL ?>";
</script>
<script type="module" src="<?= BASE_URL ?>/assets/js/pages/users-edit.js"></script>



<!-- ######################################################################################################################## -->





<!-- ######################################################################################################################## -->

<!-- 


<form method="POST" action="<?= BASE_URL ?>/users/update">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <input name="nombre" value="<?= $user['nombre'] ?>">
    <input name="apellido" value="<?= $user['apellido'] ?>">

    <select name="rol_id">
        <?php foreach ($roles as $r): ?>
            <option value="<?= $r['id'] ?>" <?= $r['id'] == $user['rol_id'] ? 'selected' : '' ?>>
                <?= $r['nombre'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button>Actualizar</button>
</form> -->