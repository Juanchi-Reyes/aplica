<?php
// Funciones CRUD para empleados. Requiere que $conexion ya exista (viene de config/conexion.php)

function insertarEmpleado($conexion, $numero_identificacion, $nombre_completo, $id_cargo, $id_centro_costo, $sueldo_base, $fecha_ingreso) {
    $stmt = $conexion->prepare(
        "INSERT INTO empleados (numero_identificacion, nombre_completo, id_cargo, id_centro_costo, sueldo_base, fecha_ingreso)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param('ssiids', $numero_identificacion, $nombre_completo, $id_cargo, $id_centro_costo, $sueldo_base, $fecha_ingreso);
    return $stmt->execute() ? true : $conexion->error;
}

function actualizarEmpleado($conexion, $id, $numero_identificacion, $nombre_completo, $id_cargo, $id_centro_costo, $sueldo_base, $fecha_ingreso) {
    $stmt = $conexion->prepare(
        "UPDATE empleados SET numero_identificacion=?, nombre_completo=?, id_cargo=?, id_centro_costo=?, sueldo_base=?, fecha_ingreso=?
         WHERE id_empleado=?"
    );
    $stmt->bind_param('ssiidsi', $numero_identificacion, $nombre_completo, $id_cargo, $id_centro_costo, $sueldo_base, $fecha_ingreso, $id);
    return $stmt->execute() ? true : $conexion->error;
}

function eliminarEmpleado($conexion, $id) {
    $stmt = $conexion->prepare("DELETE FROM empleados WHERE id_empleado = ?");
    $stmt->bind_param('i', $id);
    return $stmt->execute() ? true : $conexion->error;
}

function obtenerEmpleado($conexion, $id) {
    $stmt = $conexion->prepare("SELECT * FROM empleados WHERE id_empleado = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function listarEmpleados($conexion) {
    $sql = "SELECT e.id_empleado, e.numero_identificacion, e.nombre_completo,
                   c.nombre_cargo, cc.nombre AS centro_costo,
                   e.sueldo_base, e.fecha_ingreso, e.estado
            FROM empleados e
            JOIN cargos c ON e.id_cargo = c.id_cargo
            JOIN centros_costo cc ON e.id_centro_costo = cc.id_centro_costo
            ORDER BY e.nombre_completo";
    return $conexion->query($sql);
}

function obtenerCargos($conexion) {
    return $conexion->query("SELECT id_cargo, nombre_cargo FROM cargos WHERE estado='ACTIVO'");
}

function obtenerCentrosCosto($conexion) {
    return $conexion->query("SELECT id_centro_costo, nombre FROM centros_costo WHERE estado='ACTIVO'");
}   