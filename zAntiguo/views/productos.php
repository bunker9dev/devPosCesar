<?php
require_once "controllers/productoController.php";
$productos = productoController::listar();
?>

<h2>productos</h2>

<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre producto" required>
    <button type="submit">Guardar</button>
</form>

<?php
productoController::crear();
?>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
    </tr>

    <?php foreach($productos as $p): ?>
    <tr>
        <td><?= $p["id"] ?></td>
        <td><?= $p["nombre"] ?></td>
    </tr>
    <?php endforeach; ?>
</table>