<?php

require_once __DIR__ . '/../app/Config/database.php';
require_once __DIR__ . '/../database/seeders/PermissionSeeder.php';

// 🔌 AQUÍ ESTÁ LA CLAVE
$db = conectarDB();

if (!$db instanceof mysqli) {
    die("❌ Error al obtener conexión");
}

echo "✅ Conexión OK\n";

// 🚀 Ejecutar seeder
PermissionSeeder::run($db);



// para ejecutar desde el terminal 

// php scripts/seed_permissions.php 