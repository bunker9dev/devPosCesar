<?php

namespace App\Modules\Purchases\Models;

use Exception;

class PedidoModel
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
                pe.*,
                s.nombre AS proveedor_nombre,
                COUNT(pi.id) AS cantidad_items,
                CASE
                    WHEN pe.estado = 'aprobado' AND pe.approved_at IS NOT NULL
                    THEN DATEDIFF(NOW(), pe.approved_at)
                    ELSE NULL
                END AS dias_abierto
            FROM pedidos pe
            JOIN proveedores s ON s.id = pe.supplier_id
            LEFT JOIN pedido_items pi ON pi.pedido_id = pe.id
        ";

        if (!$includeDeleted) {
            $sql .= " WHERE pe.deleted_at IS NULL";
        }

        $sql .= " GROUP BY pe.id ORDER BY pe.id DESC";

        $result = $this->db->query($sql);

        if (!$result) {
            throw new Exception("Error al obtener pedidos");
        }

        $rows = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($rows as &$r) {
            $r['vencido'] = $r['estado'] === 'aprobado' && (int)$r['dias_abierto'] >= 7;
        }

        return $rows;
    }

    public function find($id)
    {
        $stmt = $this->db->prepare("
            SELECT
                pe.*,
                s.nombre AS proveedor_nombre,
                CASE
                    WHEN pe.estado = 'aprobado' AND pe.approved_at IS NOT NULL
                    THEN DATEDIFF(NOW(), pe.approved_at)
                    ELSE NULL
                END AS dias_abierto
            FROM pedidos pe
            JOIN proveedores s ON s.id = pe.supplier_id
            WHERE pe.id = ?
        ");

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();

        if ($row) {
            $row['vencido'] = $row['estado'] === 'aprobado' && (int)$row['dias_abierto'] >= 7;
            $row['items'] = $this->getItems($id);
            $row['purchases_vinculadas'] = $this->getLinkedPurchases($id);
        }

        return $row;
    }

    public function getLastCode()
    {
        $result = $this->db->query("SELECT consecutivo FROM pedidos ORDER BY id DESC LIMIT 1");
        $row = $result->fetch_assoc();

        return $row['consecutivo'] ?? null;
    }

    // ======================================================
    // ITEMS
    // ======================================================
    public function getItems($pedidoId)
    {
        $stmt = $this->db->prepare("
            SELECT
                pi.*,
                t.nombre AS tipo_nombre,
                c.nombre AS color_nombre
            FROM pedido_items pi
            JOIN fabric_types t ON t.id = pi.fabric_type_id
            JOIN fabric_colors c ON c.id = pi.fabric_color_id
            WHERE pi.pedido_id = ?
        ");

        $stmt->bind_param("i", $pedidoId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ======================================================
    // CREAR
    // ======================================================
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO pedidos (consecutivo, supplier_id, fecha_solicitud, observaciones, estado, created_by, created_at)
            VALUES (?, ?, ?, ?, 'borrador', ?, NOW())
        ");

        $stmt->bind_param(
            "sissi",
            $data['consecutivo'],
            $data['supplier_id'],
            $data['fecha_solicitud'],
            $data['observaciones'],
            $data['user_id']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al crear pedido: " . $stmt->error);
        }

        return $stmt->insert_id;
    }

    public function createItem($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO pedido_items (pedido_id, fabric_type_id, fabric_color_id, cantidad, unidad, nota)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "iiidss",
            $data['pedido_id'],
            $data['fabric_type_id'],
            $data['fabric_color_id'],
            $data['cantidad'],
            $data['unidad'],
            $data['nota']
        );

        if (!$stmt->execute()) {
            throw new Exception("Error al crear ítem del pedido: " . $stmt->error);
        }

        return $stmt->insert_id;
    }

    // ======================================================
    // ESTADOS
    // ======================================================
    public function approve($id, $userId)
    {
        $stmt = $this->db->prepare("
            UPDATE pedidos
            SET estado = 'aprobado', approved_by = ?, approved_at = NOW(), updated_by = ?, updated_at = NOW()
            WHERE id = ?
        ");

        $stmt->bind_param("iii", $userId, $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al aprobar pedido");
        }

        return true;
    }

    public function updateEstado($id, $estado, $userId)
    {
        $stmt = $this->db->prepare("
            UPDATE pedidos SET estado = ?, updated_by = ?, updated_at = NOW() WHERE id = ?
        ");

        $stmt->bind_param("sii", $estado, $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar estado del pedido");
        }

        return true;
    }

    // ======================================================
    // ELIMINAR / RESTAURAR
    // ======================================================
    public function delete($id, $userId)
    {
        $stmt = $this->db->prepare("UPDATE pedidos SET deleted_at = NOW(), deleted_by = ? WHERE id = ?");
        $stmt->bind_param("ii", $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar pedido");
        }

        return true;
    }

    public function restore($id, $userId)
    {
        $stmt = $this->db->prepare("UPDATE pedidos SET deleted_at = NULL, deleted_by = NULL, updated_by = ? WHERE id = ?");
        $stmt->bind_param("ii", $userId, $id);

        if (!$stmt->execute()) {
            throw new Exception("Error al restaurar pedido");
        }

        return true;
    }

    // ======================================================
    // VINCULACIÓN CON COMPRAS
    // ======================================================
    public function getLinkedPurchases($pedidoId)
    {
        $stmt = $this->db->prepare("
            SELECT pu.id, pu.numero_documento, pu.fecha
            FROM purchase_pedido_links lk
            JOIN purchases pu ON pu.id = lk.purchase_id
            WHERE lk.pedido_id = ? AND pu.deleted_at IS NULL
        ");

        $stmt->bind_param("i", $pedidoId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAprobadosBySupplier($supplierId)
    {
        $stmt = $this->db->prepare("
            SELECT id, consecutivo, fecha_solicitud
            FROM pedidos
            WHERE supplier_id = ? AND estado = 'aprobado' AND deleted_at IS NULL
            ORDER BY fecha_solicitud ASC
        ");

        $stmt->bind_param("i", $supplierId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function linkToPurchase($purchaseId, $pedidoId, $userId)
    {
        $stmt = $this->db->prepare("
            INSERT INTO purchase_pedido_links (purchase_id, pedido_id, created_by)
            VALUES (?, ?, ?)
        ");

        $stmt->bind_param("iii", $purchaseId, $pedidoId, $userId);
        $stmt->execute();

        return true;
    }

    // ======================================================
    // CONTADOR PARA EL SIDEBAR
    // ======================================================
    public function countVencidos()
    {
        $result = $this->db->query("
            SELECT COUNT(*) AS total
            FROM pedidos
            WHERE estado = 'aprobado'
              AND deleted_at IS NULL
              AND DATEDIFF(NOW(), approved_at) >= 7
        ");

        return (int)$result->fetch_assoc()['total'];
    }
}