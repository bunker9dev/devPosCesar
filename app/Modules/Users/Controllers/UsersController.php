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

        // 🔥 SUPER → ve todo
        if ($_SESSION['user']['rol'] == 1) {

            $query = "SELECT u.*, r.nombre as rol 
                  FROM usuarios u
                  JOIN roles r ON u.rol_id = r.id";
        } else {

            // 🔥 ADMIN → NO ve eliminados
            $query = "SELECT u.*, r.nombre as rol 
                  FROM usuarios u
                  JOIN roles r ON u.rol_id = r.id
                  WHERE u.estado IN (1,2)";
        }


        $result = $db->query($query);

        $this->render('Modules/Users/Views/index', [
            'users' => $result->fetch_all(MYSQLI_ASSOC),
            'title' => 'Usuarios'
        ]);
    }

    // FORM CREAR
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

        // SUBIR IMAGEN

        $imagenNombre = "default.png";

        if (!empty($_FILES['imagen']['name'])) {

            $carpeta = $_SERVER['DOCUMENT_ROOT'] . "/assets/img/users/";
            // 🔥 DEBUG AQUÍ
            // echo $carpeta;
            // die;

            if (!is_dir($carpeta)) {
                mkdir($carpeta, 0755, true);
            }

            // 🔥 EXTENSIÓN
            $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($ext, $permitidas)) {
                $imagenNombre = "default.png";
            } else {

                // 🔥 👉 AQUÍ VA TU VALIDACIÓN MIME
                $mime = mime_content_type($_FILES['imagen']['tmp_name']);

                $permitidosMime = ['image/jpeg', 'image/png', 'image/webp'];

                if (!in_array($mime, $permitidosMime)) {
                    $imagenNombre = "default.png";
                } else {

                    // 🔥 NOMBRE ÚNICO
                    $imagenNombre = md5(uniqid(rand(), true)) . "." . $ext;

                    $rutaCompleta = $carpeta . $imagenNombre;

                    // 🔥 MOVER ARCHIVO
                    if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaCompleta)) {
                        $imagenNombre = "default.png";
                    }
                }
            }
        }

        // 🔐 HASH
        $password = password_hash($passwordRaw, PASSWORD_BCRYPT);

        // 🔥 INSERT
        $stmt = $db->prepare("
            INSERT INTO usuarios (username, nombre, apellido, imagen, password, rol_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        if (!$stmt) {
            die("Error prepare: " . $db->error);
        }

        $stmt->bind_param("sssssi", $username, $nombre, $apellido, $imagenNombre, $password, $rol);

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

        if (!$id) {
            $_SESSION['error'] = "ID inválido";
            return $this->redirect(BASE_URL . "/users");
        }

        // obtener usuario
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $user = $stmt->get_result()->fetch_assoc();

        if (!$user) {
            $_SESSION['error'] = "Usuario no encontrado";
            return $this->redirect(BASE_URL . "/users");
        }

        // imagen por defecto si no tiene
        if (empty($user['imagen'])) {
            $user['imagen'] = "default.png";
        }

        // roles
        $roles = $db->query("SELECT * FROM roles")->fetch_all(MYSQLI_ASSOC);

        $this->render('Modules/Users/Views/edit', [
            'user' => $user,
            'roles' => $roles,
            'title' => 'Editar Usuario'
        ]);
    }

    public function update()
    {
        $this->auth();
        $this->onlyAdmin();

        global $db;

        $id = (int) ($_POST['id'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $rol = (int) ($_POST['rol_id'] ?? 0);
        $passwordRaw = $_POST['password'] ?? null;

        if (!$id || !$nombre || !$rol) {
            $_SESSION['error'] = "Datos inválidos";
            return $this->redirect(BASE_URL . "/users");
        }

        // 🔍 verificar usuario
        $stmt = $db->prepare("SELECT id, rol_id, imagen FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $userDB = $stmt->get_result()->fetch_assoc();

        if (!$userDB) {
            $_SESSION['error'] = "Usuario no existe";
            return $this->redirect(BASE_URL . "/users");
        }

        // 🔒 reglas de seguridad
        if ($rol == 1 && $_SESSION['user']['rol'] != 1) {
            $_SESSION['error'] = "No puedes asignar rol SUPER";
            return $this->redirect(BASE_URL . "/users");
        }

        if ($id == $_SESSION['user']['id']) {
            $_SESSION['error'] = "No puedes cambiar tu propio rol";
            return $this->redirect(BASE_URL . "/users");
        }

        // 🔐 validar password
        if (!empty($passwordRaw) && strlen($passwordRaw) < 6) {
            $_SESSION['error'] = "Password mínimo 6 caracteres";
            return $this->redirect(BASE_URL . "/users");
        }

        // 🖼️ imagen actual
        $imagenNombre = $userDB['imagen'] ?? 'default.png';

        // 🖼️ nueva imagen
        if (!empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] === 0) {

            $carpeta = $_SERVER['DOCUMENT_ROOT'] . "/assets/img/users/";

            if (!is_dir($carpeta)) {
                mkdir($carpeta, 0755, true);
            }

            $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($ext, $permitidas)) {

                // borrar anterior
                if (!empty($userDB['imagen']) && $userDB['imagen'] !== 'default.png') {
                    $old = $carpeta . $userDB['imagen'];
                    if (file_exists($old)) unlink($old);
                }

                $imagenNombre = md5(uniqid(rand(), true)) . "." . $ext;
                move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta . $imagenNombre);
            }
        }

        // 🔥 CONSTRUIR UPDATE DINÁMICO
        if (!empty($passwordRaw)) {

            $password = password_hash($passwordRaw, PASSWORD_BCRYPT);

            $stmt = $db->prepare("
            UPDATE usuarios 
            SET nombre=?, apellido=?, rol_id=?, imagen=?, password=? 
            WHERE id=?
        ");

            $stmt->bind_param("ssissi", $nombre, $apellido, $rol, $imagenNombre, $password, $id);
        } else {

            $stmt = $db->prepare("
            UPDATE usuarios 
            SET nombre=?, apellido=?, rol_id=?, imagen=? 
            WHERE id=?
        ");

            $stmt->bind_param("ssisi", $nombre, $apellido, $rol, $imagenNombre, $id);
        }

        $stmt->execute();

        auditoria("UPDATE", "usuarios", $id, "Actualización de usuario", "users");

        $_SESSION['success'] = "Usuario actualizado correctamente";

        return $this->redirect(BASE_URL . "/users");
    }


public function toggle()
{
    // 🔹 limpiar buffer (evita romper JSON)
    if (ob_get_length()) ob_clean();

    header('Content-Type: application/json');

    try {

        $db = conectarDB();

        // 🔒 AUTENTICACIÓN
        if (!isset($_SESSION['user'])) {
            echo json_encode([
                'ok' => false,
                'error' => 'No autenticado'
            ]);
            exit;
        }

        // 🔒 ROLES PERMITIDOS (SUPER y ADMIN)
        if (!in_array($_SESSION['user']['rol'], [1, 2])) {
            echo json_encode([
                'ok' => false,
                'error' => 'No autorizado'
            ]);
            exit;
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            echo json_encode([
                'ok' => false,
                'error' => 'ID inválido'
            ]);
            exit;
        }

        // 🔍 OBTENER USUARIO
        $stmt = $db->prepare("
            SELECT id, estado, username 
            FROM usuarios 
            WHERE id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $userDB = $stmt->get_result()->fetch_assoc();

        if (!$userDB) {
            echo json_encode([
                'ok' => false,
                'error' => 'Usuario no existe'
            ]);
            exit;
        }

        $estadoActual = (int)$userDB['estado'];

        // 🚨 NO TOCAR ELIMINADOS
        if ($estadoActual === 0) {
            echo json_encode([
                'ok' => false,
                'error' => 'Usuario eliminado'
            ]);
            exit;
        }

        // 🔄 CALCULAR NUEVO ESTADO (1 ↔ 2)
        $nuevoEstado = ($estadoActual === 1) ? 2 : 1;

        // 🔥 UPDATE
        $stmt = $db->prepare("
            UPDATE usuarios 
            SET estado = ? 
            WHERE id = ?
        ");
        $stmt->bind_param("ii", $nuevoEstado, $id);
        $stmt->execute();

        // 🧠 FUNCION TEXTO ESTADO
        $estadoTexto = function ($estado) {
            return match ($estado) {
                1 => 'Activo',
                2 => 'Inactivo',
                0 => 'Eliminado',
                default => 'Desconocido'
            };
        };

        // 🔍 USUARIO QUE REALIZA LA ACCIÓN
        $usuarioAccion = $_SESSION['user']['username'] ?? 'Sistema';

        // 📝 DETALLE AUDITORÍA
        $detalle = "Usuario: {$userDB['username']} | Estado: " 
                 . $estadoTexto($estadoActual) . " → " 
                 . $estadoTexto($nuevoEstado) 
                 . " | Por: {$usuarioAccion}";

        // 📊 AUDITORÍA
        if (function_exists('auditoria')) {
            auditoria(
                "UPDATE",
                "usuarios",
                $id,
                $detalle,
                "users"
            );
        }

        // ✅ RESPUESTA
        echo json_encode([
            'ok' => true,
            'estado' => $nuevoEstado,
            'estado_texto' => $estadoTexto($nuevoEstado)
        ]);
        exit;

    } catch (Exception $e) {

        echo json_encode([
            'ok' => false,
            'error' => $e->getMessage()
        ]);
        exit;
    }
}




    

    // VALIDAR USERNAME (AJAX)
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


// #######################################################################################################################################


// namespace App\Modules\Users\Controllers;

// use App\Core\Controller;

// class UsersController extends Controller
// {

//     /* =========================================================
//        🔐 VALIDACIÓN DE SESIÓN
//        (Debe ser protected por herencia)
//     ========================================================= */
//     protected function auth()
//     {
//         if (!isset($_SESSION['user'])) {
//             header("Location: " . BASE_URL . "/login");
//             exit;
//         }
//     }

//     /* =========================================================
//        🔐 SOLO ADMIN
//        (Debe ser protected por herencia)
//     ========================================================= */
//     protected function onlyAdmin()
//     {
//         if ($_SESSION['user']['rol'] !== 'admin') {
//             header("Location: " . BASE_URL . "/dashboard");
//             exit;
//         }
//     }

//     /* =========================================================
//        📄 LISTADO DE USUARIOS
//     ========================================================= */
//     public function index()
//     {
//         $this->auth();

//         global $db;

//         $result = $db->query("SELECT * FROM usuarios ORDER BY id DESC");
//         $users = $result->fetch_all(MYSQLI_ASSOC);

//         return $this->view('Users::index', [
//             'users' => $users
//         ]);
//     }

//     /* =========================================================
//        ➕ FORMULARIO CREAR
//     ========================================================= */
//     public function create()
//     {
//         $this->auth();
//         $this->onlyAdmin();

//         return $this->view('Users::create');
//     }

//     /* =========================================================
//        💾 GUARDAR USUARIO
//     ========================================================= */
//     public function store()
//     {
//         $this->auth();
//         $this->onlyAdmin();

//         global $db;

//         $username = trim($_POST['username'] ?? '');
//         $nombre   = trim($_POST['nombre'] ?? '');
//         $password = $_POST['password'] ?? '';
//         $rol      = $_POST['rol'] ?? 'usuario';

//         if (!$username || !$nombre || !$password) {
//             $_SESSION['error'] = "Todos los campos son obligatorios";
//             return $this->redirect(BASE_URL . "/users/create");
//         }

//         $passwordHash = password_hash($password, PASSWORD_BCRYPT);

//         $stmt = $db->prepare("
//             INSERT INTO usuarios (username, nombre, password, rol, estado) 
//             VALUES (?, ?, ?, ?, 1)
//         ");

//         $stmt->bind_param("ssss", $username, $nombre, $passwordHash, $rol);
//         $stmt->execute();

//         auditoria("INSERT", "usuarios", $stmt->insert_id, "Nuevo usuario", "users");

//         $_SESSION['success'] = "Usuario creado correctamente";
//         return $this->redirect(BASE_URL . "/users");
//     }

//     /* =========================================================
//        ✏️ FORMULARIO EDITAR
//     ========================================================= */
//     public function edit()
//     {
//         $this->auth();
//         $this->onlyAdmin();

//         global $db;

//         $id = $_GET['id'] ?? null;

//         $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
//         $stmt->bind_param("i", $id);
//         $stmt->execute();

//         $user = $stmt->get_result()->fetch_assoc();

//         return $this->view('Users::edit', [
//             'user' => $user
//         ]);
//     }

//     /* =========================================================
//        🔄 ACTUALIZAR USUARIO
//     ========================================================= */
//     public function update()
//     {
//         $this->auth();
//         $this->onlyAdmin();

//         global $db;

//         $id       = $_POST['id'] ?? null;
//         $username = trim($_POST['username'] ?? '');
//         $nombre   = trim($_POST['nombre'] ?? '');
//         $rol      = $_POST['rol'] ?? 'usuario';

//         $stmt = $db->prepare("
//             UPDATE usuarios 
//             SET username = ?, nombre = ?, rol = ? 
//             WHERE id = ?
//         ");

//         $stmt->bind_param("sssi", $username, $nombre, $rol, $id);
//         $stmt->execute();

//         auditoria("UPDATE", "usuarios", $id, "Actualización de usuario", "users");

//         $_SESSION['success'] = "Usuario actualizado";
//         return $this->redirect(BASE_URL . "/users");
//     }

//     /* =========================================================
//        🔄 TOGGLE ESTADO (AJAX)
//        🔥 AHORA DEVUELVE JSON (NO HTML)
//     ========================================================= */
//     public function toggle()
//     {
//         $this->auth();
//         $this->onlyAdmin();

//         header('Content-Type: application/json');

//         global $db;

//         try {

//             $id = $_POST['id'] ?? null;
//             $estado = $_POST['estado'] ?? null;

//             if (!$id) {
//                 echo json_encode([
//                     'ok' => false,
//                     'error' => 'ID inválido'
//                 ]);
//                 return;
//             }

//             $stmt = $db->prepare("
//                 UPDATE usuarios 
//                 SET estado = ? 
//                 WHERE id = ?
//             ");

//             if (!$stmt) {
//                 throw new \Exception($db->error);
//             }

//             $stmt->bind_param("ii", $estado, $id);

//             if (!$stmt->execute()) {
//                 throw new \Exception($stmt->error);
//             }

//             auditoria("UPDATE", "usuarios", $id, "Cambio de estado", "users");

//             echo json_encode([
//                 'ok' => true
//             ]);

//         } catch (\Exception $e) {

//             echo json_encode([
//                 'ok' => false,
//                 'error' => $e->getMessage()
//             ]);
//         }
//     }

//     /* =========================================================
//        🔍 VALIDAR USERNAME (AJAX)
//     ========================================================= */
//     public function checkUsername()
//     {
//         header('Content-Type: application/json');

//         global $db;

//         $username = $_POST['username'] ?? '';

//         $stmt = $db->prepare("SELECT id FROM usuarios WHERE username = ?");
//         $stmt->bind_param("s", $username);
//         $stmt->execute();

//         $result = $stmt->get_result();

//         echo json_encode([
//             'success' => true,
//             'exists' => $result->num_rows > 0
//         ]);
//     }
// }