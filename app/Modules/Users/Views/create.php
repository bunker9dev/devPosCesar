<form method="POST" action="<?= BASE_URL ?>/users/store" class="form-users">

    <div class="form-group">
        <label>Username</label>
        <input id="username" name="username" placeholder="Username" required>
        <small id="username-msg" class="input-msg"></small>
    </div>

    <div class="form-group">
        <label>Nombre</label>
        <input name="nombre" placeholder="Nombre" required>
    </div>

    <div class="form-group">
        <label>Apellido</label>
        <input name="apellido" placeholder="Apellido">
    </div>

    <div class="form-group">
        <label>Password</label>
        <input id="password" type="password" name="password" required>
        <small id="password-msg" class="input-msg"></small>
    </div>

    <div class="form-group">
        <label>Rol</label>
        <select name="rol_id">
            <?php foreach ($roles as $r): ?>
                <option value="<?= $r['id'] ?>">
                    <?= ucfirst($r['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-actions">
        <button class="btn-primary">Guardar</button>
        <a href="<?= BASE_URL ?>/users" class="btn-secondary">Cancelar</a>
    </div>

</form>

<!-- scritps para ajax -->
<script>
    window.BASE_URL = "<?= BASE_URL ?>";
</script>
<script type="module" src="<?= BASE_URL ?>/assets/js/pages/users-create.js"></script>