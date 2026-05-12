<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);


session_start();

// BASE URL
define('BASE_URL', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST']);

// CONEXIÓN BD
require __DIR__ . '/../app/Config/database.php';
$db = conectarDB();

// AUTOLOAD 
require __DIR__ . '/../vendor/autoload.php';

// HELPERS
require_once __DIR__ . '/../app/Helpers/auditoria.php';

use App\Core\Router;

// ROUTER
$router = new Router();

// RUTAS
require __DIR__ . '/../app/Routes/web.php';

// EJECUTAR
$router->dispatch();