<?php

namespace App\Modules\Products\Repositories;

use Exception;

class CatalogRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fabricTypes()
    {
        return $this->db->query("SELECT * FROM fabric_types WHERE estado = 1 ORDER BY nombre")->fetch_all(MYSQLI_ASSOC);
    }

    public function colors()
    {
        return $this->db->query("SELECT * FROM fabric_colors WHERE estado = 1 ORDER BY nombre")->fetch_all(MYSQLI_ASSOC);
    }

    public function warehouses($onlyActive = true)
    {
        $where = $onlyActive ? "WHERE estado = 1" : "";
        return $this->db->query("SELECT * FROM warehouses {$where} ORDER BY nombre")->fetch_all(MYSQLI_ASSOC);
    }

    public function suppliers()
    {
        return $this->db->query("SELECT id, nombre, apellidos, nit FROM proveedores WHERE estado IN (1,2) ORDER BY nombre")->fetch_all(MYSQLI_ASSOC);
    }

    public function products()
    {
        $sql = "
            SELECT p.*, ft.codigo AS tipo_codigo, ft.nombre AS tipo_nombre,
                   fc.codigo AS color_codigo, fc.nombre AS color_nombre, fc.hex
            FROM products p
            JOIN fabric_types ft ON ft.id = p.fabric_type_id
            JOIN fabric_colors fc ON fc.id = p.fabric_color_id
            ORDER BY ft.nombre, fc.nombre
        ";

        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function createFabricType($codigo, $nombre)
    {
        $stmt = $this->db->prepare("
            INSERT INTO fabric_types (codigo, nombre)
            VALUES (?, ?)
        ");
        $stmt->bind_param("ss", $codigo, $nombre);
        try {
            $stmt->execute();
        } catch (\mysqli_sql_exception $e) {
            if ((int) $e->getCode() === 1062) {
                throw new Exception("Ya existe un tipo de tela con ese nombre");
            }

            throw new Exception("No se pudo crear el tipo de tela: " . $e->getMessage());
        }

        return $stmt->insert_id;
    }

    public function nextFabricTypeCode()
    {
        return $this->nextCatalogCode('fabric_types');
    }

    public function createColor($codigo, $nombre, $hex)
    {
        $stmt = $this->db->prepare("
            INSERT INTO fabric_colors (codigo, nombre, hex)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param("sss", $codigo, $nombre, $hex);
        try {
            $stmt->execute();
        } catch (\mysqli_sql_exception $e) {
            if ((int) $e->getCode() === 1062) {
                throw new Exception("Ya existe un color con ese nombre");
            }

            throw new Exception("No se pudo crear el color: " . $e->getMessage());
        }

        return $stmt->insert_id;
    }

    public function nextColorCode()
    {
        return $this->nextCatalogCode('fabric_colors');
    }

    public function findFabricType($id)
    {
        return $this->findById('fabric_types', $id);
    }

    public function findColor($id)
    {
        return $this->findById('fabric_colors', $id);
    }

    public function findWarehouse($id)
    {
        return $this->findById('warehouses', $id);
    }

    public function findSupplier($id)
    {
        return $this->findById('proveedores', $id);
    }

    public function findOrCreateProduct($fabricTypeId, $colorId)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE fabric_type_id = ? AND fabric_color_id = ? LIMIT 1");
        $stmt->bind_param("ii", $fabricTypeId, $colorId);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        if ($product) {
            return $product;
        }

        $type = $this->findFabricType($fabricTypeId);
        $color = $this->findColor($colorId);

        if (!$type || !$color) {
            throw new Exception("Tipo de tela o color inválido");
        }

        $name = $type['nombre'] . ' - ' . $color['nombre'];
        $stmt = $this->db->prepare("
            INSERT INTO products (fabric_type_id, fabric_color_id, nombre)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param("iis", $fabricTypeId, $colorId, $name);
        $stmt->execute();

        return [
            'id' => $stmt->insert_id,
            'fabric_type_id' => $fabricTypeId,
            'fabric_color_id' => $colorId,
            'nombre' => $name,
        ];
    }

    private function findById($table, $id)
    {
        $allowed = ['fabric_types', 'fabric_colors', 'warehouses', 'proveedores'];
        if (!in_array($table, $allowed, true)) {
            throw new Exception("Tabla no permitida");
        }

        $stmt = $this->db->prepare("SELECT * FROM {$table} WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    private function nextCatalogCode($table)
    {
        $allowed = ['fabric_types', 'fabric_colors'];
        if (!in_array($table, $allowed, true)) {
            throw new Exception("Tabla no permitida");
        }

        $result = $this->db->query("
            SELECT AUTO_INCREMENT
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = '{$table}'
        ");

        $row = $result->fetch_assoc();
        $next = (int) ($row['AUTO_INCREMENT'] ?? 1);

        return str_pad((string) $next, 3, '0', STR_PAD_LEFT);
    }
}
