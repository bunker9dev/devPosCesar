<?php

use App\Core\Status;
?>


<div class="module-header">
    <a href="<?= BASE_URL ?>/suppliers/create" class="btn-primary">
        + Crear proveedor
    </a>
</div>

<div class="table-container">
    <table id="tablaSuppliers" class="table-main display">

        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Proveedor</th>
                <th>NIT</th>
                <th>Ciudad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($suppliers as $s): ?>

                <?php $estado = (int)$s['estado']; ?>

                <tr data-id="<?= $s['id'] ?>">

                    <th></th>

                    <td data-label="ID"><?= $s['id'] ?></td>

                    <!-- NOMBRE -->
                    <td data-label="Proveedor">
                        <?= htmlspecialchars($s['nombre']) ?>
                    </td>

                    <!-- NIT -->
                    <td data-label="NIT">
                        <?= htmlspecialchars($s['nit']) ?>
                    </td>

                    <!-- CIUDAD -->
                    <td data-label="Ciudad">
                        <?= htmlspecialchars($s['ciudad']) ?>
                    </td>

                    <!-- ESTADO -->
                    <td data-label="Estado">
                        <span
                            class="badge toggle-supplier <?= Status::class($estado) ?>"
                            data-id="<?= $s['id'] ?>"
                            data-url="<?= BASE_URL ?>/suppliers/toggle"
                            data-estado="<?= $estado ?>">

                            <?= Status::label($estado) ?>

                        </span>
                    </td>

                    <!-- ACCIONES -->
                    <td data-label="Acciones">
                        <div class="actions">

                            <!-- EDITAR -->
                            <?php if ($s['estado'] !== Status::ELIMINADO): ?>

                                <?php if ($canEdit): ?>
                                    <a href="<?= BASE_URL ?>/suppliers/edit?id=<?= $s['id'] ?>" class="btn-action edit">
                                        Editar
                                    </a>
                                <?php endif; ?>
                                <!-- ELIMINAR -->
                                <?php if ($canDelete): ?>
                                    <button
                                        class="btn-action delete btn-delete"
                                        data-id="<?= $s['id'] ?>"
                                        data-name="<?= htmlspecialchars($s['nombre']) ?>"
                                        data-url="<?= BASE_URL ?>/suppliers/delete">
                                        Eliminar
                                    </button>
                                <?php endif; ?>

                            <?php else: ?>
                                <!-- RESTAURAR -->
                                <?php if ($canRestore): ?>
                                    <button
                                        class="btn-action restore btn-restore"
                                        data-id="<?= $s['id'] ?>"
                                        data-url="<?= BASE_URL ?>/suppliers/restore">
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
    window.USER_ROLE_ID = <?= $_SESSION['user']['rol_id'] ?>;
</script>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/suppliers-index.js"></script>