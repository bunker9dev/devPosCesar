<div class="module-header">
    <a href="<?= BASE_URL ?>/rolls/create" class="btn-primary">
        + Crear rollo
    </a>

    <a href="<?= BASE_URL ?>/products/types" class="btn-secondary">
        Tipos de tela
    </a>

    <a href="<?= BASE_URL ?>/products/colors" class="btn-secondary">
        Colores
    </a>
</div>

<div class="table-container">
    <table id="tablaProducts" class="table-main display">

        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Producto</th>
                <th>Tipo</th>
                <th>Color</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($products as $product): ?>

                <?php $estado = (int)$product['estado']; ?>

                <tr data-id="<?= $product['id'] ?>">

                    <th></th>

                    <td data-label="ID"><?= $product['id'] ?></td>

                    <td data-label="Producto">
                        <?= htmlspecialchars($product['nombre']) ?>
                    </td>

                    <td data-label="Tipo">
                        <?= htmlspecialchars($product['tipo_codigo'] . ' - ' . $product['tipo_nombre']) ?>
                    </td>

                    <td data-label="Color">
                        <span 
                            class="color-chip"
                            style="--swatch: <?= htmlspecialchars($product['hex'] ?: '#6b7280') ?>">
                        </span>

                        <?= htmlspecialchars($product['color_codigo'] . ' - ' . $product['color_nombre']) ?>
                    </td>

                    <!-- 🔥 ESTADO PRO -->
                    <td data-label="Estado">
                        <span
                            class="badge estado-toggle toggle-product
                            <?= $estado === $Status::ACTIVO ? 'active' : ($estado === $Status::INACTIVO ? 'inactive' : 'deleted') ?>"

                            data-id="<?= $product['id'] ?>"
                            data-url="<?= BASE_URL ?>/products/toggle"
                            data-estado="<?= $estado ?>">

                            <?= $estado === $Status::ACTIVO ? 'Activo' : ($estado === $Status::INACTIVO ? 'Inactivo' : 'Eliminado') ?>

                        </span>
                    </td>

                    <!-- 🔥 ACCIONES -->
                    <td data-label="Acciones">
                        <div class="actions">

                            <!-- EDIT -->
                            <?php if ($canEdit): ?>
                                <a 
                                    href="<?= BASE_URL ?>/products/edit?id=<?= $product['id'] ?>" 
                                    class="btn-action edit">
                                    Editar
                                </a>
                            <?php endif; ?>

                            <!-- DELETE -->
                            <?php if ($estado !== $Status::ELIMINADO && $canDelete): ?>
                                <button
                                    class="btn-action delete btn-delete"
                                    data-id="<?= $product['id'] ?>"
                                    data-url="<?= BASE_URL ?>/products/delete"
                                    data-name="<?= htmlspecialchars($product['nombre']) ?>"
                                    data-entity="producto">
                                    Eliminar
                                </button>
                            <?php endif; ?>

                            <!-- RESTORE -->
                            <?php if ($estado === $Status::ELIMINADO && $canRestore): ?>
                                <button
                                    class="btn-action restore btn-restore"
                                    data-id="<?= $product['id'] ?>"
                                    data-url="<?= BASE_URL ?>/products/restore">
                                    Restaurar
                                </button>
                            <?php endif; ?>

                        </div>
                    </td>

                </tr>

            <?php endforeach; ?>
        </tbody>

    </table>
</div>