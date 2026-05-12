<?php

function auditoria($accion, $tabla, $registro_id = null, $descripcion = null) {

    global $db;

    $usuario_id = $_SESSION['user']['id'] ?? null;
    $ip = $_SERVER['REMOTE_ADDR'] ?? null;
    $agent = $_SERVER['HTTP_USER_AGENT'] ?? null;

    $stmt = $db->prepare("INSERT INTO auditoria 
        (usuario_id, accion, tabla, registro_id, descripcion, ip, user_agent)
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "ississs",
        $usuario_id,
        $accion,
        $tabla,
        $registro_id,
        $descripcion,
        $ip,
        $agent
    );

    $stmt->execute();
}