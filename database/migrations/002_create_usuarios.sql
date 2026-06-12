CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(100) NULL,
    apellido VARCHAR(100) NULL,
    imagen VARCHAR(255) NULL,

    password VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL,

    estado TINYINT(1) DEFAULT 1,

    -- =========================
    -- 🔥 AUDITORÍA PRO
    -- =========================
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL,

    created_by INT NULL,
    updated_by INT NULL,
    deleted_by INT NULL,

    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,

    ultimo_login DATETIME NULL
);

-- =========================
-- 🔐 RELACIONES
-- =========================

ALTER TABLE usuarios
ADD CONSTRAINT fk_usuario_rol
FOREIGN KEY (rol_id) REFERENCES roles(id);

ALTER TABLE usuarios
ADD CONSTRAINT fk_usuario_created_by
FOREIGN KEY (created_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

ALTER TABLE usuarios
ADD CONSTRAINT fk_usuario_updated_by
FOREIGN KEY (updated_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

ALTER TABLE usuarios
ADD CONSTRAINT fk_usuario_deleted_by
FOREIGN KEY (deleted_by) REFERENCES usuarios(id)
ON DELETE SET NULL;

-- =========================
-- ⚡ ÍNDICES (RENDIMIENTO)
-- =========================

CREATE INDEX idx_usuario_rol_id ON usuarios(rol_id);
CREATE INDEX idx_usuario_estado ON usuarios(estado);
CREATE INDEX idx_usuario_deleted_at ON usuarios(deleted_at);