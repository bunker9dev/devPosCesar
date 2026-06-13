<?php

namespace App\Core\Repositories;

class AuditLogRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function log($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO audit_logs (
                usuario_id,
                accion,
                entidad,
                entidad_id,
                modulo,
                detalle,
                ip,
                user_agent,
                created_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $usuario_id = $data['usuario_id'] ?? null;
        $accion = $data['accion'] ?? null;
        $entidad = $data['entidad'] ?? null;
        $entidad_id = $data['entidad_id'] ?? null;
        $modulo = $data['modulo'] ?? null;

        // 🔥 JSON PRO
        $detalle = isset($data['detalle'])
            ? json_encode($data['detalle'], JSON_UNESCAPED_UNICODE)
            : null;

        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

        $stmt->bind_param(
            "ississss",
            $usuario_id,
            $accion,
            $entidad,
            $entidad_id,
            $modulo,
            $detalle,
            $ip,
            $user_agent
        );

        $stmt->execute();
    }
}