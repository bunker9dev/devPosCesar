CREATE TABLE inventory_movements (
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- =========================
    -- 🔗 RELACIONES
    -- =========================
    roll_id INT NOT NULL,

    -- =========================
    -- 🔥 TIPO DE MOVIMIENTO
    -- =========================
    tipo VARCHAR(20) NOT NULL, 
    -- entrada | salida | ajuste | traslado

    -- =========================
    -- 📏 DATOS DEL MOVIMIENTO
    -- =========================
    metros DECIMAL(10,2) NOT NULL,
    precio DECIMAL(14,2) NULL,

    -- =========================
    -- 🏬 BODEGAS
    -- =========================
    warehouse_origen_id INT NULL,
    warehouse_destino_id INT NULL,

    -- =========================
    -- 🔗 REFERENCIAS
    -- =========================
    purchase_id INT NULL,
    referencia_id INT NULL,

    -- =========================
    -- 📝 DETALLE
    -- =========================
    nota VARCHAR(255) NULL,

    -- =========================
    -- 🔐 AUDITORÍA PRO
    -- =========================
    created_by INT NOT NULL,
    updated_by INT NULL,
    deleted_by INT NULL,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL,

    -- =========================
    -- 🔐 FOREIGN KEYS
    -- =========================
    CONSTRAINT fk_mov_roll
        FOREIGN KEY (roll_id) REFERENCES rolls(id),

    CONSTRAINT fk_mov_warehouse_origen
        FOREIGN KEY (warehouse_origen_id) REFERENCES warehouses(id)
        ON DELETE SET NULL,

    CONSTRAINT fk_mov_warehouse_destino
        FOREIGN KEY (warehouse_destino_id) REFERENCES warehouses(id)
        ON DELETE SET NULL,

    CONSTRAINT fk_mov_purchase
        FOREIGN KEY (purchase_id) REFERENCES purchases(id)
        ON DELETE SET NULL,

    CONSTRAINT fk_mov_created_by
        FOREIGN KEY (created_by) REFERENCES usuarios(id),

    CONSTRAINT fk_mov_updated_by
        FOREIGN KEY (updated_by) REFERENCES usuarios(id)
        ON DELETE SET NULL,

    CONSTRAINT fk_mov_deleted_by
        FOREIGN KEY (deleted_by) REFERENCES usuarios(id)
        ON DELETE SET NULL

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

-- =========================
-- ⚡ ÍNDICES PRO
-- =========================

CREATE INDEX idx_mov_roll 
ON inventory_movements(roll_id);

CREATE INDEX idx_mov_tipo 
ON inventory_movements(tipo);

CREATE INDEX idx_mov_fecha 
ON inventory_movements(created_at);

CREATE INDEX idx_mov_roll_fecha 
ON inventory_movements(roll_id, created_at);

CREATE INDEX idx_mov_warehouse_origen 
ON inventory_movements(warehouse_origen_id);

CREATE INDEX idx_mov_warehouse_destino 
ON inventory_movements(warehouse_destino_id);

CREATE INDEX idx_mov_purchase 
ON inventory_movements(purchase_id);

CREATE INDEX idx_mov_referencia 
ON inventory_movements(referencia_id);

CREATE INDEX idx_mov_deleted 
ON inventory_movements(deleted_at);