<?php

namespace App\Modules\Products\Repositories;

class AuditLogRepository
{
    public static function log($data)
    {
        global $conn;

        $stmt = $conn->prepare("
            INSERT INTO audit_logs (
                user_id,
                modulo,
                accion,
                data_before,
                data_after,
                ip,
                created_at
            ) VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");

        $user_id = $data['user_id'] ?? null;
        $modulo = $data['modulo'] ?? null;
        $accion = $data['accion'] ?? null;
        $data_before = $data['data_before'] ?? null;
        $data_after = $data['data_after'] ?? null;
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

        $stmt->bind_param(
            "isssss",
            $user_id,
            $modulo,
            $accion,
            $data_before,
            $data_after,
            $ip
        );

        $stmt->execute();
    }
}