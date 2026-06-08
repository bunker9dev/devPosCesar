<?php

namespace App\Services;

class PermissionService
{
    // ======================================================
    // VALIDAR PERMISO
    // ======================================================
    public static function can(?int $roleId, string $modulo, string $accion): bool
    {
        global $db;

        if (!$roleId) return false;

        // 🔥 SUPER ACCESO TOTAL
        if ($roleId === 1) {
            return true;
        }

        $stmt = $db->prepare("
            SELECT 1
            FROM role_permissions rp
            JOIN permissions p ON rp.permission_id = p.id
            WHERE rp.role_id = ?
              AND p.modulo = ?
              AND p.accion = ?
            LIMIT 1
        ");

        $stmt->bind_param("iss", $roleId, $modulo, $accion);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    // ======================================================
    // PERMISOS POR MÓDULO
    // ======================================================
    public static function getModulePermissions(?int $roleId, string $modulo): array
    {
        global $db;

        $default = [
            'view' => false,
            'create' => false,
            'edit' => false,
            'delete' => false,
            'restore' => false
        ];

        if (!$roleId) return $default;

        //  SUPER = TODO
        if ($roleId === 1) {
            return [
                'view' => true,
                'create' => true,
                'edit' => true,
                'delete' => true,
                'restore' => true
            ];
        }

        $stmt = $db->prepare("
            SELECT p.accion
            FROM role_permissions rp
            JOIN permissions p ON rp.permission_id = p.id
            WHERE rp.role_id = ?
              AND p.modulo = ?
        ");

        $stmt->bind_param("is", $roleId, $modulo);
        $stmt->execute();

        $result = $stmt->get_result();

        $permissions = $default;

        while ($row = $result->fetch_assoc()) {
            $permissions[$row['accion']] = true;
        }

        return $permissions;
    }
}
