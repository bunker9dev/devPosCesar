<?php

namespace App\Core\Middleware;

use App\Core\Roles;

class PermissionMiddleware
{
    // public static function handle($permission)
    // {
    //     $rolId = $_SESSION['user']['rol_id'] ?? null;


    //     switch ($permission) {

    //         case 'admin':
    //             if (!in_array($rolId, [Roles::SUPER, Roles::ADMIN])) {
    //                 self::deny();
    //             }
    //             break;

    //         case 'super':
    //             if ($rolId !== Roles::SUPER) {
    //                 self::deny();
    //             }
    //             break;

    //         case 'view':
    //             if (!in_array($rolId, [
    //                 Roles::SUPER,
    //                 Roles::ADMIN,
    //                 Roles::SECRETARIA
    //             ])) {
    //                 self::deny();
    //             }
    //             break;

    //         case 'edit':
    //             if (!Roles::canEdit($rolId)) {
    //                 self::deny();
    //             }
    //             break;

    //         case 'delete':
    //             if (!Roles::canDelete($rolId)) {
    //                 self::deny();
    //             }
    //             break;

    //         case 'restore':
    //             if (!Roles::canRestore($rolId)) {
    //                 self::deny();
    //             }
    //             break;
    //     }
    // }

    public static function handle($permission)
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        [$module, $action] = explode('.', $permission);

        if (!\App\Services\PermissionService::can($rolId, $module, $action)) {
            self::deny();
        }
    }

    private static function deny()
    {
        header("Location: " . BASE_URL . "/dashboard");
        exit;
    }
}
