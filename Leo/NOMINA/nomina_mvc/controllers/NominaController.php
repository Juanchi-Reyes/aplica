<?php
// controllers/NominaController.php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Empleado.php';
require_once __DIR__ . '/../models/Prestamo.php';
require_once __DIR__ . '/../models/Nomina.php';

$modeloEmpleado = new Empleado($conexion);
$modeloPrestamo = new Prestamo($conexion);
$modeloNomina = new Nomina($conexion);

$mensaje = "";
$empleado_seleccionado = null;

define('SMLV', 1750905);
define('AUXILIO_TRANSPORTE', 249095);

// Si se envia el formulario
if (isset($_POST['btn_calcular_nomina'])) {
    $mes_actual = date('n'); 
    $anio_actual = date('Y');
    
    // Atrapamos el ID desde el input oculto
    $id_empleado = $_POST['id_empleado'];
    $empleado = $modeloEmpleado->obtenerPorId($id_empleado);
    $sueldo = $empleado['salario_base'];
    
    $dias = $_POST['dias_laborados'];
    $dias_eps = $_POST['dias_eps'] ?? 0;
    $dias_arl = $_POST['dias_arl'] ?? 0;
    
    // VALIDACION ESTRICTA DE DIAS
    $total_dias = $dias + $dias_eps + $dias_arl;
    
    // Verificamos matematicamente los dias y que no exista nomina previa este mes
    if ($total_dias > 30) {
        $mensaje = "Error: Matematica inconsistente. Ingresaste $dias dias laborados, $dias_eps de EPS y $dias_arl de ARL. La suma total ($total_dias) no puede superar los 30 dias del mes contable.";
    } else if ($modeloNomina->verificarNominaMes($id_empleado, $mes_actual, $anio_actual)) {
        $mensaje = "Error: Este empleado ya tiene una nomina liquidada para este mes.";
    } else {
        $horas_nocturnas = $_POST['horas_nocturnas'] ?? 0;
        $horas_dominicales = $_POST['horas_dominicales'] ?? 0;
        
        // 1. DEVENGADOS
        $salario_prop = ($sueldo / 30) * $dias;
        $incapacidad_eps = ($sueldo / 30) * $dias_eps * 0.6667; 
        $incapacidad_arl = ($sueldo / 30) * $dias_arl * 1.0;    
        $valor_hora = $sueldo / 240;
        $recargo_noct = $valor_hora * $horas_nocturnas * 0.35;
        $recargo_dom = $valor_hora * $horas_dominicales * 1.75;
        $auxilio_trans = ($sueldo <= (SMLV * 2)) ? (AUXILIO_TRANSPORTE / 30) * $dias : 0;
        
        $total_devengado = $salario_prop + $incapacidad_eps + $incapacidad_arl + $recargo_noct + $recargo_dom + $auxilio_trans;

        // 2. DEDUCCIONES Y PRESTAMOS
        $ibc = $total_devengado - $auxilio_trans;
        $salud = $ibc * 0.04;
        $pension = $ibc * 0.04;
        $fondo_sol = ($ibc >= (SMLV * 4)) ? $ibc * 0.01 : 0;
        
        $cuota_prestamo = 0;
        $prestamo_activo = $modeloPrestamo->obtenerPrestamoActivo($id_empleado);
        
        if ($prestamo_activo) {
            $saldo_actual = $prestamo_activo['saldo_actual'];
            $valor_cuota_teorica = $prestamo_activo['valor_cuota'];
            
            $cuota_prestamo = ($saldo_actual <= $valor_cuota_teorica) ? $saldo_actual : $valor_cuota_teorica;
            $modeloPrestamo->descontarCuota($prestamo_activo['id_prestamo'], $cuota_prestamo, $saldo_actual);
        }
        
        $total_deducciones = $salud + $pension + $fondo_sol + $cuota_prestamo;
        $neto_pagar = $total_devengado - $total_deducciones;

        // 3. GUARDAR HISTORIAL
        if ($modeloNomina->guardarHistorial($id_empleado, $mes_actual, $anio_actual, $dias, $dias_eps, $dias_arl, $horas_nocturnas, $horas_dominicales, $total_devengado, $total_deducciones, $cuota_prestamo, $neto_pagar)) {
            $mensaje = "Nomina calculada y guardada correctamente para: " . $empleado['nombre'] . " " . $empleado['apellido'];
        } else {
            $mensaje = "Error al guardar la nomina en la base de datos.";
        }
    }
    // Mantenemos al empleado cargado para la vista despues de guardar
    $empleado_seleccionado = $empleado;
    
} 
// Si entramos desde la tabla con un ID
else if (isset($_GET['id'])) {
    $empleado_seleccionado = $modeloEmpleado->obtenerPorId($_GET['id']);
    if (!$empleado_seleccionado) {
        die("Empleado no encontrado.");
    }
} 
// Si intentan entrar sin ID
else {
    die("Acceso denegado. Seleccione un empleado desde la lista.");
}
?>