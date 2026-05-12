<?php

namespace App\Modules\Users\Controllers;

use App\Core\Controller;

class UsersController extends Controller
{
    // Listar usuarios
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

    // Form crear
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

    //  Guardar
    public function store()
    {
        $this->auth();
        $this->onlyAdmin();

        global $db;

        $username = strtolower(trim($_POST['username']));
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $rol = $_POST['rol_id'];

        $stmt = $db->prepare("INSERT INTO usuarios (username, nombre, apellido, password, rol_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $username, $nombre, $apellido, $password, $rol);
        $stmt->execute();

        auditoria("CREATE", "usuarios", $stmt->insert_id, "Creación de usuario");

        $this->redirect(BASE_URL . "/users");
    }

    // Editar
    public function edit()
    {
        $this->auth();
        $this->onlyAdmin();

        global $db;

        $id = $_GET['id'];

        $user = $db->query("SELECT * FROM usuarios WHERE id = $id")->fetch_assoc();
        $roles = $db->query("SELECT * FROM roles")->fetch_all(MYSQLI_ASSOC);

        $this->render('Modules/Users/Views/edit', [
            'user' => $user,
            'roles' => $roles,
            'title' => 'Editar Usuario'
        ]);
    }

    // Actualizar
    public function update()
    {
        $this->auth();
        $this->onlyAdmin();

        global $db;

        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $rol = $_POST['rol_id'];

        $stmt = $db->prepare("UPDATE usuarios SET nombre=?, apellido=?, rol_id=? WHERE id=?");
        $stmt->bind_param("ssii", $nombre, $apellido, $rol, $id);
        $stmt->execute();

        auditoria("UPDATE", "usuarios", $id, "Actualización de usuario");

        $this->redirect(BASE_URL . "/users");
    }

    // Activar / Inactivar
    public function toggle()
    {
        $this->auth();
        $this->onlyAdmin();

        global $db;

        $id = $_GET['id'];

        $db->query("UPDATE usuarios 
                    SET estado = IF(estado=1,0,1) 
                    WHERE id = $id");

        auditoria("UPDATE", "usuarios", $id, "Cambio de estado");

        $this->redirect(BASE_URL . "/users");
    }
}