CREATE TABLE fabric_colors (
    id INT AUTO_INCREMENT PRIMARY KEY,

    codigo VARCHAR(30) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    hex VARCHAR(7) NULL,

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

ALTER TABLE fabric_colors
ADD CONSTRAINT fk_color_created_by
FOREIGN KEY (created_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

ALTER TABLE fabric_colors
ADD CONSTRAINT fk_color_updated_by
FOREIGN KEY (updated_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

ALTER TABLE fabric_colors
ADD CONSTRAINT fk_color_deleted_by
FOREIGN KEY (deleted_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

-- =========================
--  ÍNDICES PRO
-- =========================

-- únicos (ya los tienes)
CREATE UNIQUE INDEX uq_fabric_colors_codigo 
ON fabric_colors(codigo);

CREATE UNIQUE INDEX uq_fabric_colors_nombre 
ON fabric_colors(nombre);

-- rendimiento
CREATE INDEX idx_color_estado ON fabric_colors(estado);
CREATE INDEX idx_color_deleted ON fabric_colors(deleted_at);