<div class="form-group">
    <label>Rol</label>

    <?php if ($canEdit): ?>

        <select name="rol_id">

            <?php foreach ($roles as $r): ?>

                <?php
                if ($r['id'] == \App\Core\Roles::SUPER && $rolId !== \App\Core\Roles::SUPER) continue;
                ?>

                <option value="<?= $r['id'] ?>">
                    <?= htmlspecialchars(ucfirst($r['nombre'])) ?>
                </option>

            <?php endforeach; ?>

        </select>

    <?php else: ?>

        <input type="text" value="<?= htmlspecialchars($_SESSION['user']['rol_nombre']) ?>" disabled>
        <input type="hidden" name="rol_id" value="<?= $rolId ?>">

    <?php endif; ?>

</div>