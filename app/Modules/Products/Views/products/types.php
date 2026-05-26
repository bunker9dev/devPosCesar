<?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success" id="alertMessage">
        <i data-lucide="check-circle"></i>
        <?= $_SESSION['success'] ?>
    </div>
<?php unset($_SESSION['success']); endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="alert alert-error" id="alertMessage">
        <i data-lucide="alert-circle"></i>
        <?= $_SESSION['error'] ?>
    </div>
<?php unset($_SESSION['error']); endif; ?>


<!-- 🔥 CREAR TIPO DE TELA -->
<form method="POST" action="<?= BASE_URL ?>/products/types/store" id="formCreateType">

    <div class="inline-create-pro">

        <div class="input-group-pro">
            <i data-lucide="search"></i>

            <input
                id="inputTypeName"
                type="text"
                name="nombre"
                placeholder="Escribir tipo de tela..."
                autocomplete="off"
                required>
        </div>

        <button type="submit" class="btn-primary btn-create">
            + Crear
        </button>

    </div>

</form>


<!-- 🔥 TABLA UNIFICADA -->
<div class="table-container">

    <table id="tablaFabricTypes" class="table-main display">

        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($types as $type): ?>
                <tr class="<?= !empty($type['deleted_at']) ? 'deleted' : '' ?>">

                    <th></th>

                    <td data-label="ID"><?= $type['id'] ?></td>

                    <td data-label="Código">
                        <?= htmlspecialchars($type['codigo']) ?>
                    </td>

                    <td data-label="Nombre">
                        <?= htmlspecialchars($type['nombre']) ?>
                    </td>

                    <!-- 🔥 ESTADO SIMPLIFICADO -->
                    <td data-label="Estado">
                        <?php if (!empty($type['deleted_at'])): ?>
                            <span class="badge deleted">Eliminado</span>
                        <?php else: ?>
                            <span class="badge active">Disponible</span>
                        <?php endif; ?>
                    </td>

                    <!-- 🔥 ACCIONES ESTÁNDAR -->
                    <td data-label="Acciones">
                        <div class="actions">

                            <!-- EDITAR -->
                            <?php if ($canEdit && empty($type['deleted_at'])): ?>
                                <a href="<?= BASE_URL ?>/products/types/edit/<?= $type['id'] ?>"
                                   class="btn-action edit">
                                    Editar
                                </a>
                            <?php endif; ?>

                            <!-- ELIMINAR -->
                            <?php if (empty($type['deleted_at']) && $canDelete): ?>
                                <button class="btn-action delete" data-id="<?= $type['id'] ?>">
                                    Eliminar
                                </button>
                            <?php endif; ?>

                            <!-- RESTAURAR -->
                            <?php if (!empty($type['deleted_at']) && $rol === 'super'): ?>
                                <button class="btn-action restore" data-id="<?= $type['id'] ?>">
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