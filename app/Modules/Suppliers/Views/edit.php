<form method="POST" action="<?= BASE_URL ?>/suppliers/update/<?= $supplier['id'] ?>">

    <input name="nombre" value="<?= $supplier['nombre'] ?>" required>
    <input name="apellidos" value="<?= $supplier['apellidos'] ?>">
    <input name="nit" value="<?= $supplier['nit'] ?>" required>
    <input name="ciudad" value="<?= $supplier['ciudad'] ?>">

    <?php if ($isSuper): ?>
        <input name="email" value="<?= $supplier['email'] ?>">
        <input name="telefono" value="<?= $supplier['telefono'] ?>">
    <?php endif; ?>

    <button>Actualizar</button>

</form>