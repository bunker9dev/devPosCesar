<?php
define('BASE_URL', '/devposcesar_d/public');
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

// 🔥 1. Crear instancia del router
$router = new Router();

// 🔥 2. Cargar rutas (ahora sí existe $router)
require __DIR__ . '/../app/Routes/web.php';

// 🔥 3. Ejecutar rutas
$router->dispatch();