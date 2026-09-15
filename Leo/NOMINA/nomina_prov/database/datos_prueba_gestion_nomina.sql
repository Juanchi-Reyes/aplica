-- =========================================
-- DATOS DE PRUEBA - gestion_nomina
-- =========================================

-- =========================================
-- CARGOS
-- =========================================
INSERT INTO cargos (nombre_cargo) VALUES
('Gerente General'),
('Contador'),
('Auxiliar Administrativo'),
('Vendedor');

-- =========================================
-- CENTROS DE COSTO
-- =========================================
INSERT INTO centros_costo (nombre) VALUES
('Administrativo'),
('Ventas'),
('Operativo');

-- =========================================
-- CONCEPTOS DE NÓMINA
-- =========================================
INSERT INTO conceptos_nomina (nombre_concepto, tipo, naturaleza, porcentaje) VALUES
('Salario', 'DEVENGADO', 'FIJO', NULL),
('Auxilio de transporte', 'DEVENGADO', 'FIJO', NULL),
('Salud', 'DEDUCCION', 'PORCENTAJE', 0.04),
('Pensión', 'DEDUCCION', 'PORCENTAJE', 0.04),
('Prima de servicios', 'PRESTACION_SOCIAL', 'PORCENTAJE', 0.0833);

-- =========================================
-- EMPLEADOS
-- (id_cargo e id_centro_costo referencian lo insertado arriba: 1-4 y 1-3)
-- =========================================
INSERT INTO empleados (numero_identificacion, nombre_completo, id_cargo, id_centro_costo, sueldo_base, fecha_ingreso) VALUES
('1001', 'Carlos Andrés Gómez', 1, 1, 3500000.00, '2023-01-15'),
('1002', 'Laura Fernanda Ríos', 2, 1, 2800000.00, '2023-03-01'),
('1003', 'Juan Pablo Torres', 3, 1, 1600000.00, '2024-02-10'),
('1004', 'María José Salazar', 4, 2, 1500000.00, '2024-06-20');

-- =========================================
-- NÓMINA
-- (id_usuario_creo = 1, el Administrador ya creado)
-- =========================================
INSERT INTO nominas (fecha_inicio, fecha_fin, descripcion, estado, id_usuario_creo) VALUES
('2026-01-01', '2026-01-15', 'Nómina 01 al 15 Enero 2026', 'LIQUIDADA', 1),
('2026-01-16', '2026-01-31', 'Nómina 16 al 31 Enero 2026', 'BORRADOR', 1);

-- =========================================
-- DETALLE DE NÓMINA
-- (relaciona nómina 1 con los 4 empleados y el concepto Salario)
-- =========================================
INSERT INTO detalle_nomina (id_nomina, id_empleado, id_concepto, dias, valor) VALUES
(1, 1, 1, 15, 1750000.00),
(1, 2, 1, 15, 1400000.00),
(1, 3, 1, 15, 800000.00),
(1, 4, 1, 15, 750000.00),
(1, 1, 3, 15, 70000.00),
(1, 2, 3, 15, 56000.00);

-- =========================================
-- PRÉSTAMOS
-- (id_empleado 3: Juan Pablo, con 2 de 5 cuotas pagadas)
-- =========================================
INSERT INTO prestamos (id_empleado, monto_desembolso, numero_cuotas, fecha_desembolso, valor_cuota, cuotas_pagadas, saldo_actual, estado) VALUES
(3, 500000.00, 5, '2025-11-01', 100000.00, 2, 300000.00, 'ACTIVO');
