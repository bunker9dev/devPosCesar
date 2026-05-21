<!-- <h2 class="page-title">Usuarios</h2> -->

<div class="users-header">
    <a href="<?= BASE_URL ?>/users/create" class="btn-primary">+ Crear usuario</a>
</div>

<div class="table-container">
    <table id="tablaUsuarios" class="table-users display ">
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
                <!-- <th>Último acceso</th> -->  <!-- PENDIENTE ACTIVAR -->
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

                    <td data-label="Estado">

                        <span
                            class="badge estado-toggle 
                            <?= $u['estado'] == 1 ? 'active' : ($u['estado'] == 2 ? 'inactive' : 'deleted') ?>"

                            data-id="<?= $u['id'] ?>"
                            data-estado="<?= $u['estado'] ?>">

                            <?php if ($u['estado'] == 1): ?>
                                Activo
                            <?php elseif ($u['estado'] == 2): ?>
                                Inactivo
                            <?php else: ?>
                                Eliminado
                            <?php endif; ?>

                        </span>

                    </td>
                    <td data-label="Acciones">
                        <div class="actions">
                            <a href="<?= BASE_URL ?>/users/edit?id=<?= $u['id'] ?>" class="btn-action edit">Editar</a>
                            <a href="<?= BASE_URL ?>/users/delete?id=<?= $u['id'] ?>" class="btn-action delete">Eliminar</a>
                            <?php if ($_SESSION['user']['rol'] == 1 && $u['estado'] == 0): ?>
                                <button
                                    class="btn-restore"
                                    data-id="<?= $u['id'] ?>">
                                    Restaurar
                                </button>
                            <?php endif; ?>

                        </div>
                    </td>

                    <!-- PENDIENTE ACTIVAR -->
                    <!-- <td>
                        <?= $u['ultimo_login']
                            ? date('d/m/Y H:i', strtotime($u['ultimo_login']))
                            : 'Nunca' ?>
                    </td> -->

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>