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

        // var_dump($uri, $httpMethod);
        // die;

        // 🔴 Validar existencia de ruta
        if (!isset($this->routes[$httpMethod][$uri])) {
            http_response_code(404);
            die("Ruta no encontrada: {$uri}");
        }

        $action = $this->routes[$httpMethod][$uri];

        // 🔴 Validar formato Controller@method
        if (!str_contains($action, '@')) {
            die("Formato de ruta inválido. Usa Controller@method");
        }

        list($controller, $method) = explode('@', $action);

        // 🔥 Namespace modular automático
        $controller = "App\\Modules\\" . $controller;

        // 🔴 Validar que el controller exista
        if (!class_exists($controller)) {
            die("Controlador no encontrado: {$controller}");
        }

        $controllerInstance = new $controller();

        // 🔴 Validar que el método exista
        if (!method_exists($controllerInstance, $method)) {
            die("Método no encontrado: {$method}");
        }

        // 🚀 Ejecutar acción
        $controllerInstance->$method();
    }
}
