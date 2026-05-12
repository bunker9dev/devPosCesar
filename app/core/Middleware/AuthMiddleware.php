<?php

namespace App\Core\Middleware;

class AuthMiddleware {

    public static function handle() {

        if (empty($_SESSION['user'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

    }
}