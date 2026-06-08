<?php

namespace App\Modules\Users\Services;

use App\Core\Status;
use App\Core\Roles;
use App\Services\CatalogService;
use App\Services\PermissionService;

class UserService
{
    // ======================================================
    // LISTADO
    // ======================================================
    public static function getAllForList(int $rolId): array
    {
        global $db;

        $userId = $_SESSION['user']['id'] ?? 0;

        $query = "
        SELECT u.*, r.nombre as rol 
        FROM usuarios u
        JOIN roles r ON u.rol_id = r.id
    ";

        //  OCULTAR SUPER A TODOS MENOS A SÍ MISMO
        $query .= " WHERE (u.rol_id != " . Roles::SUPER . " OR u.id = {$userId})";

        // PERMISOS RBAC (eliminados)
        $canViewDeleted = PermissionService::can($rolId, 'users', 'view_deleted');

        if (!$canViewDeleted) {
            $query .= " AND u.estado IN (" . Status::ACTIVO . "," . Status::INACTIVO . ")";
        }

        $result = $db->query($query);
        $users = $result->fetch_all(MYSQLI_ASSOC);

        $permissions = PermissionService::getModulePermissions($rolId, 'users');

        return self::formatList($users, $permissions, $rolId);
    }

    // ======================================================
    // CREATE
    // ======================================================
    public static function create(array $data, int $rolId): void
    {
        global $db;

        $username = trim($data['username'] ?? '');
        $nombre   = trim($data['nombre'] ?? '');
        $apellido = trim($data['apellido'] ?? '');
        $password = $data['password'] ?? '';
        $rol      = $data['rol_id'] ?? null;

        if (!$username || !$nombre || !$password || !$rol) {
            throw new \Exception("Datos incompletos");
        }

        if ($rol == Roles::SUPER && $rolId !== Roles::SUPER) {
            throw new \Exception("No autorizado");
        }

        // ============================
        // 🔥 VALIDAR DUPLICADO
        // ============================
        $stmt = $db->prepare("SELECT id FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) {
            throw new \Exception("Usuario ya existe");
        }

        // ============================
        // 🔥 PROCESAR IMAGEN
        // ============================
        $imagen = 'default.png';

        if (!empty($_FILES['imagen']['name'])) {

            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/users/';

            // validar tipo
            $mime = mime_content_type($_FILES['imagen']['tmp_name']);

            if (!str_starts_with($mime, 'image/')) {
                throw new \Exception("El archivo no es una imagen válida");
            }

            // validar tamaño (2MB)
            if ($_FILES['imagen']['size'] > 2 * 1024 * 1024) {
                throw new \Exception("La imagen supera el tamaño permitido (2MB)");
            }

            // extensión
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);

            // nombre único
            $imagen = uniqid('user_') . '.' . $ext;

            $destino = $uploadDir . $imagen;

            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
                throw new \Exception("Error al subir la imagen");
            }
        }

        // ============================
        // 🔥 INSERT CON IMAGEN
        // ============================
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $estado = Status::ACTIVO;

        $stmt = $db->prepare("
        INSERT INTO usuarios 
        (username, nombre, apellido, password, rol_id, estado, imagen)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

        $stmt->bind_param(
            "ssssiss",
            $username,
            $nombre,
            $apellido,
            $passwordHash,
            $rol,
            $estado,
            $imagen
        );

        if (!$stmt->execute()) {
            throw new \Exception("Error al crear usuario");
        }

        // ============================
        // 🔥 AUDITORÍA
        // ============================
        CatalogService::audit(
            'CREATE',
            'usuarios',
            $db->insert_id,
            "Usuario creado",
            'users',
            $_SESSION['user']['id']
        );
    }

    // ======================================================
    // UPDATE
    // ======================================================
    public static function update(array $data, int $rolId): void
{
    global $db;

    $id       = $data['id'] ?? null;
    $nombre   = trim($data['nombre'] ?? '');
    $apellido = trim($data['apellido'] ?? '');
    $rol      = $data['rol_id'] ?? null;
    $password = $data['password'] ?? null;

    if (!$id || !$nombre || !$rol) {
        throw new \Exception("Datos inválidos");
    }

    if ($rol == Roles::SUPER && $rolId !== Roles::SUPER) {
        throw new \Exception("No autorizado");
    }

    // ============================
    // 🔥 OBTENER IMAGEN ACTUAL
    // ============================
    $stmt = $db->prepare("SELECT imagen FROM usuarios WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();
    $imagen = $user['imagen'] ?? 'default.png';

    // ============================
    // 🔥 PROCESAR NUEVA IMAGEN
    // ============================
    if (!empty($_FILES['imagen']['name'])) {

        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/users/';

        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nuevaImagen = uniqid('user_') . '.' . $ext;

        $destino = $uploadDir . $nuevaImagen;

        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
            throw new \Exception("Error al subir imagen");
        }

        // 🔥 BORRAR IMAGEN ANTERIOR
        if (!empty($imagen) && $imagen !== 'default.png') {
            $rutaAnterior = $uploadDir . $imagen;
            if (file_exists($rutaAnterior)) {
                unlink($rutaAnterior);
            }
        }

        $imagen = $nuevaImagen;
    }

    // ============================
    // 🔥 UPDATE (CON IMAGEN)
    // ============================
    if (!empty($password)) {

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("
            UPDATE usuarios 
            SET nombre=?, apellido=?, password=?, rol_id=?, imagen=? 
            WHERE id=?
        ");

        $stmt->bind_param("sssisi", $nombre, $apellido, $passwordHash, $rol, $imagen, $id);

    } else {

        $stmt = $db->prepare("
            UPDATE usuarios 
            SET nombre=?, apellido=?, rol_id=?, imagen=? 
            WHERE id=?
        ");

        $stmt->bind_param("ssisi", $nombre, $apellido, $rol, $imagen, $id);
    }

    if (!$stmt->execute()) {
        throw new \Exception("Error al actualizar usuario");
    }

    // ============================
    // 🔥 AUDITORÍA
    // ============================
    CatalogService::audit(
        'UPDATE',
        'usuarios',
        $id,
        "Usuario actualizado",
        'users',
        $_SESSION['user']['id']
    );
}

    // ======================================================
    // GET FOR EDIT
    // ======================================================
    public static function getForEdit(int $id, int $rolId): array
    {
        global $db;

        $user = CatalogService::getById('usuarios', $id);

        $roles = self::getRolesForCreate($rolId);

        $permissions = PermissionService::getModulePermissions($rolId, 'users');

        return [
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'nombre' => $user['nombre'],
                'apellido' => $user['apellido'],
                'rol_id' => $user['rol_id'],
                'avatar_url' => self::avatarUrl($user['imagen'] ?? null),
            ],
            'roles' => $roles,
            'canEdit' => $permissions['edit']
        ];
    }

    // ======================================================
    // ROLES PARA CREATE / EDIT
    // ======================================================
    public static function getRolesForCreate(int $rolId): array
    {
        global $db;

        if ($rolId === Roles::SUPER) {
            $result = $db->query("SELECT id, nombre FROM roles");

            if (!$result) {
                throw new \Exception("Error al obtener roles");
            }

            return $result->fetch_all(MYSQLI_ASSOC);
        }

        $stmt = $db->prepare("SELECT id, nombre FROM roles WHERE id != ?");

        if (!$stmt) {
            throw new \Exception("Error en consulta de roles");
        }

        // 🔥 CORRECCIÓN AQUÍ
        $superId = Roles::SUPER;

        $stmt->bind_param("i", $superId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ======================================================
    // TOGGLE
    // ======================================================
    public static function toggle(int $id, int $rolId): int
    {
        return CatalogService::toggle(
            'usuarios',
            $id,
            $_SESSION['user']['id'],
            'users'
        );
    }

    // ======================================================
    // DELETE
    // ======================================================
    public static function delete(int $id, int $rolId): void
    {
        CatalogService::delete(
            'usuarios',
            $id,
            $_SESSION['user']['id'],
            'users'
        );
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public static function restore(int $id, int $rolId): void
    {
        CatalogService::restore(
            'usuarios',
            $id,
            $_SESSION['user']['id'],
            'users'
        );
    }

    // ======================================================
    // FORMAT LIST
    // ======================================================
    private static function formatList(array $users, array $permissions): array
    {
        return array_map(function ($u) use ($permissions) {

            $estado = (int)$u['estado'];

            return [
                'id' => $u['id'],
                'username' => $u['username'],
                'nombre' => $u['nombre'],
                'rol' => $u['rol'],
                'estado' => $estado,

                'avatar_url' => self::avatarUrl($u['imagen'] ?? null),
                'ultimo_login' => self::formatUltimoLogin($u['ultimo_login'] ?? null),

                'estado_label' => self::estadoLabel($estado),
                'estado_class' => self::estadoClass($estado),

                'can_edit' => $permissions['edit'] && $estado !== Status::ELIMINADO,
                'can_delete' => $permissions['delete'] && $estado !== Status::ELIMINADO,
                'can_restore' => $permissions['restore'] && $estado === Status::ELIMINADO,
            ];
        }, $users);
    }

    // ======================================================
    // HELPERS
    // ======================================================
    private static function avatarUrl(?string $imagen): string
    {
        return BASE_URL . '/assets/img/users/' . ($imagen ?: 'default.png');
    }

    private static function formatUltimoLogin($fecha): string
    {
        if (!$fecha) return 'Nunca';

        return date('d/m/Y H:i', strtotime($fecha));
    }

    private static function estadoLabel(int $estado): string
    {
        return match ($estado) {
            Status::ACTIVO => 'Activo',
            Status::INACTIVO => 'Inactivo',
            Status::ELIMINADO => 'Eliminado',
        };
    }
    // ======================================================
    // USERNAME
    // ======================================================
    private static function estadoClass(int $estado): string
    {
        return match ($estado) {
            Status::ACTIVO => 'active',
            Status::INACTIVO => 'inactive',
            Status::ELIMINADO => 'deleted',
        };
    }

    // ======================================================
    // VALIDAR USERNAME (AJAX)
    // ======================================================
    public static function usernameExists(string $username): bool
    {
        global $db;

        $user = strtolower(trim($username));

        $stmt = $db->prepare("
        SELECT id 
        FROM usuarios 
        WHERE LOWER(username) = ?
    ");

        $stmt->bind_param("s", $user);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }
}
