<form method="POST" action="<?= BASE_URL ?>/users/update">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <input name="nombre" value="<?= $user['nombre'] ?>">
    <input name="apellido" value="<?= $user['apellido'] ?>">

    <select name="rol_id">
        <?php foreach($roles as $r): ?>
            <option value="<?= $r['id'] ?>" <?= $r['id']==$user['rol_id']?'selected':'' ?>>
                <?= $r['nombre'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button>Actualizar</button>
</form>