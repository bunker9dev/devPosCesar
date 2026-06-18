<?php

use App\Core\Status; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success" id="alertMessage">
        <i data-lucide="check-circle"></i>
        <?= $_SESSION['success'] ?>
    </div>
<?php unset($_SESSION['success']);
endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-error" id="alertMessage">
        <i data-lucide="alert-circle"></i>
        <?= $_SESSION['error'] ?>
    </div>
<?php unset($_SESSION['error']);
endif; ?>


<!-- =========================
   CREAR COLOR
========================= -->
<form method="POST" action="<?= BASE_URL ?>/products/colors/store" id="formCreateColor">

    <div class="inline-create-pro">

        <div class="input-group-pro">
            <i data-lucide="palette"></i>

            <input
                id="inputColorName"
                type="text"
                name="nombre"
                placeholder="Escribir color..."
                autocomplete="off"
                required>
        </div>

        <button type="submit" class="btn-primary btn-create">
            + Crear
        </button>

    </div>

</form>


<!-- =========================
   TABLA
========================= -->
<div class="table-container">

    <table id="tablaColors" class="table-main display">

        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Código</th>
                <th>Color</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($colors as $color): ?>

                <tr
                    data-id="<?= $color['id'] ?>"
                    class="<?= $color['estado'] == Status::ELIMINADO ? 'deleted' : '' ?>">

                    <td></td>

                    <!-- ID -->
                    <td data-label="ID"><?= $color['id'] ?></td>

                    <!-- CODIGO -->
                    <td data-label="Código">
                        <?= htmlspecialchars($color['codigo']) ?>
                    </td>

                    <!-- NOMBRE -->
                    <td data-label="Color">
                        <?= htmlspecialchars($color['nombre']) ?>
                    </td>

                    <!-- =========================
                         ESTADO
                    ========================== -->
                    <td data-label="Estado">

                        <?php if ($color['estado'] === Status::ELIMINADO): ?>

                            <span class="badge deleted">
                                <?= Status::label($color['estado']) ?>
                            </span>

                        <?php else: ?>

                            <button
                                class="badge toggle-color <?= $color['estado'] == Status::ACTIVO ? 'active' : 'inactive' ?>"
                                data-id="<?= $color['id'] ?>"
                                data-url="<?= BASE_URL ?>/products/colors/toggle"
                                data-estado="<?= $color['estado'] ?>">

                                <?= Status::label($color['estado']) ?>

                            </button>

                        <?php endif; ?>

                    </td>

                    <!-- =========================
                         ACCIONES
                    ========================== -->
                    <td data-label="Acciones">
                        <div class="actions">

                            <!-- EDIT -->
                            <?php if ($canEdit && $color['estado'] !== Status::ELIMINADO): ?>
                                <button
                                    class="btn-action edit btn-edit"
                                    data-id="<?= $color['id'] ?>"
                                    data-name="<?= htmlspecialchars($color['nombre']) ?>">
                                    Editar
                                </button>
                            <?php endif; ?>

                            <!-- DELETE -->
                            <?php if ($color['estado'] !== Status::ELIMINADO && $canDelete): ?>
                                <button
                                    class="btn-action delete btn-delete"
                                    data-id="<?= $color['id'] ?>"
                                    data-url="<?= BASE_URL ?>/products/colors/delete"
                                    data-name="<?= htmlspecialchars($color['nombre']) ?>">
                                    Eliminar
                                </button>
                            <?php endif; ?>

                            <!-- RESTORE -->
                            <?php if ($color['estado'] === Status::ELIMINADO && $canRestore): ?>
                                <button
                                    class="btn-action restore btn-restore"
                                    data-id="<?= $color['id'] ?>"
                                    data-url="<?= BASE_URL ?>/products/colors/restore">
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


<!-- =========================
   MODALES
========================= -->
<?php require __DIR__ . '/modals.php'; ?>


<!-- =========================
   JS PAGE
========================= -->

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/colors-index.js"></script>