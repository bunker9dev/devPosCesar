<?php

function conectarDB() {

    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "devpos_cesar";

     $db = new mysqli($host, $user, $pass, $dbname);

    if ($db->connect_error) {
        die("Error de conexión: " . $db->connect_error);
    }

    $db->set_charset("utf8mb4");

    return $db;
}