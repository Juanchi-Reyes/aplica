<?php
// Nomina

class Nomina {
    private $conexion;

    public function __construct($db) {
        $this->conexion = $db;
    }

    public function guardarHistorial($id_empleado, $mes, $anio, $dias_laborados, $dias_eps, $dias_arl, $horas_nocturnas, $horas_dominicales, $total_devengado, $total_deducciones, $valor_cuota_prestamo, $neto_pagar) {
        $sql = "INSERT INTO nominas_historial 
                (id_empleado, mes, anio, dias_laborados, dias_incapacidad_eps, dias_incapacidad_arl, recargo_nocturno_horas, horas_dominicales, total_devengado, total_deducciones, valor_cuota_prestamo, neto_pagar) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conexion, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iiiiiiiidddd", $id_empleado, $mes, $anio, $dias_laborados, $dias_eps, $dias_arl, $horas_nocturnas, $horas_dominicales, $total_devengado, $total_deducciones, $valor_cuota_prestamo, $neto_pagar);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    // Función para obtener el último mes liquidado de un empleado
    // Esto nos sirve para 
    public function obtenerUltimaNomina($id_empleado) {
        $sql = "SELECT * FROM nominas_historial WHERE id_empleado = ? ORDER BY id_nomina DESC LIMIT 1";
        $stmt = mysqli_prepare($this->conexion, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id_empleado);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_assoc($resultado);
        }
        return null;
    }

    // verificamos si ya existe una nómina para el mes y año especificados
    public function verificarNominaMes($id_empleado, $mes, $anio) {
        $sql = "SELECT id_nomina FROM nominas_historial WHERE id_empleado = ? AND mes = ? AND anio = ?";
        $stmt = mysqli_prepare($this->conexion, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iii", $id_empleado, $mes, $anio);
            mysqli_stmt_execute($stmt);
            $resultado = mysqli_stmt_get_result($stmt);
            return mysqli_num_rows($resultado) > 0; // Retorna true si ya existe
        }
        return false;
    }
}
?>