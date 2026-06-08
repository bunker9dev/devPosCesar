<?php

require_once __DIR__ . '/../app/Config/database.php';
require_once __DIR__ . '/../database/seeders/RolePermissionSeeder.php';

$db = conectarDB();

RolePermissionSeeder::run($db);

// para ejecutar desde el terminal 

// php scripts/seed_role_permissions.php
 