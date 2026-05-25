<aside class="sidebar">
    <div class="sidebar-nav">
        <div class="nav-user" id="nav-user">
            <div class="nav-user-sidebar">
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
            <a href="<?= BASE_URL ?>/suppliers" data-tooltip="Proveedores">
                <i data-lucide="truck"></i>
                <span>Proveedores</span>
            </a>
        </li>

        <li class="sidebar-group" data-menu="products">
            <button type="button" class="sidebar-group-toggle" data-tooltip="Productos" aria-expanded="false">
                <i data-lucide="boxes"></i>
                <span>Productos</span>
                <i data-lucide="chevron-down" class="sidebar-chevron"></i>
            </button>

            <ul class="sidebar-submenu">
                <li>
                    <a href="<?= BASE_URL ?>/rolls" data-tooltip="Rollos">
                        <i data-lucide="scan-barcode"></i>
                        <span>Rollos</span>
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>/products" data-tooltip="Productos">
                        <i data-lucide="box"></i>
                        <span>Productos</span>
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>/movements" data-tooltip="Kardex">
                        <i data-lucide="arrow-left-right"></i>
                        <span>Kardex</span>
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>/purchases" data-tooltip="Compras">
                        <i data-lucide="shopping-cart"></i>
                        <span>Compras</span>
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>/products/types" data-tooltip="Tipos">
                        <i data-lucide="layers"></i>
                        <span>Tipos de tela</span>
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>/products/colors" data-tooltip="Colores">
                        <i data-lucide="palette"></i>
                        <span>Colores</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
<div id="sidebarOverlay" class="sidebar-overlay"></div>
