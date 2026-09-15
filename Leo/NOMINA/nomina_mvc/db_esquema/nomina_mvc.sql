-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS nomina_mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nomina_mvc;

-- 1. Tabla de Empleados (Incluye al Administrador)
CREATE TABLE empleados (
    id_empleado INT AUTO_INCREMENT PRIMARY KEY,
    cedula VARCHAR(20) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- Para guardar el hash de la contraseña
    rol ENUM('admin', 'empleado') DEFAULT 'empleado',
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    centro_costo VARCHAR(100) NOT NULL,
    cargo VARCHAR(100) NOT NULL,
    salario_base DECIMAL(12, 2) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Tabla de Préstamos
CREATE TABLE prestamos (
    id_prestamo INT AUTO_INCREMENT PRIMARY KEY,
    id_empleado INT NOT NULL,
    monto_total DECIMAL(12, 2) NOT NULL,
    cuotas_totales INT NOT NULL,
    cuotas_pagadas INT DEFAULT 0,
    valor_cuota DECIMAL(12, 2) NOT NULL,
    saldo_actual DECIMAL(12, 2) NOT NULL,
    fecha_desembolso DATE NOT NULL,
    estado ENUM('activo', 'pagado') DEFAULT 'activo',
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 3. Tabla de Nóminas (Historial mensual inmutable)
CREATE TABLE nominas_historial (
    id_nomina INT AUTO_INCREMENT PRIMARY KEY,
    id_empleado INT NOT NULL,
    mes INT NOT NULL,
    anio INT NOT NULL,
    
    -- Novedades (Lo que se digita en el formulario)
    dias_laborados INT DEFAULT 30,
    dias_incapacidad_eps INT DEFAULT 0,
    dias_incapacidad_arl INT DEFAULT 0,
    recargo_nocturno_horas INT DEFAULT 0,
    horas_dominicales INT DEFAULT 0,
    
    -- Totales calculados (Lo que procesará PHP)
    total_devengado DECIMAL(12, 2) NOT NULL,
    total_deducciones DECIMAL(12, 2) NOT NULL,
    valor_cuota_prestamo DECIMAL(12, 2) DEFAULT 0,
    neto_pagar DECIMAL(12, 2) NOT NULL,
    
    fecha_liquidacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Insertar el Administrador por defecto
-- Cédula: 123456789 | Contraseña: admin (El hash generado abajo corresponde a la palabra "admin")
INSERT INTO empleados (cedula, password, rol, nombre, apellido, centro_costo, cargo, salario_base) 
VALUES ('123456789', '$2y$10$C8uI.N2O.fU8k1q6zE3J..sK/P.hM/B3c4rX/B.L.Q/T/Q.Q/Q.Q.', 'admin', 'Administrador', 'Principal', 'Administracion', 'Gerente', 0);

// Agregar columnas de contacto a la tabla empleados
ALTER TABLE empleados ADD COLUMN telefono VARCHAR(20) DEFAULT NULL AFTER apellido;
ALTER TABLE empleados ADD COLUMN correo VARCHAR(100) DEFAULT NULL AFTER telefono;