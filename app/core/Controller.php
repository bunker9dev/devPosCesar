<?php
namespace App\Core;

class Controller {

    protected function render($view, $data = []) {

        // Validar que la vista exista
        $viewPath = __DIR__ . '/../' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("Vista no encontrada: " . $view);
        }

        // Convertir array a variables
        extract($data);

        // Pasar ruta de contenido al layout
        $content = $viewPath;

        // Cargar layout principal
        require __DIR__ . '/../Views/layouts/main.php';
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
}