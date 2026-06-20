<?php

namespace App\Modules\Users\Services;

use App\Core\Roles;
use App\Core\Status;
use App\Core\Database;
use App\Services\PermissionService;
use App\Core\Repositories\AuditLogRepository;

class UserService
{
    // ======================================================
    // LISTADO
    // ======================================================
    public static function getAllForList(int $rolId): array
    {
        $db = Database::getConnection();

        $userId = $_SESSION['user']['id'] ?? 0;

        $canManageSuper = PermissionService::can($rolId, 'users', 'manage_super');

        $query = "
        SELECT u.*, r.nombre as rol 
        FROM usuarios u
        JOIN roles r ON u.rol_id = r.id
        ";

        // OCULTAR SUPER A QUIEN NO TENGA EL PERMISO (salvo su propia fila)
        if (!$canManageSuper) {
            $query .= " WHERE (u.rol_id != " . Roles::SUPER . " OR u.id = {$userId})";
        }

        $canViewDeleted = PermissionService::can($rolId, 'users', 'view_deleted');

        if (!$canViewDeleted) {
            $query .= ($canManageSuper ? " WHERE " : " AND ")
                . "u.estado IN (" . Status::ACTIVO . "," . Status::INACTIVO . ")";
        }

        $result = $db->query($query);
        $users = $result->fetch_all(MYSQLI_ASSOC);

        $permissions = PermissionService::getModulePermissions($rolId, 'users');

        return self::formatList($users, $permissions);
    }

    // ======================================================
    // CREATE 
    // ======================================================
    public static function create(array $data, int $rolId): void
    {
        $db = Database::getConnection();

        $username = strtolower(trim($data['username'] ?? ''));
        $nombre   = trim($data['nombre'] ?? '');
        $apellido = trim($data['apellido'] ?? '');
        $password = $data['password'] ?? '';
        $rol      = $data['rol_id'] ?? null;

        if (!$username || !$nombre || !$password || !$rol) {
            throw new \Exception("Datos incompletos");
        }

        // ¿Se está asignando el rol Super? → requiere permiso 'users.manage_super'
        if ((int)$rol === Roles::SUPER && !PermissionService::can($rolId, 'users', 'manage_super')) {
            throw new \Exception("No autorizado");
        }

        // ============================
        // VALIDAR DUPLICADO
        // ============================
        $stmt = $db->prepare("
            SELECT id 
            FROM usuarios 
            WHERE LOWER(username) = ? 
            LIMIT 1
        ");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) {
            throw new \Exception("Usuario ya fue usado");
        }

        // ============================
        // PROCESAR IMAGEN 
        // ============================
        $imagen = 'default.png';

        if (!empty($_FILES['imagen']['name'])) {
            $file = $_FILES['imagen'];
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/users/';

            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0775, true)) {
                    throw new \Exception("No se pudo crear la carpeta de imágenes");
                }
            }

            if (!is_writable($uploadDir)) {
                throw new \Exception("La carpeta no tiene permisos de escritura");
            }

            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new \Exception("Error al subir archivo");
            }

            if ($file['size'] > 2 * 1024 * 1024) {
                throw new \Exception("La imagen supera el tamaño permitido (2MB)");
            }

            $mime = mime_content_type($file['tmp_name']);

            if (!str_starts_with($mime, 'image/')) {
                throw new \Exception("El archivo no es una imagen válida");
            }

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $imagen = uniqid('user_') . '.' . $ext;
            $destino = $uploadDir . $imagen;

            if (!move_uploaded_file($file['tmp_name'], $destino)) {
                die("No se pudo mover archivo a: " . $destino);
            }
        }

        // ============================
        // INSERT
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

        try {
            $stmt->execute();
        } catch (\mysqli_sql_exception $e) {

            if ($e->getCode() == 1062) {
                throw new \Exception("Usuario ya fue usado");
            }

            throw new \Exception("Error al crear usuario");
        }

        // ============================
        // AUDITORÍA
        // ============================
        (new AuditLogRepository($db))->log([
            'usuario_id' => $_SESSION['user']['id'] ?? null,
            'accion'     => 'create',
            'entidad'    => 'usuarios',
            'entidad_id' => $db->insert_id,
            'modulo'     => 'users',
            'detalle'    => [
                'after' => [
                    'username' => $username,
                    'nombre'   => $nombre,
                    'apellido' => $apellido,
                    'rol_id'   => $rol,
                    'imagen'   => $imagen,
                    'estado'   => $estado
                ]
            ]
        ]);
    }

    // ======================================================
    // UPDATE
    // ======================================================
    public static function update(array $data, int $rolId): void
    {
        $db = Database::getConnection();

        $id       = $data['id'] ?? null;
        $nombre   = trim($data['nombre'] ?? '');
        $apellido = trim($data['apellido'] ?? '');
        $rol      = $data['rol_id'] ?? null;
        $password = $data['password'] ?? null;

        if (!$id || !$nombre || !$rol) {
            throw new \Exception("Datos inválidos");
        }

        if ((int)$rol === Roles::SUPER && !PermissionService::can($rolId, 'users', 'manage_super')) {
            throw new \Exception("No autorizado");
        }

        // ============================
        // OBTENER USUARIO ACTUAL
        // ============================
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $old = $stmt->get_result()->fetch_assoc();

        if (!$old) {
            throw new \Exception("Usuario no existe");
        }

        // Si el usuario YA ES super, también requiere el permiso para editarlo
        if ((int)$old['rol_id'] === Roles::SUPER && !PermissionService::can($rolId, 'users', 'manage_super')) {
            throw new \Exception("No autorizado");
        }

        $imagen = $old['imagen'] ?? 'default.png';

        // ============================
        // PROCESAR NUEVA IMAGEN
        // ============================
        if (!empty($_FILES['imagen']['name'])) {

            $file = $_FILES['imagen'];

            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/users/';

            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new \Exception("Error al subir archivo");
            }

            if ($file['size'] > 2 * 1024 * 1024) {
                throw new \Exception("La imagen supera el tamaño permitido (2MB)");
            }

            $mime = mime_content_type($file['tmp_name']);

            if (!str_starts_with($mime, 'image/')) {
                throw new \Exception("El archivo no es una imagen válida");
            }

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $nuevaImagen = uniqid('user_') . '.' . $ext;

            $destino = $uploadDir . $nuevaImagen;

            if (!move_uploaded_file($file['tmp_name'], $destino)) {
                throw new \Exception("Error al subir la imagen");
            }

            if (!empty($imagen) && $imagen !== 'default.png') {
                $rutaAnterior = $uploadDir . $imagen;
                if (file_exists($rutaAnterior)) {
                    unlink($rutaAnterior);
                }
            }

            $imagen = $nuevaImagen;
        }

        // ============================
        // UPDATE
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
        // ACTUALIZAR SESIÓN
        // ============================
        if ($_SESSION['user']['id'] == $id) {

            $stmt = $db->prepare("
            SELECT u.*, r.nombre AS rol_nombre
            FROM usuarios u
            JOIN roles r ON r.id = u.rol_id
            WHERE u.id=?
        ");

            $stmt->bind_param("i", $id);
            $stmt->execute();

            $_SESSION['user'] = $stmt->get_result()->fetch_assoc();
        }

        // ============================
        // AUDITORÍA
        // ============================
        (new AuditLogRepository($db))->log([
            'usuario_id' => $_SESSION['user']['id'] ?? null,
            'accion'     => 'update',
            'entidad'    => 'usuarios',
            'entidad_id' => $id,
            'modulo'     => 'users',
            'detalle'    => [
                'before' => [
                    'nombre'   => $old['nombre'],
                    'apellido' => $old['apellido'],
                    'rol_id'   => $old['rol_id'],
                    'imagen'   => $old['imagen']
                ],
                'after' => [
                    'nombre'   => $nombre,
                    'apellido' => $apellido,
                    'rol_id'   => $rol,
                    'imagen'   => $imagen
                ]
            ]
        ]);
    }

    public static function getForEdit(int $id, int $rolId): array
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if (!$user) {
            throw new \Exception("Usuario no existe");
        }

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
        $db = Database::getConnection();

        if (PermissionService::can($rolId, 'users', 'manage_super')) {
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

        $superId = Roles::SUPER;

        $stmt->bind_param("i", $superId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ======================================================
    // TOGGLE
    // ======================================================
    public static function toggle($id, $rolId = null)
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT id, estado, rol_id FROM usuarios WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if (!$row) {
            throw new \Exception("Usuario no existe");
        }

        if ((int)$row['rol_id'] === Roles::SUPER && !PermissionService::can($rolId, 'users', 'manage_super')) {
            throw new \Exception("No autorizado");
        }

        if ($row['estado'] == Status::ELIMINADO) {
            throw new \Exception("No se puede modificar eliminado");
        }

        $nuevoEstado = ($row['estado'] == Status::ACTIVO)
            ? Status::INACTIVO
            : Status::ACTIVO;

        $stmt = $db->prepare("UPDATE usuarios SET estado=? WHERE id=?");
        $stmt->bind_param("ii", $nuevoEstado, $id);
        $stmt->execute();

        (new AuditLogRepository($db))->log([
            'usuario_id' => $_SESSION['user']['id'] ?? null,
            'accion' => 'toggle',
            'entidad' => 'usuarios',
            'entidad_id' => $id,
            'modulo' => 'users',
            'detalle' => [
                'before' => $row['estado'],
                'after'  => $nuevoEstado
            ]
        ]);

        return $nuevoEstado;
    }

    // ======================================================
    // DELETE
    // ======================================================
    public static function delete(int $id, int $rolId): void
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if (!$row) {
            throw new \Exception("Usuario no existe");
        }

        if ((int)$row['rol_id'] === Roles::SUPER && !PermissionService::can($rolId, 'users', 'manage_super')) {
            throw new \Exception("No autorizado");
        }

        $stmt = $db->prepare("
        UPDATE usuarios 
        SET deleted_at = NOW(), estado = ?, deleted_by = ?
        WHERE id = ?
    ");

        $estado = Status::ELIMINADO;
        $userId = $_SESSION['user']['id'] ?? null;

        $stmt->bind_param("iii", $estado, $userId, $id);
        $stmt->execute();

        (new AuditLogRepository($db))->log([
            'usuario_id' => $userId,
            'accion' => 'delete',
            'entidad' => 'usuarios',
            'entidad_id' => $id,
            'modulo' => 'users',
            'detalle' => [
                'before' => $row
            ]
        ]);
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public static function restore(int $id, int $rolId): void
    {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM usuarios WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if (!$row) {
            throw new \Exception("Usuario no existe");
        }

        if ((int)$row['rol_id'] === Roles::SUPER && !PermissionService::can($rolId, 'users', 'manage_super')) {
            throw new \Exception("No autorizado");
        }

        $stmt = $db->prepare("
        UPDATE usuarios 
        SET deleted_at = NULL, estado = ?, updated_by = ?
        WHERE id = ?
    ");

        $estado = Status::ACTIVO;
        $userId = $_SESSION['user']['id'] ?? null;

        $stmt->bind_param("iii", $estado, $userId, $id);
        $stmt->execute();

        (new AuditLogRepository($db))->log([
            'usuario_id' => $userId,
            'accion' => 'restore',
            'entidad' => 'usuarios',
            'entidad_id' => $id,
            'modulo' => 'users',
            'detalle' => [
                'after' => $row
            ]
        ]);
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
            default => 'Desconocido',
        };
    }

    private static function estadoClass(int $estado): string
    {
        return match ($estado) {
            Status::ACTIVO => 'active',
            Status::INACTIVO => 'inactive',
            Status::ELIMINADO => 'deleted',
            default => '',
        };
    }

    // ======================================================
    // VALIDAR USERNAME (AJAX)
    // ======================================================
    public static function usernameExists(string $username): bool
    {
        $db = Database::getConnection();

        $user = strtolower(trim($username));

        $stmt = $db->prepare("
            SELECT id 
            FROM usuarios 
            WHERE LOWER(username) = ?
            LIMIT 1
        ");

        $stmt->bind_param("s", $user);
        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }
}