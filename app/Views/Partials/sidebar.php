<?php

use App\Core\Roles;

$rolId = $_SESSION['user']['rol_id'] ?? null;

?>

<aside class="sidebar">
    <div class="sidebar-nav">
        <div class="nav-user">
            <div class="nav-user-sidebar">
                <img
                    src="<?= avatar_url($_SESSION['user']['imagen'] ?? null) ?>"
                    class="nav-avatar"
                    onerror="this.src='<?= BASE_URL ?>/assets/img/users/default.png'">

                <span class="nav-username">
                    <?= $_SESSION['user']['nombre'] . " " . $_SESSION['user']['apellido'] ?>
                    <p><small>(<?= $_SESSION['user']['rol_nombre'] ?>)</small></p>
                </span>
            </div>
        </div>
    </div>

    <ul>

        <!-- DASHBOARD -->
        <li>
            <a href="<?= BASE_URL ?>/dashboard">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- USERS -->
        <?php if (in_array($rolId, [Roles::SUPER, Roles::ADMIN, Roles::SECRETARIA])): ?>
        <li>
            <a href="<?= BASE_URL ?>/users">
                <i data-lucide="users"></i>
                <span>Usuarios</span>
            </a>
        </li>
        <?php endif; ?>

        <!-- PROVEEDORES -->
        <?php if (in_array($rolId, [Roles::SUPER, Roles::ADMIN, Roles::SECRETARIA])): ?>
        <li>
            <a href="<?= BASE_URL ?>/suppliers">
                <i data-lucide="truck"></i>
                <span>Proveedores</span>
            </a>
        </li>
        <?php endif; ?>


        <!-- ========================= -->
        <!-- 📦 OPERACIÓN -->
        <!-- ========================= -->
        <?php if (in_array($rolId, [
            Roles::SUPER,
            Roles::ADMIN,
            Roles::BODEGUERO,
            Roles::VENDEDOR
        ])): ?>
        <li class="sidebar-group" data-menu="operations">
            <button type="button" class="sidebar-group-toggle">
                <i data-lucide="boxes"></i>
                <span>Operación</span>
                <i data-lucide="chevron-down" class="sidebar-chevron"></i>
            </button>

            <ul class="sidebar-submenu">

                <li>
                    <a href="<?= BASE_URL ?>/products">
                        <i data-lucide="box"></i>
                        <span>Productos</span>
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>/rolls">
                        <i data-lucide="scan-barcode"></i>
                        <span>Rollos</span>
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>/movements">
                        <i data-lucide="arrow-left-right"></i>
                        <span>Kardex</span>
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>/purchases">
                        <i data-lucide="shopping-cart"></i>
                        <span>Compras</span>
                    </a>
                </li>

            </ul>
        </li>
        <?php endif; ?>


        <!-- ========================= -->
        <!-- ⚙️ CONFIGURACIÓN -->
        <!-- ========================= -->
        <?php if (in_array($rolId, [Roles::SUPER, Roles::ADMIN])): ?>
        <li class="sidebar-group" data-menu="config">
            <button type="button" class="sidebar-group-toggle">
                <i data-lucide="settings"></i>
                <span>Configuración</span>
                <i data-lucide="chevron-down" class="sidebar-chevron"></i>
            </button>

            <ul class="sidebar-submenu">

                <li>
                    <a href="<?= BASE_URL ?>/warehouses">
                        <i data-lucide="warehouse"></i>
                        <span>Bodegas</span>
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>/fabric-types">
                        <i data-lucide="layers"></i>
                        <span>Tipos de tela</span>
                    </a>
                </li>

                <li>
                    <a href="<?= BASE_URL ?>/fabric-colors">
                        <i data-lucide="palette"></i>
                        <span>Colores</span>
                    </a>
                </li>

            </ul>
        </li>
        <?php endif; ?>

    </ul>
</aside>

<div id="sidebarOverlay" class="sidebar-overlay"></div>