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
            $_SESSION['error'] = "Usuario o contraseña incorrectos";

            header("Location: " . BASE_URL . "/login");
            exit;
        }
    }

    public function logout()
{
    // Destruir variables de sesión
    $_SESSION = [];

    // Destruir cookie de sesión (muy importante)
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Destruir sesión
    session_destroy();

    // Redirigir
    header("Location: " . BASE_URL . "/login");
    exit;
}


}
