<?php

namespace App\Modules\Auth\Controllers;

use App\Core\Controller;

class AuthController extends Controller
{

    // Mostrar formulario de login
    public function index()
    {
           // Si ya está logueado → redirigir
        if (!empty($_SESSION['user'])) {
            $this->redirect(BASE_URL . "/dashboard");
        }

        $this->render(
            'Modules/Auth/Views/login',
            [
                'title' => 'Login'
            ],
            'mainLogin'
        );
    }

    // 🔐 PROCESAR LOGIN REAL + AUDITORÍA
    public function login()
    {
        global $db;

         // ✔️ Evitar login si ya está autenticado
        if (!empty($_SESSION['user'])) {
            $this->redirect(BASE_URL . "/dashboard");
        }

        $username = strtolower($_POST['user'] ?? '');
        $pass = $_POST['pass'] ?? '';

        // 🔎 Buscar usuario
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();

        // Usuario no existe
        if (!$usuario) {
            auditoria("LOGIN_FAIL", "usuarios", null, "Usuario no encontrado: $username");

            $_SESSION['error'] = "Usuario o contraseña incorrectos";
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        // Password incorrecto
        if (!password_verify($pass, $usuario['password'])) {
            auditoria("LOGIN_FAIL", "usuarios", $usuario['id'], "Password incorrecto");

            $_SESSION['error'] = "Usuario o contraseña incorrectos";
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        // Usuario inactivo
        if ($usuario['estado'] == 0) {
            auditoria("LOGIN_BLOCKED", "usuarios", $usuario['id'], "Usuario inactivo");

            $_SESSION['error'] = "Usuario inactivo";
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        // LOGIN EXITOSO
        $_SESSION['user'] = [
            'id' => $usuario['id'],
            'username' => $usuario['username'],
            'rol' => $usuario['rol_id']
        ];

        auditoria("LOGIN", "usuarios", $usuario['id'], "Inicio de sesión exitoso");

        header("Location: " . BASE_URL . "/dashboard");
        exit;
    }

    // LOGOUT CON AUDITORÍA
    public function logout()
    {
        if (!empty($_SESSION['user'])) {
            auditoria("LOGOUT", "usuarios", $_SESSION['user']['id'], "Cierre de sesión");
        }

        // Limpiar sesión
        $_SESSION = [];

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

        session_destroy();

        header("Location: " . BASE_URL . "/login");
        exit;
    }
}