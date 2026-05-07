<?php

require_once __DIR__ . '/../../../core/Controller.php';

class AuthController extends Controller
{

    // Mostrar formulario de login
    public function index()
    {
        $this->view(
            __DIR__ . '/../Views/login.php',
            ["title" => "Login"],
            "auth" // 👈 usa layout de login (sin sidebar)
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
            $this->view(
                __DIR__ . '/../Views/login.php',
                [
                    "title" => "Login",
                    "error" => "Usuario o contraseña incorrectos"
                ],
                "auth"
            );
        }
    }
}
