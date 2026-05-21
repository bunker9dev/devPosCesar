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
                <th>Nombre</th>
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

                    <td><?= $s['id'] ?></td>
                    <td><?= $s['nombre'] ?></td>
                    <td><?= $s['nit'] ?></td>
                    <td><?= $s['ciudad'] ?></td>

                    <!-- ESTADO  -->
                    <td>

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
                    <td>
                        <div class="actions">

                            <a href="<?= BASE_URL ?>/suppliers/edit/<?= $s['id'] ?>" class="btn-action edit">
                                Editar
                            </a>

                            <?php if ($s['estado'] != 0): ?>
                                <button class="btn-action delete" data-id="<?= $s['id'] ?>">
                                    Eliminar
                                </button>
                            <?php elseif ($isSuper): ?>
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