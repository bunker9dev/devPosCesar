<?php

class PermissionSeeder
{
    public static function run($db)
    {
        if (!$db) {
            die("❌ No hay conexión a BD");
        }

        echo "Seeder cargado\n";

        // ======================================================
        // 🔹 MÓDULOS
        // ======================================================
        $modules = [
            'users',
            'products',
            'warehouses',
            'roles',
            'proveedores'
        ];

        // ======================================================
        // 🔹 ACCIONES BASE (CRUD)
        // ======================================================
        $baseActions = ['view', 'create', 'edit', 'delete', 'restore'];

        // ======================================================
        // 🔥 ACCIONES AVANZADAS (FULL RBAC)
        // ======================================================
        $extraActions = [
            'users' => [
                'view_username',
                'view_email',
                'view_avatar',
                'view_deleted'
            ],
            'products' => [
                'view_cost'
            ],
            'warehouses' => [],
            'roles' => [],
            'proveedores' => []
        ];

        // ======================================================
        // 🔁 GENERAR PERMISOS
        // ======================================================
        foreach ($modules as $modulo) {

            // 🔹 CRUD
            foreach ($baseActions as $accion) {
                self::insertPermission($db, $modulo, $accion);
            }

            // 🔹 EXTRA
            if (!empty($extraActions[$modulo])) {
                foreach ($extraActions[$modulo] as $accion) {
                    self::insertPermission($db, $modulo, $accion);
                }
            }
        }

        echo "✅ Permisos generados correctamente\n";
    }

    // ======================================================
    // 🔧 INSERT PERMISSION (REUTILIZABLE)
    // ======================================================
    private static function insertPermission($db, $modulo, $accion)
    {
        $nombre = "$modulo.$accion";

        // evitar duplicados
        $stmt = $db->prepare("SELECT id FROM permissions WHERE nombre=?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) {
            return;
        }

        $stmt = $db->prepare("
            INSERT INTO permissions (nombre, modulo, accion)
            VALUES (?, ?, ?)
        ");

        $stmt->bind_param("sss", $nombre, $modulo, $accion);
        $stmt->execute();
    }
}