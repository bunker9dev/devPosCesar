<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success" id="alertMessage">
        <?= $_SESSION['success'] ?>
    </div>
<?php unset($_SESSION['success']);
endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-error" id="alertMessage">
        <?= $_SESSION['error'] ?>
    </div>
<?php unset($_SESSION['error']);
endif; ?>


<!-- ================================
   FORM CREATE
================================ -->
<form method="POST" action="<?= BASE_URL ?>/warehouses/store">

    <div class="inline-create-pro">

        <div class="input-group-pro">
            <input
                type="text"
                name="nombre"
                placeholder="Nombre de bodega"
                required>

            <input
                type="text"
                name="ubicacion"
                placeholder="Ubicación (opcional)">
        </div>


        <button class="btn-primary">
            + Crear
        </button>

    </div>

</form>


<!-- ================================
   TABLE
================================ -->


<div class="table-container">

    <table class="table-main">

        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($warehouses as $w): ?>
                <tr data-id="<?= $w['id'] ?>">

                    <td><?= $w['id'] ?></td>

                    <td><?= htmlspecialchars($w['nombre']) ?></td>

                    <td>
                        <?= htmlspecialchars($w['ubicacion'] ?? '-') ?>
                    </td>

                    <td data-label="Estado">

                        <?php $estado = (int)$w['estado']; ?>

                        <span
                            class="badge estado-toggle btn-action is-clickable 
        <?= $estado == -1
                    ? 'deleted'
                    : ($estado == 1 ? 'active' : 'inactive') ?>"

                            data-id="<?= $w['id'] ?>"
                            data-url="<?= BASE_URL ?>/warehouses/toggle"

                            data-label-active="Activo"
                            data-label-inactive="Inactivo"
                            data-label-deleted="Eliminado">
                            <?php if ($estado === -1): ?>
                                Eliminado
                            <?php elseif ($estado === 1): ?>
                                Activo
                            <?php else: ?>
                                Inactivo
                            <?php endif; ?>
                        </span>

                    </td>
                    <td data-label="Acciones">
                        <div class="actions">

                            <?php if ($w['estado'] != -1): ?>

                                <!-- EDITAR -->
                                <?php if ($canEdit): ?>
                                    <button
                                        class="btn-action edit btn-edit-warehouse"
                                        data-id="<?= $w['id'] ?>"
                                        data-name="<?= htmlspecialchars($w['nombre']) ?>"
                                        data-ubicacion="<?= htmlspecialchars($w['ubicacion'] ?? '') ?>">
                                        Editar
                                    </button>
                                <?php endif; ?>

                                <!-- ELIMINAR -->
                                <?php if ($canDelete): ?>
                                    <button
                                        class="btn-danger btn-delete"
                                        data-id="<?= $w['id'] ?>"
                                        data-url="<?= BASE_URL ?>/warehouses/delete"
                                        data-name="<?= htmlspecialchars($w['nombre']) ?>"
                                        data-entity="bodega">
                                        Eliminar
                                    </button>
                                <?php endif; ?>

                            <?php else: ?>

                                <!-- RESTAURAR -->
                                <?php if ($rol === 'super'): ?>
                                    <button
                                        class="btn-restore"
                                        data-id="<?= $w['id'] ?>"
                                        data-url="<?= BASE_URL ?>/warehouses/restore">
                                        Restaurar
                                    </button>
                                <?php endif; ?>

                            <?php endif; ?>

                        </div>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</div>