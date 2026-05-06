<?php

class Conexion {
    public static function conectar() {

        try {
            $link = new PDO("mysql:host=localhost;dbname=inventario_textil", "root", "");
            $link->exec("set names utf8");

            echo "✅ Conexión exitosa";

            return $link;

        } catch (PDOException $e) {
            echo "❌ Error: " . $e->getMessage();
        }

    }
}