<!-- <h2 class="page-title">Usuarios</h2> -->

<div class="users-header">
    <a href="<?= BASE_URL ?>/users/create" class="btn-primary">+ Crear usuario</a>
</div>

<div class="table-container">
    <table id="tablaUsuarios" class="table-users display " >
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
                            class="badge estado-toggle <?= $u['estado'] ? 'active' : 'inactive' ?>"
                            data-id="<?= $u['id'] ?>"
                            data-estado="<?= $u['estado'] ?>">
                            <?= $u['estado'] ? 'Activo' : 'Inactivo' ?>
                        </span>
                    </td>
                    <td data-label="Acciones" class="actions">
                        <a href="<?= BASE_URL ?>/users/edit?id=<?= $u['id'] ?>" class="btn-edit">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>