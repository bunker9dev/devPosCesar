<?php

function auditoria($accion, $tabla, $registro_id = null, $descripcion = null, $modulo = null) {

    global $db;

    if (!$db) return;

    $usuario_id = $_SESSION['user']['id'] ?? 0;
    $registro_id = $registro_id ?? 0;

    $ip = $_SERVER['REMOTE_ADDR'] ?? '';
    $agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $modulo = $modulo ?? 'general';

    $stmt = $db->prepare("INSERT INTO auditoria 
        (usuario_id, accion, tabla, registro_id, descripcion, ip, user_agent, modulo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        error_log("Error auditoria: " . $db->error);
        return;
    }

    $stmt->bind_param(
        "ississss",
        $usuario_id,
        $accion,
        $tabla,
        $registro_id,
        $descripcion,
        $ip,
        $agent,
        $modulo
    );

    $stmt->execute();
}