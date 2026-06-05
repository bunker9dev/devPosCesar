<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success" id="alertMessage">
        <?= $_SESSION['success'] ?>
    </div>
<?php unset($_SESSION['success']); endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-error" id="alertMessage">
        <?= $_SESSION['error'] ?>
    </div>
<?php unset($_SESSION['error']); endif; ?>


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

        <button class="btn-primary btn-create">
            + Crear
        </button>

    </div>

</form>


<!-- ================================
   TABLE
================================ -->

<div class="table-container">

    <table id="tablaWarehouses" class="table-main display">

        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Nombre</th>
                <th>Ubicación</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($warehouses as $w): ?>

                <?php $estado = (int)$w['estado']; ?>

                <tr
                    data-id="<?= $w['id'] ?>"
                    class="<?= $estado === 0 ? 'deleted' : '' ?>">

                    <td></td>

                    <td data-label="ID"><?= $w['id'] ?></td>

                    <td data-label="Nombre">
                        <?= htmlspecialchars($w['nombre']) ?>
                    </td>

                    <td data-label="Ubicación">
                        <?= htmlspecialchars($w['ubicacion'] ?? '-') ?>
                    </td>

                    <!-- ======================
                        ESTADO (TOGGLE)
                    ====================== -->
                    <td data-label="Estado">
                        <span
                            class="badge estado-toggle is-clickable
                            <?= $estado === 1 ? 'active' : ($estado === 2 ? 'inactive' : 'deleted') ?>"

                            data-id="<?= $w['id'] ?>"
                           data-url="/warehouses/toggle"
                            data-estado="<?= $estado ?>"

                            data-label-active="Activo"
                            data-label-inactive="Inactivo"
                            data-label-deleted="Eliminado">

                            <?= $estado === 1 ? 'Activo' : ($estado === 2 ? 'Inactivo' : 'Eliminado') ?>

                        </span>
                    </td>

                    <!-- ======================
                        ACCIONES
                    ====================== -->
                    <td data-label="Acciones">
                        <div class="actions">

                            <?php if ($estado !== 0): ?>

                                <!-- EDIT -->
                                <?php if ($canEdit): ?>
                                    <button
                                        class="btn-action edit btn-edit-warehouse"
                                        data-id="<?= $w['id'] ?>"
                                        data-name="<?= htmlspecialchars($w['nombre']) ?>"
                                        data-ubicacion="<?= htmlspecialchars($w['ubicacion'] ?? '') ?>">
                                        Editar
                                    </button>
                                <?php endif; ?>

                                <!-- DELETE -->
                                <?php if ($canDelete): ?>
                                    <button
                                        class="btn-action delete btn-delete"
                                        data-id="<?= $w['id'] ?>"
                                        data-url="/warehouses/delete"
                                        data-name="<?= htmlspecialchars($w['nombre']) ?>"
                                        data-entity="bodega">
                                        Eliminar
                                    </button>
                                <?php endif; ?>

                            <?php else: ?>

                                <!-- RESTORE -->
                                <?php if ($canRestore): ?>
                                    <button
                                        class="btn-action restore btn-restore"
                                        data-id="<?= $w['id'] ?>"
                                        data-url="/warehouses/restore">
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

<script>
    window.BASE_URL = "<?= BASE_URL ?>";
</script>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/warehouses-index.js"></script>

<script type="module">
    import { Events } from "<?= BASE_URL ?>/assets/js/core/events.js";
    Events.emit("warehouses:index");
</script>