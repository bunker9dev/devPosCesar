<?php
namespace App\Core;

class Controller {

    protected function render($view, $data = [], $layout = 'main')
{
    $viewPath = __DIR__ . '/../' . $view . '.php';

    if (!file_exists($viewPath)) {
        die("Vista no encontrada: " . $view);
    }

    extract($data);

    $content = $viewPath;

    require __DIR__ . "/../Views/layouts/{$layout}.php";
}

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
}