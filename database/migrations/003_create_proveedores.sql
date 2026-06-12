CREATE TABLE proveedores (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nombre VARCHAR(150) NOT NULL,
    contacto VARCHAR(300) NULL,

    nit VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NULL,
    telefono VARCHAR(30) NULL,
    ciudad VARCHAR(100) NULL,

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

ALTER TABLE proveedores
ADD CONSTRAINT fk_proveedor_created_by
FOREIGN KEY (created_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

ALTER TABLE proveedores
ADD CONSTRAINT fk_proveedor_updated_by
FOREIGN KEY (updated_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

ALTER TABLE proveedores
ADD CONSTRAINT fk_proveedor_deleted_by
FOREIGN KEY (deleted_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

-- =========================
-- ⚡ ÍNDICES PRO
-- =========================

CREATE INDEX idx_proveedor_estado ON proveedores(estado);
CREATE INDEX idx_proveedor_ciudad ON proveedores(ciudad);
CREATE INDEX idx_proveedor_deleted ON proveedores(deleted_at);