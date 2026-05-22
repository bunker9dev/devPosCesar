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
                <tr>

                    <th></th>

                    <td data-label="ID"><?= $s['id'] ?></td>

                    <!-- 🔥 NOMBRE COMPLETO -->
                    <td data-label="Proveedor">
                        <?= $s['nombre_completo'] ?? ($s['nombre'] . ' ' . $s['apellidos']) ?>
                    </td>

                    <td data-label="NIT"><?= $s['nit'] ?></td>
                    <td data-label="Ciudad"><?= $s['ciudad'] ?></td>

                    <!-- ESTADO -->
                    <td data-label="Estado">
                        <span
                            class="badge estado-toggle 
                            <?= $s['estado'] == 1 ? 'active' : ($s['estado'] == 2 ? 'inactive' : 'deleted') ?>"

                            data-id="<?= $s['id'] ?>"
                            data-estado="<?= $s['estado'] ?>">

                            <?php if ($s['estado'] == 1): ?>
                                Activo
                            <?php elseif ($s['estado'] == 2): ?>
                                Inactivo
                            <?php else: ?>
                                Eliminado
                            <?php endif; ?>

                        </span>
                    </td>

                    <!-- ACCIONES -->
                    <td data-label="Acciones">
                        <div class="actions">

                            <!-- ✏️ EDITAR -->
                            <?php if ($canEdit): ?>
                                <a href="<?= BASE_URL ?>/suppliers/edit?id=<?= $s['id'] ?>" class="btn-action edit">
                                    Editar
                                </a>
                            <?php endif; ?>

                            <!-- 🗑️ ELIMINAR -->
                            <?php if ($s['estado'] != 0 && $canDelete): ?>
                                <button class="btn-action delete" data-id="<?= $s['id'] ?>">
                                    Eliminar
                                </button>
                            <?php endif; ?>

                            <!-- ♻️ RESTAURAR -->
                            <?php if ($s['estado'] == 0 && $rol === 'super'): ?>
                                <button class="btn-restore" data-id="<?= $s['id'] ?>">
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