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
    // public function login()
    // {
    //     global $db;

    //     // ✔️ Evitar login si ya está autenticado
    //     if (!empty($_SESSION['user'])) {
    //         $this->redirect(BASE_URL . "/dashboard");
    //     }

    //     $username = strtolower($_POST['user'] ?? '');
    //     $pass = $_POST['pass'] ?? '';

    //     // 🔎 Buscar usuario
    //     $stmt = $db->prepare("SELECT * FROM usuarios WHERE username = ? LIMIT 1");
    //     $stmt->bind_param("s", $username);
    //     $stmt->execute();

    //     $result = $stmt->get_result();
    //     $usuario = $result->fetch_assoc();

    //     // Usuario no existe
    //     if (!$usuario) {
    //         auditoria("LOGIN_FAIL", "usuarios", null, "Usuario no encontrado: $username");

    //         $_SESSION['error'] = "Usuario o contraseña incorrectos";
    //         header("Location: " . BASE_URL . "/login");
    //         exit;
    //     }

    //     // Password incorrecto
    //     if (!password_verify($pass, $usuario['password'])) {
    //         auditoria("LOGIN_FAIL", "usuarios", $usuario['id'], "Password incorrecto");

    //         $_SESSION['error'] = "Usuario o contraseña incorrectos";
    //         header("Location: " . BASE_URL . "/login");
    //         exit;
    //     }

    //     // Usuario inactivo
    //     if ($usuario['estado'] == 0) {
    //         auditoria("LOGIN_BLOCKED", "usuarios", $usuario['id'], "Usuario inactivo");

    //         $_SESSION['error'] = "Usuario inactivo";
    //         header("Location: " . BASE_URL . "/login");
    //         exit;
    //     }

    //     // LOGIN EXITOSO
    //     $_SESSION['user'] = [
    //         'id' => $usuario['id'],
    //         'username' => $usuario['username'],
    //         'rol' => $usuario['rol_id']
    //     ];

    //     auditoria("LOGIN", "usuarios", $usuario['id'], "Inicio de sesión exitoso");

    //     header("Location: " . BASE_URL . "/dashboard");
    //     exit;
    // }

    public function login()
    {
        // var_dump($_SERVER['REQUEST_METHOD']);
        // die("ENTRÓ AL LOGIN");

        global $db;

        if (!$db) {
            die("Error: no hay conexión a BD");
        }

        $username = strtolower($_POST['user'] ?? '');
        $pass = $_POST['pass'] ?? '';

        $stmt = $db->prepare("
            SELECT u.*, r.nombre AS rol_nombre 
            FROM usuarios u
            JOIN roles r ON u.rol_id = r.id
            WHERE u.username = ?
            LIMIT 1
        ");

        if (!$stmt) {
            die("Error en prepare: " . $db->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if (!$result) {
            die("Error en query");
        }

        $usuario = $result->fetch_assoc();

        if (!$usuario) {
            $_SESSION['error'] = "Usuario o contraseña incorrectos";
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        if (!password_verify($pass, $usuario['password'])) {
            $_SESSION['error'] = "Usuario o contraseña incorrectos";
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        if ($usuario['estado'] == 0) {
            $_SESSION['error'] = "Usuario inactivo";
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $_SESSION['user'] = [
            'id' => $usuario['id'],
            'username' => $usuario['username'],
            'nombre' => $usuario['nombre'],
            'apellido' => $usuario['apellido'],
            'rol' => $usuario['rol_id'],
            'rol_nombre' => $usuario['rol_nombre']
        ];

        // PRUEBA 
        // auditoria("TEST", "usuarios", 1, "PRUEBA DIRECTA", "auth");
        // die("se ejecutó auditoría");

        auditoria("LOGIN", "usuarios", $usuario['id'], "Inicio de sesión exitoso", "auth");

        header("Location: " . BASE_URL . "/dashboard");
        exit;
    }







    public function logout()
    {
        // AUDITORÍA
        if (!empty($_SESSION['user']) && isset($_SESSION['user']['id'])) {
            auditoria(
                "LOGOUT",
                "usuarios",
                $_SESSION['user']['id'],
                "Usuario cerró sesión manualmente",
                "auth"
            );
        }

        // limpiar sesión
        $_SESSION = [];

        // eliminar cookie
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

        // destruir sesión
        session_destroy();

        // redirigir
        header("Location: " . BASE_URL . "/login");
        exit;
    }
}
