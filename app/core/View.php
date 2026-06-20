<?php

namespace App\Core;

/**
 * View
 * Encapsula el renderizado de vista + layout. Replica exactamente
 * el comportamiento que hoy vive inline en Controller::render(),
 * para poder usarse sin romper nada de lo existente.
 */
class View
{
    /**
     * Renderiza una vista dentro de un layout.
     *
     * @param string $view   Ruta relativa (ej: 'Modules/Users/Views/index')
     * @param array  $data   Variables disponibles en la vista
     * @param string $layout Nombre del layout en app/Views/layouts (sin extensión)
     */
    public static function render(string $view, array $data = [], string $layout = 'main'): void
    {
        $viewPath = __DIR__ . '/../' . $view . '.php';

        if (!file_exists($viewPath)) {
            http_response_code(500);
            die("Vista no encontrada: {$view}");
        }

        $layoutPath = __DIR__ . "/../Views/layouts/{$layout}.php";

        if (!file_exists($layoutPath)) {
            http_response_code(500);
            die("Layout no encontrado: {$layout}");
        }

        extract($data);

        $content = $viewPath;

        require $layoutPath;
    }

    /**
     * Renderiza una vista SIN layout (ej: fragmentos AJAX, partials sueltos).
     */
    public static function renderPartial(string $view, array $data = []): void
    {
        $viewPath = __DIR__ . '/../' . $view . '.php';

        if (!file_exists($viewPath)) {
            http_response_code(500);
            die("Vista no encontrada: {$view}");
        }

        extract($data);

        require $viewPath;
    }
}