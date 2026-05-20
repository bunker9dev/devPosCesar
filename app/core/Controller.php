<?php

namespace App\Core;

define('ROL_SUPER', 1);
define('ROL_ADMIN', 2);

class Controller
{


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

    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    protected function auth()
    {
        if (empty($_SESSION['user'])) {
            $this->redirect(BASE_URL . "/login");
        }
    }

    protected function isAdmin()
    {

        return in_array($_SESSION['user']['rol'] ?? null, [ROL_SUPER, ROL_ADMIN]);
    }

    protected function onlyAdmin()
    {
        if (!$this->isAdmin()) {
            $this->redirect(BASE_URL . "/dashboard");
        }
    }
}
