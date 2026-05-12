<!-- <h2 class="page-title">Usuarios</h2> -->

<div class="users-header">
    <a href="<?= BASE_URL ?>/users/create" class="btn-primary">+ Crear usuario</a>
</div>

<div class="table-container">
    <table class="table-users">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td data-label="ID"><?= $u['id'] ?></td>
                    <td data-label="Usuario"><?= $u['username'] ?></td>
                    <td data-label="Nombre"><?= $u['nombre'] ?></td>
                    <td data-label="Rol"><?= $u['rol'] ?></td>

                    <td data-label="Estado">
                        <span class="badge <?= $u['estado'] ? 'active' : 'inactive' ?>">
                            <?= $u['estado'] ? 'Activo' : 'Inactivo' ?>
                        </span>
                    </td>

                    <td data-label="Acciones" class="actions">
                        <a href="<?= BASE_URL ?>/users/edit?id=<?= $u['id'] ?>" class="btn-edit">Editar</a>
                        <a href="<?= BASE_URL ?>/users/toggle?id=<?= $u['id'] ?>" class="btn-toggle">Estado</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>