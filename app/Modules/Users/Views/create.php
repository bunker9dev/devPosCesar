<form method="POST" action="<?= BASE_URL ?>/users/store">
    <input name="username" placeholder="Username" required>
    <input name="nombre" placeholder="Nombre" required>
    <input name="apellido" placeholder="Apellido">
    <input type="password" name="password" placeholder="Password" required>

    <select name="rol_id">
        <?php foreach($roles as $r): ?>
            <option value="<?= $r['id'] ?>"><?= $r['nombre'] ?></option>
        <?php endforeach; ?>
    </select>

    <button>Guardar</button>
</form>