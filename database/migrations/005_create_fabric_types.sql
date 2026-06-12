CREATE TABLE fabric_types (
    id INT AUTO_INCREMENT PRIMARY KEY,

    codigo VARCHAR(30) NOT NULL,
    nombre VARCHAR(100) NOT NULL,

    estado TINYINT(1) DEFAULT 1,

    -- =========================
    --  AUDITORÍA PRO
    -- =========================
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    deleted_at DATETIME NULL DEFAULT NULL,

    created_by INT NULL,
    updated_by INT NULL,
    deleted_by INT NULL
);

-- =========================
--  RELACIONES
-- =========================

ALTER TABLE fabric_types
ADD CONSTRAINT fk_type_created_by
FOREIGN KEY (created_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

ALTER TABLE fabric_types
ADD CONSTRAINT fk_type_updated_by
FOREIGN KEY (updated_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

ALTER TABLE fabric_types
ADD CONSTRAINT fk_type_deleted_by
FOREIGN KEY (deleted_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

-- =========================
--  ÍNDICES
-- =========================

-- únicos 
CREATE UNIQUE INDEX uq_fabric_types_codigo 
ON fabric_types(codigo);

CREATE UNIQUE INDEX uq_fabric_types_nombre 
ON fabric_types(nombre);

-- rendimiento
CREATE INDEX idx_type_estado ON fabric_types(estado);
CREATE INDEX idx_type_deleted ON fabric_types(deleted_at);