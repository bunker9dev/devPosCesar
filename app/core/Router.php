<?php

namespace App\Core;

class Router
{

    private $routes = [];

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function dispatch()
    {

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // quitar base del proyecto
        $uri = str_replace('/DEVPOSCESAR_D/public', '', $uri);

        // limpiar slash final
        $uri = rtrim($uri, '/') ?: '/';

        $method = $_SERVER['REQUEST_METHOD'];

        if (!isset($this->routes[$method][$uri])) {
            die("Ruta no encontrada");
        }

        $action = $this->routes[$method][$uri];

        list($controller, $method) = explode('@', $action);

        // 🔥 ESTA LÍNEA ES CLAVE
        $controller = "App\\Modules\\" . $controller;

        $controllerInstance = new $controller();

        $controllerInstance->$method();
    }
}
