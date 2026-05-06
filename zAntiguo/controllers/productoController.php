<?php
require_once(__DIR__ . "/../models/producto.php");

class productoController {

    public static function crear() {
        if(isset($_POST["nombre"])) {
            producto::crear($_POST["nombre"]);
            header("Location: ../index.php?page=productos");
        }
    }

    public static function listar() {
        return producto::listar();
    }
}