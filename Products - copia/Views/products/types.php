<form method="POST" action="<?= BASE_URL ?>/products/fabric-types/store" class="form-users inventory-form catalog-single-form">
    <div class="form-group">
        <label>Nombre del tipo de tela</label>
        <input name="nombre" placeholder="Ej: Algodón Bordado" autocomplete="off" required>
    </div>

    <div class="form-actions">
        <button class="btn-primary">Agregar</button>
        <a href="<?= BASE_URL ?>/products" class="btn-secondary">Volver</a>
    </div>
</form>

<div class="table-container">
    <table id="tablaFabricTypes" class="table-main display">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($types as $type): ?>
                <tr>
                    <th></th>
                    <td data-label="ID"><?= $type['id'] ?></td>
                    <td data-label="Código"><?= htmlspecialchars($type['codigo']) ?></td>
                    <td data-label="Nombre"><?= htmlspecialchars($type['nombre']) ?></td>
                    <td data-label="Estado"><?= $type['estado'] ? 'Activo' : 'Inactivo' ?></td>
                    <td>
                        <?php if ($_SESSION['user']['rol'] === 'admin' || $_SESSION['user']['rol'] === 'super'): ?>

                            <!-- EDITAR -->
                            <a href="<?= BASE_URL ?>/products/types/edit/<?= $type['id'] ?>" class="btn-edit">
                                Editar
                            </a>

                            <?php if (empty($type['deleted_at'])): ?>

                                <!-- ELIMINAR (ADMIN) -->
                                <?php if ($_SESSION['user']['rol'] === 'admin'): ?>
                                    <button class="btn-delete" data-id="<?= $type['id'] ?>">
                                        Eliminar
                                    </button>
                                <?php endif; ?>

                            <?php else: ?>

                                <!-- RESTAURAR (SOLO SUPER) -->
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
</div>