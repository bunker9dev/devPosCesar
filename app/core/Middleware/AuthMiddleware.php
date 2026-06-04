<?php

namespace App\Core\Middleware;

use App\Core\Status;

class AuthMiddleware {

    public static function handle() {

        //  No logueado
        if (empty($_SESSION['user'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        // BLOQUEO POR ESTADO
        if (($_SESSION['user']['estado'] ?? null) !== Status::ACTIVO) {

            // destruir sesión
            $_SESSION = [];
            session_destroy();

            header("Location: " . BASE_URL . "/login");
            exit;
        }

    }
}