<?php

namespace App\Modules\Purchases\Models;

use Exception;

class PurchaseModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // ======================================================
    // LISTAR
    // ======================================================
    public function getAll($includeDeleted = false)
    {
        $sql = "
        SELECT
            pu.*,
            s.nombre AS proveedor_nombre,
            COALESCE(lotes.total_compra, 0) AS total,
            COALESCE(pagos.total_pagado, 0) AS total_pagado
        FROM purchases pu
        JOIN proveedores s ON s.id = pu.supplier_id
        LEFT JOIN (
            SELECT rl.purchase_id,
                   SUM(rl.metraje_por_rollo * r.cnt * rl.precio_compra) AS total_compra
            FROM roll_lotes rl
            JOIN (
                SELECT lote_id, COUNT(*) AS cnt FROM rolls GROUP BY lote_id
            ) r ON r.lote_id = rl.id
            WHERE rl.precio_compra IS NOT NULL
            GROUP BY rl.purchase_id
        ) lotes ON lotes.purchase_id = pu.id
        LEFT JOIN (
            SELECT purchase_id, SUM(monto) AS total_pagado
            FROM purchase_payments
            WHERE deleted_at IS NULL
            GROUP BY purchase_id
        ) pagos ON pagos.purchase_id = pu.id
    ";

        if (!$includeDeleted) {
            $sql .= " WHERE pu.deleted_at IS NULL";
        }

        $sql .= " ORDER BY pu.id DESC";

        $result = $this->db->query($sql);

        if (!$result) {
            throw new Exception("Error al obtener compras");
        }

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($rows as &$r) {
            $r['saldo_pendiente'] = round((float)$r['total'] - (float)$r['total_pagado'], 2);
        }

        return $rows;
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM purchases WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function findWithSaldo($id)
    {
        $stmt = $this->db->prepare("
        SELECT
            pu.*,
            s.nombre AS proveedor_nombre,
            COALESCE(lotes.total_compra, 0) AS total,
            COALESCE(pagos.total_pagado, 0) AS total_pagado
        FROM purchases pu
        JOIN proveedores s ON s.id = pu.supplier_id
        LEFT JOIN (
            SELECT rl.purchase_id,
                   SUM(rl.metraje_por_rollo * r.cnt * rl.precio_compra) AS total_compra
            FROM roll_lotes rl
            JOIN (
                SELECT lote_id, COUNT(*) AS cnt FROM rolls GROUP BY lote_id
            ) r ON r.lote_id = rl.id
            WHERE rl.precio_compra IS NOT NULL
            GROUP BY rl.purchase_id
        ) lotes ON lotes.purchase_id = pu.id
        LEFT JOIN (
            SELECT purchase_id, SUM(monto) AS total_pagado
            FROM purchase_payments
            WHERE deleted_at IS NULL
            GROUP BY purchase_id
        ) pagos ON pagos.purchase_id = pu.id
        WHERE pu.id = ?
    ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();

        if ($row) {
            $row['saldo_pendiente'] = round((float)$row['total'] - (float)$row['total_pagado'], 2);
        }

        return $row;
    }

    public function existsDocumento($numeroDocumento, $supplierId, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->db->prepare("
                SELECT id FROM purchases
                WHERE numero_documento = ? AND supplier_id = ? AND id != ?
            ");
            $stmt->bind_param("sii", $numeroDocumento, $supplierId, $excludeId);
        } else {
            $stmt = $this->db->prepare("
                SELECT id FROM purchases
                WHERE numero_documento = ? AND supplier_id = ?
            ");
            $stmt->bind_param("si", $numeroDocumento, $supplierId);
        }

        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    // ======================================================
    // CREAR
    // ======================================================
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO purchases
            (supplier_id, numero_documento, fecha, condicion_pago, plazo_dias, fecha_vencimiento,
             total, observaciones, estado, created_by, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param(
            "isssisdssi",
            $data['supplier_id'],
            $data['numero_documento'],
            $data['fecha'],
            $data['condicion_pago'],
            $data['plazo_dias'],
            $data['fecha_vencimiento'],
            $data['total'],
            $data['observaciones'],
            $data['estado'],
            $data['user_id']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al crear compra: " . $stmt->error);
        }

        return $stmt->insert_id;
    }

    // ======================================================
    // ACTUALIZAR
    // ======================================================
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE purchases
            SET supplier_id = ?, numero_documento = ?, fecha = ?, condicion_pago = ?,
                plazo_dias = ?, fecha_vencimiento = ?, observaciones = ?,
                updated_by = ?, updated_at = NOW()
            WHERE id = ?
        ");

        $stmt->bind_param(
            "isssissii",
            $data['supplier_id'],
            $data['numero_documento'],
            $data['fecha'],
            $data['condicion_pago'],
            $data['plazo_dias'],
            $data['fecha_vencimiento'],
            $data['observaciones'],
            $data['user_id'],
            $id
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar compra: " . $stmt->error);
        }

        return true;
    }


    public function updateEstado($id, $estado, $userId)
    {
        $stmt = $this->db->prepare("
            UPDATE purchases SET estado = ?, updated_by = ?, updated_at = NOW() WHERE id = ?
        ");

        $stmt->bind_param("sii", $estado, $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar estado");
        }

        return true;
    }

    // ======================================================
    // ELIMINAR / RESTAURAR
    // ======================================================
    public function delete($id, $userId)
    {
        $stmt = $this->db->prepare("
            UPDATE purchases SET deleted_at = NOW(), deleted_by = ?, estado = 'anulada' WHERE id = ?
        ");

        $stmt->bind_param("ii", $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar compra");
        }

        return true;
    }

    public function restore($id, $userId)
    {
        $stmt = $this->db->prepare("
            UPDATE purchases SET deleted_at = NULL, deleted_by = NULL, updated_by = ?, estado = 'abierta'
            WHERE id = ?
        ");

        $stmt->bind_param("ii", $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al restaurar compra");
        }

        return true;
    }

    // ======================================================
    // PAGOS
    // ======================================================
    public function getPayments($purchaseId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM purchase_payments
            WHERE purchase_id = ? AND deleted_at IS NULL
            ORDER BY fecha_pago ASC, id ASC
        ");

        $stmt->bind_param("i", $purchaseId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function createPayment($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO purchase_payments
            (purchase_id, fecha_pago, monto, metodo_pago, referencia, nota, created_by, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param(
            "isdsssi",
            $data['purchase_id'],
            $data['fecha_pago'],
            $data['monto'],
            $data['metodo_pago'],
            $data['referencia'],
            $data['nota'],
            $data['user_id']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al registrar pago: " . $stmt->error);
        }

        return $stmt->insert_id;
    }

    public function getTotalPagado($purchaseId)
    {
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(monto), 0) AS total
            FROM purchase_payments
            WHERE purchase_id = ? AND deleted_at IS NULL
        ");

        $stmt->bind_param("i", $purchaseId);
        $stmt->execute();

        return (float)$stmt->get_result()->fetch_assoc()['total'];
    }

    // ======================================================
    // ROLLOS / LOTES ASOCIADOS A LA COMPRA
    // ======================================================
    public function getLotesByPurchase($purchaseId)
    {
        $stmt = $this->db->prepare("
            SELECT
                l.*,
                t.nombre AS tipo_nombre,
                c.nombre AS color_nombre,
                COUNT(r.id) AS cantidad_rollos
            FROM roll_lotes l
            JOIN fabric_types t ON t.id = l.fabric_type_id
            JOIN fabric_colors c ON c.id = l.fabric_color_id
            LEFT JOIN rolls r ON r.lote_id = l.id
            WHERE l.purchase_id = ?
            GROUP BY l.id
        ");

        $stmt->bind_param("i", $purchaseId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ======================================================
    // DROPDOWN DE PROVEEDORES
    // ======================================================
    public function getActiveSuppliers()
    {
        $result = $this->db->query("SELECT id, nombre, nit FROM proveedores WHERE estado != 0 ORDER BY nombre");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
