<?php


namespace App\Core;

class Router
{
    private $routes = [];

    // Registrar ruta GET
    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    // Registrar ruta POST
    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    // Ejecutar router
    public function dispatch()
    {

    
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // 🔥 quitar BASE_URL correctamente
        $uri = str_replace(BASE_URL, '', $uri);

        // 🔧 Normalizar URI
        $uri = rtrim($uri, '/') ?: '/';

        $httpMethod = $_SERVER['REQUEST_METHOD'];

        // 🔴 404 - Ruta no encontrada
        if (!isset($this->routes[$httpMethod][$uri])) {
            return $this->renderError(404);
        }

        $action = $this->routes[$httpMethod][$uri];

        // 🔴 Validar formato Controller@method
        if (!str_contains($action, '@')) {
            return $this->renderError(500, "Formato de ruta inválido");
        }

        list($controller, $method) = explode('@', $action);

        // 🔥 Namespace automático
        $controller = "App\\Modules\\" . $controller;

        // 🔴 Validar controlador
        if (!class_exists($controller)) {
            return $this->renderError(500, "Controlador no encontrado: {$controller}");
        }

        $controllerInstance = new $controller();

        // 🔴 Validar método
        if (!method_exists($controllerInstance, $method)) {
            return $this->renderError(500, "Método no encontrado: {$method}");
        }

        // 🚀 Ejecutar acción
        try {
            $controllerInstance->$method();
        } catch (\Throwable $e) {
            return $this->renderError(500, $e->getMessage());
        }
    }

    // 🔥 Renderizar errores
    private function renderError($code = 404)
{
    http_response_code($code);

    $view = __DIR__ . "/../Views/errors/{$code}.php";

    // 🔴 Si NO existe la vista
    if (!file_exists($view)) {
        echo "<h1>Error {$code}</h1>";
        exit;
    }

    // 🔥 Capturar contenido
    ob_start();
    require $view;
    $content = ob_get_clean();

    // 🔥 Cargar layout
    $layout = __DIR__ . '/../Views/layouts/error.php';

    if (file_exists($layout)) {
        require $layout;
    } else {
        echo $content;
    }

    exit;
}
}
