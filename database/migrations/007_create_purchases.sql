CREATE TABLE `purchases` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,

  -- =========================
  -- 🔗 RELACIÓN
  -- =========================
  `supplier_id` INT(11) NOT NULL,

  -- =========================
  -- 📄 DOCUMENTO
  -- =========================
  `numero_documento` VARCHAR(80) NOT NULL,
  `fecha` DATE NOT NULL,
  `total` DECIMAL(14,2) NOT NULL DEFAULT 0.00,

  -- =========================
  -- 🔥 ESTADO FLEXIBLE
  -- =========================
  `estado` VARCHAR(20) NOT NULL DEFAULT 'abierta',

  -- =========================
  -- 🔐 AUDITORÍA PRO
  -- =========================
  `created_by` INT(11) NULL,
  `updated_by` INT(11) NULL,
  `deleted_by` INT(11) NULL,

  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME NULL DEFAULT NULL,

  -- =========================
  -- 🧱 PRIMARY KEY
  -- =========================
  PRIMARY KEY (`id`),

  -- =========================
  -- 🔥 CONTROL DE DUPLICADOS
  -- =========================
  UNIQUE KEY `uq_purchase_doc_supplier` (`numero_documento`, `supplier_id`),

  -- =========================
  -- ⚡ ÍNDICES
  -- =========================
  KEY `idx_purchases_supplier` (`supplier_id`),
  KEY `idx_purchases_estado` (`estado`),
  KEY `idx_purchases_fecha` (`fecha`),
  KEY `idx_purchases_deleted` (`deleted_at`),

  -- =========================
  -- 🔐 FOREIGN KEYS
  -- =========================
  CONSTRAINT `fk_purchases_supplier`
    FOREIGN KEY (`supplier_id`) REFERENCES `proveedores` (`id`),

  CONSTRAINT `fk_purchases_created_by`
    FOREIGN KEY (`created_by`) REFERENCES `usuarios` (`id`)
    ON DELETE SET NULL,

  CONSTRAINT `fk_purchases_updated_by`
    FOREIGN KEY (`updated_by`) REFERENCES `usuarios` (`id`)
    ON DELETE SET NULL,

  CONSTRAINT `fk_purchases_deleted_by`
    FOREIGN KEY (`deleted_by`) REFERENCES `usuarios` (`id`)
    ON DELETE SET NULL

) ENGINE=InnoDB 
DEFAULT CHARSET=utf8mb4 
COLLATE=utf8mb4_unicode_ci;