<?php

class RolePermissionSeeder
{
    public static function run($db)
    {
        if (!$db) {
            die("❌ No hay conexión a BD");
        }

        echo "Asignando permisos a roles...\n";

        // 🔄 limpiar
        $db->query("DELETE FROM role_permissions");

        // 📦 cargar permisos
        $permissions = [];

        $result = $db->query("SELECT id, nombre FROM permissions");

        while ($row = $result->fetch_assoc()) {
            $permissions[$row['nombre']] = $row['id'];
        }

        // ======================================================
        //  DEFINICIÓN POR ROL (FULL RBAC)
        // ======================================================
        $roles = [

            // SUPER → TODO
            1 => array_keys($permissions),

            // 🧑‍💼 ADMIN
            2 => [
                'users.view',
                'users.create',
                'users.edit',
                'users.delete',
                'users.view_username',

                'products.view',
                'products.create',
                'products.edit',
                'products.delete',
                

                'warehouses.view',
                'roles.view',
                'proveedores.view',
            ],

            // 🧾 SECRETARIA
            3 => [
                'users.view',
                'users.view_username',

                'products.view',
                'proveedores.view'
            ],

            // 📦 BODEGUERO
            4 => [
                'products.view',
                'products.create',
                'products.edit',

                'warehouses.view',
                'warehouses.edit'
            ],

            // 💰 VENDEDOR
            5 => [
                'products.view',
                'proveedores.view'
            ],

            // 👤 ASISTENTE
            6 => [
                'users.view',
                'products.view',
                'warehouses.view',
                'proveedores.view'
            ],
        ];

        // ======================================================
        // 🔁 ASIGNACIÓN
        // ======================================================
        foreach ($roles as $roleId => $perms) {

            foreach ($perms as $permName) {

                if (!isset($permissions[$permName])) {
                    continue;
                }

                self::assign($db, $roleId, $permissions[$permName]);
            }
        }

        echo "✅ Roles y permisos asignados correctamente\n";
    }

    private static function assign($db, $roleId, $permissionId)
    {
        $stmt = $db->prepare("
            INSERT INTO role_permissions (role_id, permission_id)
            VALUES (?, ?)
        ");

        $stmt->bind_param("ii", $roleId, $permissionId);
        $stmt->execute();
    }
}