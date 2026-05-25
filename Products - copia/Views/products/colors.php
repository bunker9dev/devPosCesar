<form method="POST" action="<?= BASE_URL ?>/products/colors/store" class="form-users inventory-form catalog-single-form">
    <div class="form-group">
        <label>Nombre del color</label>
        <input name="nombre" placeholder="Ej: Azul Noche" autocomplete="off" required>
    </div>

    <div class="form-actions">
        <button class="btn-primary">Agregar</button>
        <a href="<?= BASE_URL ?>/products" class="btn-secondary">Volver</a>
    </div>
</form>

<div class="table-container">
    <table id="tablaFabricColors" class="table-main display">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Código</th>
                <th>Color</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($colors as $color): ?>
                <tr>
                    <th></th>
                    <td data-label="ID"><?= $color['id'] ?></td>
                    <td data-label="Código"><?= htmlspecialchars($color['codigo']) ?></td>
                    <td data-label="Color"><?= htmlspecialchars($color['nombre']) ?></td>
                    <td data-label="Estado"><?= $color['estado'] ? 'Activo' : 'Inactivo' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
