<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success" id="alertMessage">
        <i data-lucide="check-circle"></i>
        <?= $_SESSION['success'] ?>
    </div>
<?php unset($_SESSION['success']); endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-error" id="alertMessage">
        <i data-lucide="alert-circle"></i>
        <?= $_SESSION['error'] ?>
    </div>
<?php unset($_SESSION['error']); endif; ?>


<!-- ======================================================
CREATE FORM (USERS STYLE CLEAN)
====================================================== -->
<form method="POST" action="<?= BASE_URL ?>/fabric-types/store" id="formCreateType">

    <div class="inline-create-pro">

        <div class="input-group-pro">
            <i data-lucide="tag"></i>

            <input
                type="text"
                name="nombre"
                placeholder="Tipo de tela..."
                autocomplete="off"
                required>
        </div>

        <button type="submit" class="btn-primary btn-create">
            + Crear
        </button>

    </div>

</form>


<!-- ======================================================
🔥 TABLE
====================================================== -->
<div class="table-container">

    <table id="tablaFabricTypes" class="table-main display">

        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($types as $type): ?>

                <?php $estado = (int)$type['estado']; ?>

                <tr data-id="<?= $type['id'] ?>">

                    <td></td>

                    <!-- ID -->
                    <td data-label="ID">
                        <?= $type['id'] ?>
                    </td>

                    <!-- CODIGO -->
                    <td data-label="Código">
                        <?= htmlspecialchars($type['codigo']) ?>
                    </td>

                    <!-- NOMBRE -->
                    <td data-label="Nombre">
                        <?= htmlspecialchars($type['nombre']) ?>
                    </td>

                    <!-- ESTADO -->
                    <td data-label="Estado">

                        <span
                            class="badge estado-toggle toggle-type
                            <?= $estado === $Status::ACTIVO ? 'active' : ($estado === $Status::INACTIVO ? 'inactive' : 'deleted') ?>"

                            data-id="<?= $type['id'] ?>"
                            data-url="<?= BASE_URL ?>/fabric-types/toggle"
                            data-estado="<?= $estado ?>">

                            <?= $estado === $Status::ACTIVO
                                ? 'Activo'
                                : ($estado === $Status::INACTIVO
                                    ? 'Inactivo'
                                    : 'Eliminado') ?>

                        </span>

                    </td>

                    <!-- ACCIONES -->
                    <td data-label="Acciones">

                        <div class="actions">

                            <!-- EDIT -->
                            <?php if ($canEdit): ?>
                                <button
                                    class="btn-action edit btn-edit"
                                    data-id="<?= $type['id'] ?>"
                                    data-url="<?= BASE_URL ?>/fabric-types/update">
                                    Editar
                                </button>
                            <?php endif; ?>

                            <!-- DELETE -->
                            <?php if ($estado !== $Status::ELIMINADO && $canDelete): ?>
                                <button
                                    class="btn-action delete btn-delete"
                                    data-id="<?= $type['id'] ?>"
                                    data-url="<?= BASE_URL ?>/fabric-types/delete"
                                    data-entity="tipo de tela">
                                    Eliminar
                                </button>
                            <?php endif; ?>

                            <!-- RESTORE -->
                            <?php if ($estado === $Status::ELIMINADO && $canRestore): ?>
                                <button
                                    class="btn-action restore btn-restore"
                                    data-id="<?= $type['id'] ?>"
                                    data-url="<?= BASE_URL ?>/fabric-types/restore">
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

<script type="module" src="<?= BASE_URL ?>/assets/js/core/app.js"></script>