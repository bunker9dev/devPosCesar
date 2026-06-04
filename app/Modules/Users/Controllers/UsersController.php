<?php

namespace App\Modules\Users\Controllers;

use App\Core\Controller;
use App\Core\Roles;
use App\Core\Status;

class UsersController extends Controller
{
    public function index()
    {
        global $db;

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        $query = "
            SELECT u.*, r.nombre as rol 
            FROM usuarios u
            JOIN roles r ON u.rol_id = r.id
        ";

        // 🔒 no ver eliminados si no es super
        if ($rolId !== Roles::SUPER) {
            $query .= " WHERE u.estado IN (" . Status::ACTIVO . "," . Status::INACTIVO . ")";
        }

        $result = $db->query($query);
        $users = $result->fetch_all(MYSQLI_ASSOC);

        $this->render('Modules/Users/Views/index', compact('users'));
    }

    // ======================================================
    // CREATE
    // ======================================================
    public function create()
    {
        global $db;

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        // 🔒 filtrar roles
        if ($rolId === Roles::SUPER) {
            $roles = $db->query("SELECT * FROM roles")->fetch_all(MYSQLI_ASSOC);
        } else {
            $stmt = $db->prepare("SELECT * FROM roles WHERE id != ?");
            $stmt->bind_param("i", Roles::SUPER);
            $stmt->execute();
            $roles = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        $this->render('Modules/Users/Views/create', compact('roles'));
    }

    // ======================================================
    // STORE
    // ======================================================
    public function store()
    {
        global $db;

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        $username = trim($_POST['username'] ?? '');
        $nombre   = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $password = $_POST['password'] ?? '';
        $rol      = $_POST['rol_id'] ?? null;

        // 🔒 validación básica
        if (!$username || !$nombre || !$password || !$rol) {
            $_SESSION['error'] = "Datos incompletos";
            return $this->redirect(BASE_URL . "/users/create");
        }

        // 🔒 evitar crear SUPER
        if ($rol == Roles::SUPER && $rolId !== Roles::SUPER) {
            $_SESSION['error'] = "No autorizado";
            return $this->redirect(BASE_URL . "/users");
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $estado = Status::ACTIVO;

        $stmt = $db->prepare("
            INSERT INTO usuarios (username, nombre, apellido, password, rol_id, estado)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("ssssii", $username, $nombre, $apellido, $passwordHash, $rol, $estado);

        if (!$stmt->execute()) {
            $_SESSION['error'] = "Error al crear usuario";
            return $this->redirect(BASE_URL . "/users/create");
        }

        $_SESSION['success'] = "Usuario creado";
        $this->redirect(BASE_URL . "/users");
    }

    // ======================================================
    // EDIT
    // ======================================================
    public function edit()
    {
        global $db;

        $id = $_GET['id'] ?? null;

        if (!$id) {
            return $this->redirect(BASE_URL . "/users");
        }

        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $user = $stmt->get_result()->fetch_assoc();

        if (!$user) {
            return $this->redirect(BASE_URL . "/users");
        }

        $roles = $db->query("SELECT * FROM roles")->fetch_all(MYSQLI_ASSOC);

        $this->render('Modules/Users/Views/edit', compact('user', 'roles'));
    }

    // ======================================================
    // UPDATE
    // ======================================================
    public function update()
    {
        global $db;

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        $id       = $_POST['id'] ?? null;
        $nombre   = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $rol      = $_POST['rol_id'] ?? null;

        if (!$id || !$nombre || !$rol) {
            $_SESSION['error'] = "Datos inválidos";
            return $this->redirect(BASE_URL . "/users");
        }

        if ($rol == Roles::SUPER && $rolId !== Roles::SUPER) {
            $_SESSION['error'] = "No autorizado";
            return $this->redirect(BASE_URL . "/users");
        }

        if (!empty($_POST['password'])) {

            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt = $db->prepare("
                UPDATE usuarios 
                SET nombre=?, apellido=?, password=?, rol_id=? 
                WHERE id=?
            ");

            $stmt->bind_param("sssii", $nombre, $apellido, $password, $rol, $id);

        } else {

            $stmt = $db->prepare("
                UPDATE usuarios 
                SET nombre=?, apellido=?, rol_id=? 
                WHERE id=?
            ");

            $stmt->bind_param("ssii", $nombre, $apellido, $rol, $id);
        }

        $stmt->execute();

        $_SESSION['success'] = "Usuario actualizado";
        $this->redirect(BASE_URL . "/users");
    }

    // ======================================================
    // TOGGLE
    // ======================================================
    public function toggle()
    {
        global $db;

        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!Roles::canEdit($rolId)) {
            return print json_encode(['ok' => false, 'error' => 'No autorizado']);
        }

        $id = $_POST['id'] ?? null;

        $stmt = $db->prepare("SELECT estado FROM usuarios WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $user = $stmt->get_result()->fetch_assoc();

        if (!$user) {
            return print json_encode(['ok' => false, 'error' => 'Usuario no existe']);
        }

        $nuevoEstado = $user['estado'] == Status::ACTIVO 
            ? Status::INACTIVO 
            : Status::ACTIVO;

        $stmt = $db->prepare("UPDATE usuarios SET estado=? WHERE id=?");
        $stmt->bind_param("ii", $nuevoEstado, $id);
        $stmt->execute();

        echo json_encode(['ok' => true, 'estado' => $nuevoEstado]);
    }

    // ======================================================
    // DELETE
    // ======================================================
    public function delete()
    {
        global $db;

        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!Roles::canDelete($rolId)) {
            return print json_encode(['ok' => false, 'error' => 'No autorizado']);
        }

        $id = $_POST['id'] ?? null;

        $estado = Status::ELIMINADO;

        $stmt = $db->prepare("UPDATE usuarios SET estado=? WHERE id=?");
        $stmt->bind_param("ii", $estado, $id);
        $stmt->execute();

        echo json_encode(['ok' => true]);
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public function restore()
    {
        global $db;

        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!Roles::canRestore($rolId)) {
            return print json_encode(['ok' => false, 'error' => 'No autorizado']);
        }

        $id = $_POST['id'] ?? null;

        $estado = Status::ACTIVO;

        $stmt = $db->prepare("UPDATE usuarios SET estado=? WHERE id=?");
        $stmt->bind_param("ii", $estado, $id);
        $stmt->execute();

        echo json_encode(['ok' => true]);
    }
}