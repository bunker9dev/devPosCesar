<?php
require_once(__DIR__ . "/../config/conexion.php");


class producto {

    static public function crear($nombre) {
        $stmt = Conexion::conectar()->prepare("INSERT INTO productos(nombre) VALUES(:nombre)");
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        return $stmt->execute();
    }

    static public function listar() {
        $stmt = Conexion::conectar()->prepare("SELECT * FROM productos");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}