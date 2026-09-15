<?php
// Prestamo

class Prestamo {
    private $conexion;

    public function __construct($db) {
        $this->conexion = $db;
    }

    // Busca un préstamo que aún no se haya pagado
    public function obtenerPrestamoActivo($id_empleado) {
        $sql = "SELECT * FROM prestamos WHERE id_empleado = ? AND estado = 'activo' LIMIT 1";
        $stmt = mysqli_prepare($this->conexion, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id_empleado);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_assoc($resultado);
        }
        return null;
    }

    // Resta la cuota del saldo actual y actualiza el estado si llega a cero
    public function descontarCuota($id_prestamo, $cuota_descontada, $saldo_anterior) {
        $nuevo_saldo = $saldo_anterior - $cuota_descontada;
        
        // Si el saldo llega a 0 el préstamo se marca como pagado
        $nuevo_estado = ($nuevo_saldo <= 0) ? 'pagado' : 'activo';
        if ($nuevo_saldo < 0) $nuevo_saldo = 0;

        $sql = "UPDATE prestamos SET saldo_actual = ?, estado = ?, cuotas_pagadas = cuotas_pagadas + 1 WHERE id_prestamo = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "dsi", $nuevo_saldo, $nuevo_estado, $id_prestamo);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }


    // Función para registrar un nuevo préstamo
    public function registrarPrestamo($id_empleado, $monto_total, $cuotas_totales, $valor_cuota, $fecha_desembolso) {
        $saldo_actual = $monto_total; // Al inicio, el saldo es igual al monto total
        $estado = 'activo';
        
        $sql = "INSERT INTO prestamos (id_empleado, monto_total, cuotas_totales, valor_cuota, saldo_actual, fecha_desembolso, estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conexion, $sql);
        if ($stmt) {
            // "iidddss" -> 2 enteros, 3 decimales, 2 strings (fecha y estado)
            mysqli_stmt_bind_param($stmt, "iidddss", $id_empleado, $monto_total, $cuotas_totales, $valor_cuota, $saldo_actual, $fecha_desembolso, $estado);
            if (mysqli_stmt_execute($stmt)) {
                return true;
            }
        }
        return false;
    }
}
?>