<nav class="nav">

    <!-- IZQUIERDA -->
    <div class="nav-left">
        <button id="toggleSidebar" class="btn-toggle">
            ☰
        </button>
    </div>

    <!-- DERECHA -->
    <div class="nav-right">

        <!-- PERFIL -->
        <div class="nav-user" id="nav-user">

            <div class="nav-user-trigger">
                <img src="<?= BASE_URL ?>/assets/img/users/<?= !empty($u['imagen']) ? $u['imagen'] : 'default.png' ?>" class="nav-avatar">

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