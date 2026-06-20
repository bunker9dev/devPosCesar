<?php


namespace App\Core;

class Router
{
    private $routes = [];

    // Registrar ruta GET
    public function get($uri, $action, $middlewares = [])
    {
        $this->routes['GET'][$uri] = [
            'action' => $action,
            'middlewares' => $middlewares
        ];
    }

    // Registrar ruta POST
    public function post($uri, $action, $middlewares = [])
    {
        $this->routes['POST'][$uri] = [
            'action' => $action,
            'middlewares' => $middlewares
        ];
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

        $route = $this->routes[$httpMethod][$uri];

        $action = $route['action'];
        $middlewares = $route['middlewares'] ?? [];

        // MIDDLEWARES
        
        foreach ($middlewares as $mw) {

            if ($mw === 'auth') {
                \App\Core\Middleware\AuthMiddleware::handle();
                continue;
            }

            //
            \App\Core\Middleware\PermissionMiddleware::handle($mw);
        }

        // 🔴 Validar formato Controller@method
        if (!str_contains($action, '@')) {
            return $this->renderError(500, "Formato de ruta inválido");
        }

        list($controller, $method) = explode('@', $action);

        // Namespace automático
        $controller = "App\\Modules\\" . $controller;

        // Validar controlador
        if (!class_exists($controller)) {
            return $this->renderError(500, "Controlador no encontrado: {$controller}");
        }

        $controllerInstance = new $controller();

        // Validar método
        if (!method_exists($controllerInstance, $method)) {
            return $this->renderError(500, "Método no encontrado: {$method}");
        }

        // Ejecutar acción
        try {
            $controllerInstance->$method();
        } catch (\Throwable $e) {
            return $this->renderError(500, $e->getMessage());
        }
    }
    // Renderizar errores
    private function renderError($code = 404, $message = null)
    {
        http_response_code($code);

        // 🔥 DEBUG (MOSTRAR ERROR REAL)
        if ($message) {
            echo "<h2>Error {$code}</h2>";
            echo "<pre>{$message}</pre>";
            exit;
        }

        $view = __DIR__ . "/../Views/errors/{$code}.php";

        if (!file_exists($view)) {
            echo "<h1>Error {$code}</h1>";
            exit;
        }

        ob_start();
        require $view;
        $content = ob_get_clean();

        $layout = __DIR__ . '/../Views/layouts/error.php';

        if (file_exists($layout)) {
            require $layout;
        } else {
            echo $content;
        }

        exit;
    }
}
