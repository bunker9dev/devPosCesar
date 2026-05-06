<?php
require_once "config/conexion.php";

try {
    $db = Conexion::conectar();

    $stmt = $db->query("SELECT * FROM productos");
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "✅ Conectado correctamente<br><br>";

    echo "<pre>";
    print_r($datos);
    echo "</pre>";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}