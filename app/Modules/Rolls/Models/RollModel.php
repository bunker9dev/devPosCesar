<?php

namespace App\Modules\Rolls\Models;

use Exception;

class RollModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // ======================================================
    // LISTAR LOTES (vista principal)
    // ======================================================
    public function getAllLotes($includeDeleted = false)
    {
        $sql = "
        SELECT
            l.*,
            t.nombre AS tipo_nombre,
            c.nombre AS color_nombre,
            s.nombre AS proveedor_nombre,
            w.nombre AS bodega_nombre,
            COUNT(r.id) AS cantidad_rollos,
            MIN(r.metraje_actual) AS metraje_actual_rollo
        FROM roll_lotes l
        JOIN fabric_types t ON t.id = l.fabric_type_id
        JOIN fabric_colors c ON c.id = l.fabric_color_id
        JOIN proveedores s ON s.id = l.supplier_id
        JOIN warehouses w ON w.id = l.warehouse_id
        LEFT JOIN rolls r ON r.lote_id = l.id
    ";

        if (!$includeDeleted) {
            $sql .= " WHERE l.deleted_at IS NULL";
        }

        $sql .= " GROUP BY l.id ORDER BY l.id DESC";

        $result = $this->db->query($sql);

        if (!$result) {
            throw new Exception("Error al obtener lotes");
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findLote($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM roll_lotes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function findLoteByCodigo($codigo)
    {
        $stmt = $this->db->prepare("SELECT * FROM roll_lotes WHERE codigo = ? LIMIT 1");
        $stmt->bind_param("s", $codigo);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function countRollsInLote($loteId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM rolls WHERE lote_id = ?");
        $stmt->bind_param("i", $loteId);
        $stmt->execute();

        return (int)$stmt->get_result()->fetch_assoc()['total'];
    }

    public function getRollsByLote($loteId)
    {
        $stmt = $this->db->prepare("SELECT * FROM rolls WHERE lote_id = ? ORDER BY id ASC");
        $stmt->bind_param("i", $loteId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ======================================================
    // CREAR / ACTUALIZAR / BORRAR / RESTAURAR LOTE
    // ======================================================
    public function createLote($data)
    {
        $stmt = $this->db->prepare("
        INSERT INTO roll_lotes
        (codigo, fabric_type_id, fabric_color_id, supplier_id, warehouse_id, fecha_compra, metraje_por_rollo, precio_compra, created_by, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

        $stmt->bind_param(
            "siiiisddi",
            $data['codigo'],
            $data['fabric_type_id'],
            $data['fabric_color_id'],
            $data['supplier_id'],
            $data['warehouse_id'],
            $data['fecha_compra'],
            $data['metraje_por_rollo'],
            $data['precio_compra'],
            $data['user_id']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al crear lote: " . $stmt->error);
        }

        return $stmt->insert_id;
    }

    public function updateLote($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE roll_lotes
            SET warehouse_id = ?, precio_compra = ?, updated_by = ?, updated_at = NOW()
            WHERE id = ?
        ");

        $stmt->bind_param("idii", $data['warehouse_id'], $data['precio_compra'], $data['user_id'], $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar lote: " . $stmt->error);
        }

        $stmt2 = $this->db->prepare("UPDATE rolls SET warehouse_id = ?, updated_by = ? WHERE lote_id = ?");
        $stmt2->bind_param("iii", $data['warehouse_id'], $data['user_id'], $id);
        $stmt2->execute();

        return true;
    }

    public function deleteLote($id, $userId)
    {
        $stmt = $this->db->prepare("UPDATE roll_lotes SET deleted_at = NOW(), deleted_by = ? WHERE id = ?");
        $stmt->bind_param("ii", $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar lote");
        }

        $stmt2 = $this->db->prepare("UPDATE rolls SET deleted_at = NOW(), deleted_by = ?, estado = 0 WHERE lote_id = ?");
        $stmt2->bind_param("ii", $userId, $id);
        $stmt2->execute();

        return true;
    }

    public function restoreLote($id, $userId)
    {
        $stmt = $this->db->prepare("UPDATE roll_lotes SET deleted_at = NULL, deleted_by = NULL, updated_by = ? WHERE id = ?");
        $stmt->bind_param("ii", $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al restaurar lote");
        }

        $stmt2 = $this->db->prepare("UPDATE rolls SET deleted_at = NULL, deleted_by = NULL, estado = 1, updated_by = ? WHERE lote_id = ?");
        $stmt2->bind_param("ii", $userId, $id);
        $stmt2->execute();

        return true;
    }

    // ======================================================
    // CREAR ROLLO INDIVIDUAL
    // ======================================================
    public function createRoll($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO rolls
            (lote_id, codigo, codigo_barra, fabric_type_id, fabric_color_id, supplier_id, warehouse_id, fecha_compra,
             metraje_inicial, metraje_actual, precio_compra, estado, created_by, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?, NOW())
        ");

        $stmt->bind_param(
            "issiiiisdddi",
            $data['lote_id'],
            $data['codigo'],
            $data['codigo_barra'],
            $data['fabric_type_id'],
            $data['fabric_color_id'],
            $data['supplier_id'],
            $data['warehouse_id'],
            $data['fecha_compra'],
            $data['metraje_inicial'],
            $data['metraje_inicial'],
            $data['precio_compra'],
            $data['user_id']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al crear rollo: " . $stmt->error);
        }

        return $stmt->insert_id;
    }

    // ======================================================
    // CÓDIGOS DE CATÁLOGO (para armar el código del lote)
    // ======================================================
    public function getFabricTypeCodigo($id)
    {
        $stmt = $this->db->prepare("SELECT codigo FROM fabric_types WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        return $row['codigo'] ?? null;
    }

    public function getFabricColorCodigo($id)
    {
        $stmt = $this->db->prepare("SELECT codigo FROM fabric_colors WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        return $row['codigo'] ?? null;
    }

    // ======================================================
    // DROPDOWNS PARA EL FORMULARIO
    // ======================================================
    public function getActiveFabricTypes()
    {
        $result = $this->db->query("SELECT id, codigo, nombre FROM fabric_types WHERE estado != 0 ORDER BY nombre");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getActiveFabricColors()
    {
        $result = $this->db->query("SELECT id, codigo, nombre FROM fabric_colors WHERE estado != 0 ORDER BY nombre");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getActiveSuppliers()
    {
        $result = $this->db->query("SELECT id, nombre FROM proveedores WHERE estado != 0 ORDER BY nombre");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getActiveWarehouses()
    {
        $result = $this->db->query("SELECT id, nombre FROM warehouses WHERE estado != 0 ORDER BY nombre");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateLoteFull($id, $data)
    {
        $stmt = $this->db->prepare("
        UPDATE roll_lotes
        SET codigo = ?, fabric_type_id = ?, fabric_color_id = ?, supplier_id = ?,
            warehouse_id = ?, fecha_compra = ?, metraje_por_rollo = ?, precio_compra = ?,
            updated_by = ?, updated_at = NOW()
        WHERE id = ?
    ");

        $stmt->bind_param(
            "siiiisddii",
            $data['codigo'],
            $data['fabric_type_id'],
            $data['fabric_color_id'],
            $data['supplier_id'],
            $data['warehouse_id'],
            $data['fecha_compra'],
            $data['metraje_por_rollo'],
            $data['precio_compra'],
            $data['user_id'],
            $id
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar lote: " . $stmt->error);
        }

        return true;
    }

    // ======================================================
    // ROLLOS INDIVIDUALES 
    // ======================================================

    public function updateRollsForLote($loteId, $data)
    {
        $rolls = $this->getRollsByLote($loteId);

        foreach ($rolls as $r) {
            $consecutivo = substr($r['codigo'], -4); // últimos 4 dígitos = consecutivo del rollo
            $nuevoCodigo = $data['codigo'] . $consecutivo;

            $stmt = $this->db->prepare("
            UPDATE rolls
            SET codigo = ?, codigo_barra = ?, fabric_type_id = ?, fabric_color_id = ?,
                supplier_id = ?, warehouse_id = ?, fecha_compra = ?,
                metraje_inicial = ?, metraje_actual = ?, precio_compra = ?,
                updated_by = ?, updated_at = NOW()
            WHERE id = ?
        ");

            $stmt->bind_param(
                "ssiiiisdddii",
                $nuevoCodigo,
                $nuevoCodigo,
                $data['fabric_type_id'],
                $data['fabric_color_id'],
                $data['supplier_id'],
                $data['warehouse_id'],
                $data['fecha_compra'],
                $data['metraje_por_rollo'],
                $data['metraje_por_rollo'],
                $data['precio_compra'],
                $data['user_id'],
                $r['id']
            );

            $stmt->execute();
        }

        return true;
    }

    public function hasRollsUsed($loteId)
    {
        $rolls = $this->getRollsByLote($loteId);

        foreach ($rolls as $r) {
            if ((float)$r['metraje_actual'] !== (float)$r['metraje_inicial']) {
                return true;
            }
        }

        return false;
    }

    public function getAllIndividual($includeDeleted = false)
    {
        $sql = "
        SELECT
            r.*,
            l.codigo AS lote_codigo,
            t.nombre AS tipo_nombre,
            c.nombre AS color_nombre,
            s.nombre AS proveedor_nombre,
            w.nombre AS bodega_nombre
        FROM rolls r
        JOIN roll_lotes l ON l.id = r.lote_id
        JOIN fabric_types t ON t.id = r.fabric_type_id
        JOIN fabric_colors c ON c.id = r.fabric_color_id
        JOIN proveedores s ON s.id = r.supplier_id
        JOIN warehouses w ON w.id = r.warehouse_id
    ";

        if (!$includeDeleted) {
            $sql .= " WHERE r.deleted_at IS NULL";
        }

        $sql .= " ORDER BY r.lote_id DESC, r.id ASC";

        $result = $this->db->query($sql);

        if (!$result) {
            throw new Exception("Error al obtener rollos individuales");
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
