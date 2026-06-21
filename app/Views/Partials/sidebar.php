<?php

use App\Services\PermissionService;

$rolId = $_SESSION['user']['rol_id'] ?? null;

// ============================
// PERMISOS POR ENLACE
// ============================
$canViewUsers      = PermissionService::can($rolId, 'users', 'view');
$canViewProveedores = PermissionService::can($rolId, 'proveedores', 'view');
$canViewRolls       = PermissionService::can($rolId, 'rolls', 'view');
$canViewWarehouses  = PermissionService::can($rolId, 'warehouses', 'view');
$canViewFabricTypes = PermissionService::can($rolId, 'fabric_types', 'view');
$canViewFabricColors = PermissionService::can($rolId, 'fabric_colors', 'view');
$canViewRollsIndividual = PermissionService::can($rolId, 'rolls', 'view_individual');
$canViewPurchases = PermissionService::can($rolId, 'purchases', 'view');
$canViewPedidos = PermissionService::can($rolId, 'pedidos', 'view');
$pedidosVencidos = 0;

if ($canViewPedidos) {
    $db = \App\Core\Database::getConnection();
    $result = $db->query("
        SELECT COUNT(*) AS total FROM pedidos
        WHERE estado = 'aprobado' AND deleted_at IS NULL AND DATEDIFF(NOW(), approved_at) >= 7
    ");
    $pedidosVencidos = (int)$result->fetch_assoc()['total'];
}


// Los grupos solo se muestran si AL MENOS uno de sus enlaces internos es visible
$showOperacion = $canViewRolls; // (Productos/Kardex/Compras ocultos hasta que existan)
$showConfiguracion = $canViewWarehouses || $canViewFabricTypes || $canViewFabricColors;

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

        <!-- DASHBOARD (siempre visible, no requiere permiso) -->
        <li>
            <a href="<?= BASE_URL ?>/dashboard">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- USERS -->
        <?php if ($canViewUsers): ?>
            <li>
                <a href="<?= BASE_URL ?>/users">
                    <i data-lucide="users"></i>
                    <span>Usuarios</span>
                </a>
            </li>
        <?php endif; ?>

        <!-- PROVEEDORES -->
        <?php if ($canViewProveedores): ?>
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
        <?php if ($showOperacion): ?>
            <li class="sidebar-group" data-menu="operations">
                <button type="button" class="sidebar-group-toggle">
                    <i data-lucide="boxes"></i>
                    <span>Operación</span>
                    <i data-lucide="chevron-down" class="sidebar-chevron"></i>
                </button>

                <ul class="sidebar-submenu">

<?php if ($canViewPedidos): ?>
                        <li>
                            <a href="<?= BASE_URL ?>/pedidos">
                                <i data-lucide="clipboard-list"></i>
                                <span>Pedidos</span>
                                <?php if ($pedidosVencidos > 0): ?>
                                    <span class="badge-counter"><?= $pedidosVencidos ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($canViewPurchases): ?>
                        <li>
                            <a href="<?= BASE_URL ?>/purchases">
                                <i data-lucide="shopping-cart"></i>
                                <span>Compras</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($canViewRolls): ?>
                        <li>
                            <a href="<?= BASE_URL ?>/rolls">
                                <i data-lucide="scan-barcode"></i>
                                <span>Rollos</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (\App\Services\PermissionService::can($rolId, 'rolls', 'view_individual')): ?>
                        <li>
                            <a href="<?= BASE_URL ?>/rolls/individual">
                                <i data-lucide="list"></i>
                                <span>Rollos individuales</span>
                            </a>
                        </li>
                    <?php endif; ?>


                    
                    <!--
                    Productos / Kardex / Compras ocultos a propósito:
                    sus rutas (/products, /movements, /purchases) todavía
                    no existen. Cuando se construyan esos módulos, agregar
                    aquí su propio "if ($canViewX): ... endif;" siguiendo
                    el mismo patrón.
                -->

                </ul>
            </li>
        <?php endif; ?>


        <!-- ========================= -->
        <!-- ⚙️ CONFIGURACIÓN -->
        <!-- ========================= -->
        <?php if ($showConfiguracion): ?>
            <li class="sidebar-group" data-menu="config">
                <button type="button" class="sidebar-group-toggle">
                    <i data-lucide="settings"></i>
                    <span>Configuración</span>
                    <i data-lucide="chevron-down" class="sidebar-chevron"></i>
                </button>

                <ul class="sidebar-submenu">

                    <?php if ($canViewWarehouses): ?>
                        <li>
                            <a href="<?= BASE_URL ?>/warehouses">
                                <i data-lucide="warehouse"></i>
                                <span>Bodegas</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($canViewFabricTypes): ?>
                        <li>
                            <a href="<?= BASE_URL ?>/fabric-types">
                                <i data-lucide="layers"></i>
                                <span>Tipos de tela</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($canViewFabricColors): ?>
                        <li>
                            <a href="<?= BASE_URL ?>/fabric-colors">
                                <i data-lucide="palette"></i>
                                <span>Colores</span>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </li>
        <?php endif; ?>

    </ul>
</aside>

<div id="sidebarOverlay" class="sidebar-overlay"></div>