<?php

namespace App\Services;

use App\Core\Status;

class CatalogService
{
    // ======================================================
    // GET BY ID
    // ======================================================
    public static function getById(string $table, int $id): array
{
    global $db;

    self::validateTable($table);

    $recordId = (int) $id;

    $stmt = $db->prepare("SELECT * FROM {$table} WHERE id = ?");
    $stmt->bind_param("i", $recordId); 

    $stmt->execute();

    $data = $stmt->get_result()->fetch_assoc();

    if (!$data) {
        throw new \Exception("Registro no existe");
    }

    return $data;
}
    // ======================================================
    // TOGGLE (ACTIVO / INACTIVO)
    // ======================================================
    public static function toggle(string $table, int $id, int $userId, string $modulo): int
    {
        global $db;

        self::validateTable($table);

        $row = self::getById($table, $id);

        if ($row['estado'] == Status::ELIMINADO) {
            throw new \Exception("No se puede cambiar estado de un eliminado");
        }

        $nuevoEstado = $row['estado'] == Status::ACTIVO
            ? Status::INACTIVO
            : Status::ACTIVO;

        $stmt = $db->prepare("UPDATE {$table} SET estado=? WHERE id=?");
        $stmt->bind_param("ii", $nuevoEstado, $id);
        $stmt->execute();

        self::audit('TOGGLE', $table, $id, "Cambio de estado", $modulo, $userId);

        return $nuevoEstado;
    }

    // ======================================================
    // DELETE (SOFT)
    // ======================================================
    public static function delete(string $table, int $id, int $userId, string $modulo): void
    {
        global $db;

        self::validateTable($table);

        $row = self::getById($table, $id);

        if ($row['estado'] == Status::ELIMINADO) {
            throw new \Exception("El registro ya está eliminado");
        }

        $estado = Status::ELIMINADO;

        $stmt = $db->prepare("UPDATE {$table} SET estado=? WHERE id=?");
        $stmt->bind_param("ii", $estado, $id);
        $stmt->execute();

        self::audit('DELETE', $table, $id, "Eliminado", $modulo, $userId);
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public static function restore(string $table, int $id, int $userId, string $modulo): void
    {
        global $db;

        self::validateTable($table);

        $row = self::getById($table, $id);

        if ($row['estado'] != Status::ELIMINADO) {
            throw new \Exception("El registro no está eliminado");
        }

        $estado = Status::ACTIVO;

        $stmt = $db->prepare("UPDATE {$table} SET estado=? WHERE id=?");
        $stmt->bind_param("ii", $estado, $id);
        $stmt->execute();

        self::audit('RESTORE', $table, $id, "Restaurado", $modulo, $userId);
    }

    // ======================================================
    // VALIDAR TABLAS (WHITELIST)
    // ======================================================
    private static function validateTable(string $table): void
    {
        $allowed = [
            'usuarios',
            'roles',
            'products',
            'fabric_types',
            'fabric_colors',
            'warehouses',
            'proveedores'
        ];

        if (!in_array($table, $allowed, true)) {
            throw new \Exception("Tabla no permitida");
        }
    }

    // ======================================================
    // AUDITORÍA CENTRALIZADA
    // ======================================================
    public static function audit(
        string $accion,
        string $tabla,
        int $id,
        string $detalle,
        string $modulo,
        int $userId
    ): void {
        global $db;

        $stmt = $db->prepare("
        INSERT INTO auditoria 
        (usuario_id, accion, tabla, registro_id, detalle, modulo, ip, user_agent)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

        if (!$stmt) {
            throw new \Exception("Error en auditoría: " . $db->error);
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;

        $stmt->bind_param(
            "ississss",
            $userId,
            $accion,
            $tabla,
            $id,
            $detalle,
            $modulo,
            $ip,
            $userAgent
        );

        if (!$stmt->execute()) {
            throw new \Exception("Error al guardar auditoría: " . $stmt->error);
        }
    }
}
