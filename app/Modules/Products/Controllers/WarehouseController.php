<?php

namespace App\Modules\Products\Controllers;

use App\Core\Controller;

class WarehouseController extends Controller
{
    public function index()
    {
        $db = conectarDB();

        $warehouses = $db->query("
            SELECT * FROM warehouses
            ORDER BY id DESC
        ")->fetch_all(MYSQLI_ASSOC);

        $this->render('Modules/Products/Views/warehouses/index', [
            'warehouses' => $warehouses,
            'title' => 'Bodegas'

        ]);
    }

    public function store()
    {
        $db = conectarDB();

        $nombre = trim($_POST['nombre']);
        $ubicacion = trim($_POST['ubicacion']);

        // VALIDAR DUPLICADO POR NOMBRE
        $stmt = $db->prepare("
        SELECT id 
        FROM warehouses 
        WHERE LOWER(nombre) = ?
        LIMIT 1
    ");

        $nombreLower = strtolower($nombre);

        $stmt->bind_param("s", $nombreLower);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) {
            $_SESSION['error'] = "El nombre ingresado ya ha sido utilizado.";
            header("Location: " . BASE_URL . "/warehouses");
            return;
        }

        // GENERAR CÓDIGO
        $result = $db->query("SELECT MAX(id) as max FROM warehouses");
        $row = $result->fetch_assoc();

        $codigo = 'BOD-' . str_pad(($row['max'] + 1), 3, '0', STR_PAD_LEFT);

        //  INSERT
        $stmt = $db->prepare("
        INSERT INTO warehouses (codigo, nombre, ubicacion)
        VALUES (?, ?, ?)
    ");

        $stmt->bind_param("sss", $codigo, $nombre, $ubicacion);
        $stmt->execute();

        $_SESSION['success'] = "Bodega creada correctamente";

        header("Location: " . BASE_URL . "/warehouses");
    }

    public function update()
    {
        header('Content-Type: application/json');

        try {
            $db = conectarDB();

            $id = $_POST['id'];
            $nombre = trim($_POST['nombre']);
            $ubicacion = trim($_POST['ubicacion']);

            $stmt = $db->prepare("
                UPDATE warehouses
                SET nombre = ?, ubicacion = ?
                WHERE id = ?
            ");

            $stmt->bind_param("ssi", $nombre, $ubicacion, $id);
            $stmt->execute();

            echo json_encode([
                'success' => true,
                'message' => 'Bodega actualizada'
            ]);
        } catch (\Throwable $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        exit;
    }

    public function delete()
    {
        header('Content-Type: application/json');

        $db = conectarDB();
        $id = $_POST['id'];

        $stmt = $db->prepare("
            UPDATE warehouses
            SET estado = -1
            WHERE id = ?
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo json_encode(['ok' => true]);
    }

    public function restore()
    {
        header('Content-Type: application/json');

        $db = conectarDB();
        $id = $_POST['id'];

        $stmt = $db->prepare("
            UPDATE warehouses
            SET estado = 1
            WHERE id = ?
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo json_encode(['ok' => true]);
    }

    public function toggle()
{
    header('Content-Type: application/json');

    $db = conectarDB();
    $id = $_POST['id'];

    // 🔥 obtener estado actual
    $stmt = $db->prepare("SELECT estado FROM warehouses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $row = $stmt->get_result()->fetch_assoc();

    // ❌ no permitir toggle si eliminado
    if ($row['estado'] == -1) {
        echo json_encode([
            'ok' => false,
            'error' => 'No se puede modificar un registro eliminado'
        ]);
        return;
    }

    // 🔥 alternar manual
    $nuevoEstado = $row['estado'] == 1 ? 0 : 1;

    $stmt = $db->prepare("
        UPDATE warehouses 
        SET estado = ?
        WHERE id = ?
    ");

    $stmt->bind_param("ii", $nuevoEstado, $id);
    $stmt->execute();

    echo json_encode(['ok' => true]);
}
}
