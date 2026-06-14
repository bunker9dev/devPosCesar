<form method="POST" 
      action="<?= BASE_URL ?>/users/store" 
      class="form-users"
      enctype="multipart/form-data"> <!-- 🔥 IMPORTANTE -->

    <!-- USERNAME -->
    <div class="form-group">
        <label>Usuario</label>
        <input type="text" name="username" id="username" required>
        <small id="username-msg" class="input-msg"></small>
    </div>

    <!-- NOMBRE -->
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="nombre" required>
    </div>

    <!-- APELLIDO -->
    <div class="form-group">
        <label>Apellido</label>
        <input type="text" name="apellido">
    </div>

    <!-- PASSWORD -->
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" id="password" required>
        <small class="input-msg"></small> 
    </div>

    <!--  AVATAR -->
    <div class="form-group">
        <label>Foto</label>

        <!-- PREVIEW -->
        <img 
            src="<?= BASE_URL ?>/assets/img/users/default.png"
            id="preview"
            class="avatar-preview">

        <!-- INPUT -->
        <input 
            type="file" 
            name="imagen"
            accept="image/*">
    </div>

    <!-- ROL -->
    <div class="form-group">
        <label>Rol</label>

        <select name="rol_id">
            <?php foreach ($roles as $r): ?>
                <option value="<?= $r['id'] ?>">
                    <?= htmlspecialchars($r['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- BOTONES -->
    <div class="form-actions">
        <button type="submit" class="btn-primary">Guardar</button>
        <a href="<?= BASE_URL ?>/users" class="btn-secondary">Cancelar</a>
    </div>

</form>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/users-create.js"></script>

<script type="module">
    import { Events } from "/assets/js/core/events.js";

    Events.emit("users:create");
</script>