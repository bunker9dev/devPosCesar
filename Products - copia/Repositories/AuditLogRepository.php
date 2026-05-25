<?php

namespace App\Modules\Products\Repositories;

class AuditLogRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function log($accion, $entidad, $entidadId, array $detalle = [], $modulo = 'inventory')
    {
        $usuarioId = $_SESSION['user']['id'] ?? null;
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        $json = json_encode($detalle, JSON_UNESCAPED_UNICODE);

        $stmt = $this->db->prepare("
            INSERT INTO audit_logs
            (usuario_id, accion, entidad, entidad_id, modulo, detalle, ip, user_agent)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ississss",
            $usuarioId,
            $accion,
            $entidad,
            $entidadId,
            $modulo,
            $json,
            $ip,
            $agent
        );

        $stmt->execute();
    }
}
