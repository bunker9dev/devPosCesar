<?php

function conectarDB() {
    $db = new mysqli("localhost", "root", "", "devpos_cesar");

    if ($db->connect_error) {
        die("Error de conexión: " . $db->connect_error);
    }

    $db->set_charset("utf8mb4");

    return $db;
}