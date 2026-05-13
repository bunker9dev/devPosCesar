<nav class="nav">

    <!-- IZQUIERDA -->
    <div class="nav-left">
        <button class="nav-toggle" id="nav-toggle">
            ☰
        </button>
    </div>

    <!-- DERECHA -->
    <div class="nav-right">

        <!-- PERFIL -->
        <div class="nav-user" id="nav-user">

            <div class="nav-user-trigger">
                <?php if (!empty($_SESSION["foto"])): ?>
                    <img src="<?= $_SESSION["foto"] ?>" class="nav-avatar">
                <?php else: ?>
                    <img src="<?= BASE_URL ?>/assets/img/usuarios/default/anonymous.png" class="nav-avatar">
                <?php endif; ?>

                <span class="nav-username">
                    <?= $_SESSION['user']['nombre'] . " " . $_SESSION['user']['apellido'] ?>
                    <p><small>(<?= $_SESSION['user']['rol_nombre'] ?>)</small></p>
                </span>
            </div>

            <!-- DROPDOWN -->
            <div class="nav-dropdown" id="nav-dropdown">
                <a href="<?= BASE_URL ?>/logout" class="nav-logout">Salir</a>
            </div>

        </div>

    </div>

</nav>