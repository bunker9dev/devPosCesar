CREATE TABLE role_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,

    role_id INT NOT NULL,
    permission_id INT NOT NULL
);

-- =========================
-- 🔐 RELACIONES
-- =========================

ALTER TABLE role_permissions
ADD CONSTRAINT fk_role_permissions_role
FOREIGN KEY (role_id) REFERENCES roles(id)
ON DELETE CASCADE;

ALTER TABLE role_permissions
ADD CONSTRAINT fk_role_permissions_permission
FOREIGN KEY (permission_id) REFERENCES permissions(id)
ON DELETE CASCADE;

-- =========================
-- ⚡ ÍNDICES PRO
-- =========================

CREATE INDEX idx_role_permissions_role 
ON role_permissions(role_id);

CREATE INDEX idx_role_permissions_permission 
ON role_permissions(permission_id);

-- 🔥 evitar duplicados
CREATE UNIQUE INDEX idx_role_permission_unique 
ON role_permissions(role_id, permission_id);