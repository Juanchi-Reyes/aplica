-- Insertar Cargos básicos
INSERT INTO cargos (id_cargo, nombre_cargo, estado) VALUES
(1, 'Gerente', 'ACTIVO'),
(2, 'Asistente', 'ACTIVO'),
(3, 'Vendedor', 'ACTIVO')
ON DUPLICATE KEY UPDATE nombre_cargo = VALUES(nombre_cargo);

-- Insertar Centros de Costo básicos
INSERT INTO centros_costo (id_centro_costo, nombre, estado) VALUES
(1, 'Administración', 'ACTIVO'),
(2, 'Operaciones', 'ACTIVO'),
(3, 'Ventas', 'ACTIVO')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

-- Insertar Conceptos de Nómina iniciales
INSERT INTO conceptos_nomina (id_concepto, nombre_concepto, tipo, naturaleza, porcentaje, estado) VALUES
(1, 'Sueldo Básico', 'DEVENGADO', 'FIJO', NULL, 'ACTIVO'),
(2, 'Incapacidad EPS', 'DEVENGADO', 'PORCENTAJE', 0.6667, 'ACTIVO'),
(3, 'Incapacidad ARL', 'DEVENGADO', 'PORCENTAJE', 1.0000, 'ACTIVO'),
(4, 'Recargo Nocturno', 'DEVENGADO', 'PORCENTAJE', 0.3500, 'ACTIVO'),
(5, 'Horas Dominicales', 'DEVENGADO', 'PORCENTAJE', 1.7500, 'ACTIVO'),
(6, 'Auxilio de Transporte', 'DEVENGADO', 'FIJO', NULL, 'ACTIVO'),
(7, 'Salud Empleado', 'DEDUCCION', 'PORCENTAJE', 0.0400, 'ACTIVO'),
(8, 'Pensión Empleado', 'DEDUCCION', 'PORCENTAJE', 0.0400, 'ACTIVO'),
(9, 'Fondo de Solidaridad', 'DEDUCCION', 'PORCENTAJE', 0.0100, 'ACTIVO'),
(10, 'Cuota Préstamo', 'DEDUCCION', 'FIJO', NULL, 'ACTIVO')
ON DUPLICATE KEY UPDATE nombre_concepto = VALUES(nombre_concepto);