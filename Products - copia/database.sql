CREATE TABLE IF NOT EXISTS fabric_types (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(30) NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  estado TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_fabric_types_codigo (codigo),
  UNIQUE KEY uq_fabric_types_nombre (nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS fabric_colors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(30) NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  hex VARCHAR(7) DEFAULT NULL,
  estado TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_fabric_colors_codigo (codigo),
  UNIQUE KEY uq_fabric_colors_nombre (nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fabric_type_id INT NOT NULL,
  fabric_color_id INT NOT NULL,
  nombre VARCHAR(180) NOT NULL,
  estado TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_products_type_color (fabric_type_id, fabric_color_id),
  CONSTRAINT fk_products_type FOREIGN KEY (fabric_type_id) REFERENCES fabric_types(id),
  CONSTRAINT fk_products_color FOREIGN KEY (fabric_color_id) REFERENCES fabric_colors(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS warehouses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(30) NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  estado TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_warehouses_codigo (codigo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS purchases (
  id INT AUTO_INCREMENT PRIMARY KEY,
  supplier_id INT DEFAULT NULL,
  numero_documento VARCHAR(80) DEFAULT NULL,
  fecha DATE NOT NULL,
  total DECIMAL(14,2) NOT NULL DEFAULT 0,
  usuario_id INT NOT NULL,
  estado ENUM('abierta','cerrada','anulada') NOT NULL DEFAULT 'cerrada',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY idx_purchases_supplier (supplier_id),
  KEY idx_purchases_usuario (usuario_id),
  CONSTRAINT fk_purchases_supplier FOREIGN KEY (supplier_id) REFERENCES proveedores(id),
  CONSTRAINT fk_purchases_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS rolls (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  fabric_type_id INT NOT NULL,
  fabric_color_id INT NOT NULL,
  supplier_id INT NOT NULL,
  purchase_id INT DEFAULT NULL,
  warehouse_id INT NOT NULL,
  codigo_barra VARCHAR(30) NOT NULL,
  codigo_visible VARCHAR(60) NOT NULL,
  metros DECIMAL(10,2) NOT NULL,
  centimetros INT NOT NULL,
  precio_compra DECIMAL(14,2) NOT NULL,
  estado ENUM('activo','agotado','retenido','eliminado') NOT NULL DEFAULT 'activo',
  created_by INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_rolls_codigo_barra (codigo_barra),
  KEY idx_rolls_codigo_visible (codigo_visible),
  KEY idx_rolls_warehouse_estado (warehouse_id, estado),
  KEY idx_rolls_product (product_id),
  CONSTRAINT fk_rolls_product FOREIGN KEY (product_id) REFERENCES products(id),
  CONSTRAINT fk_rolls_type FOREIGN KEY (fabric_type_id) REFERENCES fabric_types(id),
  CONSTRAINT fk_rolls_color FOREIGN KEY (fabric_color_id) REFERENCES fabric_colors(id),
  CONSTRAINT fk_rolls_supplier FOREIGN KEY (supplier_id) REFERENCES proveedores(id),
  CONSTRAINT fk_rolls_purchase FOREIGN KEY (purchase_id) REFERENCES purchases(id),
  CONSTRAINT fk_rolls_warehouse FOREIGN KEY (warehouse_id) REFERENCES warehouses(id),
  CONSTRAINT fk_rolls_created_by FOREIGN KEY (created_by) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS inventory_movements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  roll_id INT NOT NULL,
  tipo ENUM('entrada','salida','devolucion','ajuste','traslado') NOT NULL,
  metros DECIMAL(10,2) NOT NULL,
  precio DECIMAL(14,2) DEFAULT NULL,
  warehouse_origin_id INT DEFAULT NULL,
  warehouse_destination_id INT DEFAULT NULL,
  usuario_id INT NOT NULL,
  nota VARCHAR(255) DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY idx_movements_roll (roll_id),
  KEY idx_movements_tipo (tipo),
  KEY idx_movements_origin (warehouse_origin_id),
  KEY idx_movements_destination (warehouse_destination_id),
  CONSTRAINT fk_movements_roll FOREIGN KEY (roll_id) REFERENCES rolls(id),
  CONSTRAINT fk_movements_origin FOREIGN KEY (warehouse_origin_id) REFERENCES warehouses(id),
  CONSTRAINT fk_movements_destination FOREIGN KEY (warehouse_destination_id) REFERENCES warehouses(id),
  CONSTRAINT fk_movements_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS audit_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT DEFAULT NULL,
  accion VARCHAR(40) NOT NULL,
  entidad VARCHAR(80) NOT NULL,
  entidad_id INT DEFAULT NULL,
  modulo VARCHAR(80) NOT NULL DEFAULT 'inventory',
  detalle JSON DEFAULT NULL,
  ip VARCHAR(45) DEFAULT NULL,
  user_agent VARCHAR(255) DEFAULT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  KEY idx_audit_entity (entidad, entidad_id),
  KEY idx_audit_user (usuario_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO warehouses (codigo, nombre)
SELECT 'BOD-PRINCIPAL', 'Bodega principal'
WHERE NOT EXISTS (SELECT 1 FROM warehouses WHERE codigo = 'BOD-PRINCIPAL');
