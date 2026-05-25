<table id="tablaFabricTypes" class="table-main display">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Código</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th>Acciones</th> <!-- 🔥 FALTABA -->
        </tr>
    </thead>

    <tbody>
        <?php foreach ($types as $type): ?>
            <tr class="<?= !empty($type['deleted_at']) ? 'deleted' : '' ?>">

                <th></th>

                <td data-label="ID"><?= $type['id'] ?></td>
                <td data-label="Código"><?= htmlspecialchars($type['codigo']) ?></td>
                <td data-label="Nombre"><?= htmlspecialchars($type['nombre']) ?></td>

                <td data-label="Estado">
                    <?php if (!empty($type['deleted_at'])): ?>
                        Eliminado
                    <?php else: ?>
                        <?= $type['estado'] ? 'Activo' : 'Inactivo' ?>
                    <?php endif; ?>
                </td>

                <td data-label="Acciones">

                    <?php if ($_SESSION['user']['rol'] === 'admin' || $_SESSION['user']['rol'] === 'super'): ?>

                        <!-- EDITAR -->
                        <a href="<?= BASE_URL ?>/products/types/edit/<?= $type['id'] ?>" class="btn-edit">
                            Editar
                        </a>

                        <?php if (empty($type['deleted_at'])): ?>

                            <!-- ELIMINAR -->
                            <?php if ($_SESSION['user']['rol'] === 'admin'): ?>
                                <button class="btn-delete" data-id="<?= $type['id'] ?>">
                                    Eliminar
                                </button>
                            <?php endif; ?>

                        <?php else: ?>

                            <!-- RESTAURAR -->
                            <?php if ($_SESSION['user']['rol'] === 'super'): ?>
                                <button class="btn-restore" data-id="<?= $type['id'] ?>">
                                    Restaurar
                                </button>
                            <?php endif; ?>

                        <?php endif; ?>

                    <?php endif; ?>

                </td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>