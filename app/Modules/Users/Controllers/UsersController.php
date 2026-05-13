<?php

namespace App\Modules\Users\Controllers;

use App\Core\Controller;

class UsersController extends Controller
{
    // 📋 LISTAR
    public function index()
    {
        $this->auth();
        $this->onlyAdmin();

        global $db;

        $query = "SELECT u.*, r.nombre as rol 
                  FROM usuarios u
                  JOIN roles r ON u.rol_id = r.id";

        $result = $db->query($query);

        $this->render('Modules/Users/Views/index', [
            'users' => $result->fetch_all(MYSQLI_ASSOC),
            'title' => 'Usuarios'
        ]);
    }

    // ➕ FORM CREAR
    public function create()
    {
        $this->auth();
        $this->onlyAdmin();

        global $db;

        $roles = $db->query("SELECT * FROM roles")->fetch_all(MYSQLI_ASSOC);

        $this->render('Modules/Users/Views/create', [
            'roles' => $roles,
            'title' => 'Crear Usuario'
        ]);
    }

    // 💾 GUARDAR
    public function store()
    {
        $this->auth();
        $this->onlyAdmin();

        global $db;

        // 🔥 LIMPIAR
        $username = strtolower(trim($_POST['username'] ?? ''));
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $passwordRaw = $_POST['password'] ?? '';
        $rol = (int) ($_POST['rol_id'] ?? 0);

        // ARRAY DE ERRORES
        $errors = [];

        // VALIDACIONES

        if (!$username) {
            $errors['username'] = "Username obligatorio";
        } elseif (!preg_match('/^[a-z0-9_]{3,20}$/', $username)) {
            $errors['username'] = "Username inválido";
        }

        if (!$nombre) {
            $errors['nombre'] = "Nombre obligatorio";
        } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{2,50}$/', $nombre)) {
            $errors['nombre'] = "Nombre inválido";
        }

        if (!$passwordRaw) {
            $errors['password'] = "Password obligatorio";
        } elseif (strlen($passwordRaw) < 4) {
            $errors['password'] = "Password mínimo 4 caracteres";
        }

        if (!$rol) {
            $errors['rol_id'] = "Selecciona un rol";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;

            return $this->redirect(BASE_URL . "/users/create");
        }

        // 🔐 HASH
        $password = password_hash($passwordRaw, PASSWORD_BCRYPT);

        // 🔥 INSERT
        $stmt = $db->prepare("
            INSERT INTO usuarios (username, nombre, apellido, password, rol_id)
            VALUES (?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            die("Error prepare: " . $db->error);
        }

        $stmt->bind_param("ssssi", $username, $nombre, $apellido, $password, $rol);

        if (!$stmt->execute()) {

            // 🔥 MANEJO ERROR UNIQUE
            if ($db->errno == 1062) {
                $_SESSION['error'] = "El username ya está en uso";
            } else {
                $_SESSION['error'] = "Error al guardar usuario";
            }

            return $this->redirect(BASE_URL . "/users/create");
        }

        // 🧾 AUDITORÍA
        auditoria("CREATE", "usuarios", $stmt->insert_id, "Creación de usuario", "users");

        $_SESSION['success'] = "Usuario creado correctamente";

        return $this->redirect(BASE_URL . "/users");
    }

    // ✏️ EDITAR
    public function edit()
    {
        $this->auth();
        $this->onlyAdmin();

        global $db;

        $id = (int) ($_GET['id'] ?? 0);

        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $user = $stmt->get_result()->fetch_assoc();

        $roles = $db->query("SELECT * FROM roles")->fetch_all(MYSQLI_ASSOC);

        $this->render('Modules/Users/Views/edit', [
            'user' => $user,
            'roles' => $roles,
            'title' => 'Editar Usuario'
        ]);
    }

    // 🔄 ACTUALIZAR
    public function update()
    {
        $this->auth();
        $this->onlyAdmin();

        global $db;

        $id = (int) ($_POST['id'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $rol = (int) ($_POST['rol_id'] ?? 0);

        if (!$id || !$nombre || !$rol) {
            $_SESSION['error'] = "Datos inválidos";
            return $this->redirect(BASE_URL . "/users");
        }

        $stmt = $db->prepare("
            UPDATE usuarios 
            SET nombre=?, apellido=?, rol_id=? 
            WHERE id=?
        ");

        $stmt->bind_param("ssii", $nombre, $apellido, $rol, $id);
        $stmt->execute();

        auditoria("UPDATE", "usuarios", $id, "Actualización de usuario", "users");

        $_SESSION['success'] = "Usuario actualizado";

        return $this->redirect(BASE_URL . "/users");
    }

    // 🔁 ACTIVAR / INACTIVAR
    public function toggle()
    {
        $this->auth();
        $this->onlyAdmin();

        global $db;

        $id = (int) ($_GET['id'] ?? 0);

        $stmt = $db->prepare("
            UPDATE usuarios 
            SET estado = IF(estado=1,0,1) 
            WHERE id = ?
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        auditoria("UPDATE", "usuarios", $id, "Cambio de estado", "users");

        return $this->redirect(BASE_URL . "/users");
    }

    // 🔍 VALIDAR USERNAME (AJAX)
    public function checkUsername()
    {
        global $db;

        header('Content-Type: application/json');

        $username = strtolower(trim($_POST['username'] ?? ''));

        if (!$username) {
            echo json_encode(['success' => false]);
            return;
        }

        $stmt = $db->prepare("
            SELECT id 
            FROM usuarios 
            WHERE username = ? 
            LIMIT 1
        ");

        $stmt->bind_param("s", $username);
        $stmt->execute();

        $exists = $stmt->get_result()->num_rows > 0;

        echo json_encode([
            'success' => true,
            'exists' => $exists
        ]);
    }
}
