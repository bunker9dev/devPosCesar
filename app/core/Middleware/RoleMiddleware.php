<?php

namespace App\Core\Middleware;

class RoleMiddleware
{
    public static function handle($roles = [])
    {
        $user = $_SESSION['user'] ?? null;

        if (!$user) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        if (!in_array($user['rol_id'], $roles)) {
            http_response_code(403);
            echo "No autorizado";
            exit;
        }
    }
}