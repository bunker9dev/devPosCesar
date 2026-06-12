CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,

    usuario_id INT NULL,

    accion VARCHAR(50) NOT NULL,
    entidad VARCHAR(100) NOT NULL,
    entidad_id INT NULL,

    modulo VARCHAR(80) NOT NULL DEFAULT 'general',

    detalle LONGTEXT NULL,

    ip VARCHAR(45) NULL,
    user_agent TEXT NULL,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL
);

-- =========================
-- 🔐 RELACIONES
-- =========================

ALTER TABLE audit_logs
ADD CONSTRAINT fk_audit_usuario
FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
ON DELETE SET NULL;

-- =========================
-- ⚡ ÍNDICES PRO
-- =========================

-- por usuario
CREATE INDEX idx_audit_usuario 
ON audit_logs(usuario_id);

-- 🔥 índice compuesto clave
CREATE INDEX idx_audit_entidad 
ON audit_logs(entidad, entidad_id);

-- por módulo
CREATE INDEX idx_audit_modulo 
ON audit_logs(modulo);

-- por fecha
CREATE INDEX idx_audit_fecha 
ON audit_logs(created_at);

-- 🔥 índice avanzado para historial
CREATE INDEX idx_audit_full_lookup 
ON audit_logs(entidad, entidad_id, created_at);