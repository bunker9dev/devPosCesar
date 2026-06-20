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



    public function login()
    {
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

        //VALIDAR HORARIO DE TRABAJO
        if (!\App\Services\ScheduleService::isAllowedNow($usuario['id'], $usuario['rol_id'])) {
            $_SESSION['error'] = "Acceso fuera del horario permitido para tu rol o usuario";
            header("Location: " . BASE_URL . "/login");
            exit;
        }
        
        if ($usuario['estado'] != 1) {
            $_SESSION['error'] = "Usuario inactivo";
            header("Location: " . BASE_URL . "/login");
            exit;
        }
        // =============================
        // LOGIN EXITOSO
        // =============================

        $_SESSION['user'] = [
            'id' => $usuario['id'],
            'username' => $usuario['username'],
            'nombre' => $usuario['nombre'],
            'apellido' => $usuario['apellido'],
            'rol_id' => $usuario['rol_id'],
            'rol_nombre' => $usuario['rol_nombre'],
            'estado' => $usuario['estado']
        ];

        // ACTUALIZAR ÚLTIMO LOGIN
        $stmt = $db->prepare("
            UPDATE usuarios 
            SET ultimo_login = NOW() 
            WHERE id = ?
        ");

        if ($stmt) {
            $stmt->bind_param("i", $usuario['id']);
            $stmt->execute();
        }

        // AUDITORIA

        (new \App\Core\Repositories\AuditLogRepository($db))->log([
            'usuario_id' => $usuario['id'],
            'accion'     => 'login',
            'entidad'    => 'usuarios',
            'entidad_id' => $usuario['id'],
            'modulo'     => 'auth',
            'detalle'    => ['mensaje' => 'Inicio de sesión exitoso'],
        ]);

        header("Location: " . BASE_URL . "/dashboard");
        exit;
    }







    public function logout()
    {
        global $db;
        // AUDITORÍA
        if (!empty($_SESSION['user']) && isset($_SESSION['user']['id'])) {
            (new \App\Core\Repositories\AuditLogRepository($db))->log([
                'usuario_id' => $_SESSION['user']['id'],
                'accion'     => 'logout',
                'entidad'    => 'usuarios',
                'entidad_id' => $_SESSION['user']['id'],
                'modulo'     => 'auth',
                'detalle'    => ['mensaje' => 'Usuario cerró sesión manualmente'],
            ]);
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
