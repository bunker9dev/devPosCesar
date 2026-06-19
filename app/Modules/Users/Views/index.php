<div class="module-header">
    <?php if ($canCreate): ?>
        <a href="<?= BASE_URL ?>/users/create" class="btn-primary">+ Crear usuario</a>
    <?php endif; ?>
</div>

<div class="table-container">
    <table id="tablaUsuarios" class="table-main display">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Foto</th>
                <th>Rol</th>
                <th>Último acceso</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <th></th>

                    <!-- ID -->
                    <td data-label="ID">
                        <?= $u['id'] ?>
                    </td>

                    <!-- USERNAME (RBAC) -->
                    <td data-label="Usuario">
                        <?= !empty($u['username'])
                            ? htmlspecialchars($u['username'])
                            : '—' ?>
                    </td>

                    <!-- NOMBRE -->
                    <td data-label="Nombre">
                        <?= htmlspecialchars($u['nombre']) ?>
                    </td>

                    <!-- AVATAR -->
                    <td>
                        <img src="<?= $u['avatar_url'] ?>" class="avatar">
                    </td>

                    <!-- ROL -->
                    <td data-label="Rol">
                        <?= htmlspecialchars($u['rol']) ?>
                    </td>

                    <!-- ÚLTIMO LOGIN -->
                    <td data-label="Último acceso">
                        <?= $u['ultimo_login'] ?>
                    </td>

                    <!-- =========================
                    ESTADO
                    ========================== -->
                    <td data-label="Estado">
                        <span
                            class="badge estado-toggle toggle-user <?= $u['estado_class'] ?>"
                            data-id="<?= $u['id'] ?>"
                            data-url="<?= BASE_URL ?>/users/toggle"
                            data-estado="<?= $u['estado'] ?>">
                            <?= $u['estado_label'] ?>
                        </span>
                    </td>

                    <!-- =========================
                    ACCIONES
                    ========================== -->
                    <td data-label="Acciones">
                        <div class="actions">

                            <!-- EDITAR -->
                            <?php if ($canEdit && $u['estado'] !== \App\Core\Status::ELIMINADO): ?>
                                <a href="<?= BASE_URL ?>/users/edit?id=<?= $u['id'] ?>" class="btn-action edit">
                                    Editar
                                </a>
                            <?php endif; ?>

                            <!-- ELIMINAR -->
                            <?php if ($canDelete && $u['estado'] !== \App\Core\Status::ELIMINADO): ?>
                                <button class="btn-action delete btn-delete"
                                    data-id="<?= $u['id'] ?>"
                                    data-url="<?= BASE_URL ?>/users/delete"
                                    data-name="<?= htmlspecialchars($u['nombre']) ?>"
                                    data-entity="usuario">
                                    Eliminar
                                </button>
                            <?php endif; ?>

                            <!-- RESTAURAR -->
                            <?php if ($canRestore && $u['estado'] === \App\Core\Status::ELIMINADO): ?>
                                <button class="btn-action restore btn-restore"
                                    data-id="<?= $u['id'] ?>"
                                    data-url="<?= BASE_URL ?>/users/restore">
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



<script>
    window.BASE_URL = "<?= BASE_URL ?>";
    window.USER_ROLE_ID = <?= $_SESSION['user']['rol_id'] ?>;
</script>

<script type="module" src="<?= BASE_URL ?>/assets/js/pages/users-index.js"></script>