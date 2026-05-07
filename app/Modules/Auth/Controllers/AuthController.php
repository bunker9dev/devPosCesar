<?php

namespace App\Modules\Auth\Controllers;

use App\Core\Controller;

class AuthController extends Controller
{

    // Mostrar formulario de login
    public function index()
    {
        $this->render(
            'Modules/Auth/Views/login',
            [
                'title' => 'Login'
            ],
            'mainLogin'
        );
    }

    // Procesar login (cuando envían el form)
    public function login()
    {

        $user = $_POST['user'] ?? '';
        $pass = $_POST['pass'] ?? '';

        // aquí luego llamas tu AuthService
        if ($user === "admin" && $pass === "1234") {
            $_SESSION['user'] = $user; // 🔐 guardar sesión
            header("Location: " . BASE_URL . "/dashboard");
            exit;
        } else {
            $this->render(
                'Modules/Auth/Views/login',
                [
                    "title" => "Login",
                    "error" => "Usuario o contraseña incorrectos"
                ],
                "mainLogin"
            );

        }
    }
}
