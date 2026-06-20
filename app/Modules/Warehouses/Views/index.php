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

<?php if ($canCreate): ?>
<form method="POST" action="<?= BASE_URL ?>/warehouses/store">
    <div class="inline-create-pro">
        <div class="input-group-pro">
            <input type="text" name="nombre" placeholder="Nombre de bodega" required>
            <input type="text" name="ubicacion" placeholder="Ubicación (opcional)">
        </div>
        <button class="btn-primary btn-create">+ Crear</button>
    </div>
</form>
<?php endif; ?>

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
                <tr data-id="<?= $w['id'] ?>" class="<?= $estado === 0 ? 'deleted' : '' ?>">
                    <td></td>
                    <td data-label="ID"><?= $w['id'] ?></td>
                    <td data-label="Nombre"><?= htmlspecialchars($w['nombre']) ?></td>
                    <td data-label="Ubicación"><?= htmlspecialchars($w['ubicacion'] ?? '-') ?></td>

                    <td data-label="Estado">
                        <?php if ($estado === 0): ?>
                            <span class="badge deleted">Eliminado</span>
                        <?php else: ?>
                            <button
                                class="badge estado-toggle is-clickable <?= $estado === 1 ? 'active' : 'inactive' ?>"
                                data-id="<?= $w['id'] ?>"
                                data-url="<?= BASE_URL ?>/warehouses/toggle"
                                data-estado="<?= $estado ?>">
                                <?= $estado === 1 ? 'Activo' : 'Inactivo' ?>
                            </button>
                        <?php endif; ?>
                    </td>

                    <td data-label="Acciones">
                        <div class="actions">
                            <?php if ($estado !== 0): ?>
                                <?php if ($canEdit): ?>
                                    <button
                                        class="btn-action edit btn-edit-warehouse"
                                        data-id="<?= $w['id'] ?>"
                                        data-name="<?= htmlspecialchars($w['nombre']) ?>"
                                        data-ubicacion="<?= htmlspecialchars($w['ubicacion'] ?? '') ?>">
                                        Editar
                                    </button>
                                <?php endif; ?>

                                <?php if ($canDelete): ?>
                                    <button
                                        class="btn-action delete btn-delete-warehouse"
                                        data-id="<?= $w['id'] ?>"
                                        data-name="<?= htmlspecialchars($w['nombre']) ?>">
                                        Eliminar
                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if ($canRestore): ?>
                                    <button
                                        class="btn-action restore btn-restore"
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

<?php require __DIR__ . '/modals.php'; ?>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/warehouses-index.js"></script>