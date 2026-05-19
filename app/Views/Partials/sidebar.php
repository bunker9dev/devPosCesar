<aside class="sidebar">
    <div class="sidebar-nav">
        <div class="nav-user" id="nav-user">

            <div class="nav-user-trigger">
                <img src="<?= BASE_URL ?>/assets/img/users/<?= !empty($u['imagen']) ? $u['imagen'] : 'default.png' ?>" class="nav-avatar">

                <span class="nav-username">
                    <?= $_SESSION['user']['nombre'] . " " . $_SESSION['user']['apellido'] ?>
                    <p><small>(<?= $_SESSION['user']['rol_nombre'] ?>)</small></p>
                </span>
            </div>

        </div>
    </div>


    <ul>
        <li>
            <a href="<?= BASE_URL ?>/dashboard" data-tooltip="Dashboard">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/users" data-tooltip="Usuarios"> 
                <i data-lucide="users"></i>
                <span>Usuarios</span>
            </a>
        </li>
        <li>
            <a href="<?= BASE_URL ?>/proveedores" data-tooltip="Proveedores">
                <i data-lucide="truck"></i>
                <span>Proveedores</span>
            </a>
        </li>

        <li>
            <a href="<?= BASE_URL ?>/productos" data-tooltip="Productos">
                <i data-lucide="box"></i>
                <span>Productos</span>
            </a>
        </li>

    </ul>
</aside>
<div id="sidebarOverlay" class="sidebar-overlay"></div>