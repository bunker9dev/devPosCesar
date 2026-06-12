CREATE TABLE warehouses (
    id INT AUTO_INCREMENT PRIMARY KEY,

    codigo VARCHAR(30) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,

    ubicacion VARCHAR(150) NULL,
    descripcion VARCHAR(255) NULL,

    estado TINYINT(1) DEFAULT 1,

    -- =========================
    -- 🔥 AUDITORÍA PRO
    -- =========================
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL DEFAULT NULL,

    created_by INT NULL,
    updated_by INT NULL,
    deleted_by INT NULL
);

-- =========================
-- 🔐 RELACIONES
-- =========================

ALTER TABLE warehouses
ADD CONSTRAINT fk_warehouse_created_by
FOREIGN KEY (created_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

ALTER TABLE warehouses
ADD CONSTRAINT fk_warehouse_updated_by
FOREIGN KEY (updated_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

ALTER TABLE warehouses
ADD CONSTRAINT fk_warehouse_deleted_by
FOREIGN KEY (deleted_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

-- =========================
-- ⚡ ÍNDICES
-- =========================

CREATE INDEX idx_warehouse_estado 
ON warehouses(estado);

CREATE INDEX idx_warehouse_deleted 
ON warehouses(deleted_at);

CREATE INDEX idx_warehouse_nombre 
ON warehouses(nombre);