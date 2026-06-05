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


<!-- 🔥 CREAR COLOR -->
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


<!-- 🔥 TABLA -->
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
                    class="<?= !empty($color['deleted_at']) ? 'deleted' : '' ?>">

                    <td></td>

                    <td data-label="ID"><?= $color['id'] ?></td>

                    <td data-label="Código">
                        <?= htmlspecialchars($color['codigo']) ?>
                    </td>

                    <!-- 🔥 COLOR VISUAL -->
                    <td data-label="Color">
                        <span
                            class="color-chip"
                            style="--swatch: <?= htmlspecialchars($color['hex'] ?? '#6b7280') ?>">
                        </span>

                        <?= htmlspecialchars($color['nombre']) ?>
                    </td>

                    <!-- 🔥 ESTADO -->
                    <td data-label="Estado">
                        <?php if (!empty($color['deleted_at'])): ?>
                            <span class="badge deleted">Eliminado</span>
                        <?php else: ?>
                            <span class="badge active">Disponible</span>
                        <?php endif; ?>
                    </td>

                    <!-- 🔥 ACCIONES -->
                    <td data-label="Acciones">
                        <div class="actions">

                            <!-- ✅ EDIT (CORREGIDO) -->
                            <?php if ($canEdit && empty($color['deleted_at'])): ?>
                                <button
                                    class="btn-action edit btn-edit"
                                    data-id="<?= $color['id'] ?>"
                                    data-name="<?= htmlspecialchars($color['nombre']) ?>"
                                    data-url="<?= BASE_URL ?>/products/colors/update">
                                    Editar
                                </button>
                            <?php endif; ?>

                            <!-- DELETE -->
                            <?php if (empty($color['deleted_at']) && $canDelete): ?>
                                <button
                                    class="btn-action delete btn-delete"
                                    data-id="<?= $color['id'] ?>"
                                    data-url="<?= BASE_URL ?>/products/colors/delete"
                                    data-name="<?= htmlspecialchars($color['nombre']) ?>"
                                    data-entity="color">
                                    Eliminar
                                </button>
                            <?php endif; ?>

                            <!-- RESTORE -->
                            <?php if (!empty($color['deleted_at']) && $canRestore): ?>
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