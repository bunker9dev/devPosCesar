<!-- <h2 class="page-title">Usuarios</h2> -->

<div class="module-header">
    <a href="<?= BASE_URL ?>/users/create" class="btn-primary">+ Crear usuario</a>
</div>

<div class="table-container">
    <table id="tablaUsuarios" class="table-main display ">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Foto</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
                <!-- <th>Último acceso</th> --> <!-- PENDIENTE ACTIVAR -->
            </tr>
        </thead>

        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <th></th>

                    <td data-label="ID"><?= $u['id'] ?></td>

                    <td data-label="Usuario"><?= $u['username'] ?></td>

                    <td data-label="Nombre"><?= $u['nombre'] ?></td>

                    <td>
                        <img src="<?= BASE_URL ?>/assets/img/users/<?= !empty($u['imagen']) ? $u['imagen'] : 'default.png' ?>"
                            class="avatar">
                    </td>

                    <td data-label="Rol"><?= $u['rol'] ?></td>

                    <!-- =========================
                    ESTADO (STANDARD)
                    ========================== -->
                    <td data-label="Estado">

                        <?php $estado = (int)$u['estado']; ?>

                        <span
                            class="badge estado-toggle toggle-user 
                            <?= $estado === $Status::ACTIVO ? 'active' : ($estado === $Status::INACTIVO ? 'inactive' : 'deleted') ?>"
                            
                            data-id="<?= $u['id'] ?>"
                            data-url="<?= BASE_URL ?>/users/toggle"
                            data-estado="<?= $estado ?>">

                            <?= $estado === $Status::ACTIVO ? 'Activo' : ($estado === $Status::INACTIVO ? 'Inactivo' : 'Eliminado') ?>

                        </span>

                        </td>

                        <!-- =========================
                        ACCIONES (CON PERMISOS)
                        ========================== -->
                        <td data-label="Acciones">
                            <div class="actions">

                                <!-- ✏️ EDITAR -->
                                <?php if ($canEdit && $estado !== $Status::ELIMINADO): ?>
                                    <a href="<?= BASE_URL ?>/users/edit?id=<?= $u['id'] ?>" class="btn-action edit">
                                        Editar
                                    </a>
                                <?php endif; ?>

                                <!-- 🗑️ ELIMINAR -->
                                <?php if ($estado !== $Status::ELIMINADO && $canDelete): ?>
                                    <button class="btn-action delete btn-delete"
                                        data-id="<?= $u['id'] ?>"
                                        data-name="<?= htmlspecialchars($u['username']) ?>"
                                        data-entity="usuario">
                                        Eliminar
                                    </button>
                                <?php endif; ?>

                                <!-- ♻️ RESTAURAR -->
                                <?php if ($estado === $Status::ELIMINADO && $canRestore): ?>
                                    <button class="btn-action restore btn-restore"
                                        data-id="<?= $u['id'] ?>">
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