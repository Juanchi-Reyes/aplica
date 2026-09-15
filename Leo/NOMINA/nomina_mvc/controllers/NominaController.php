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

// Lo ideal es pasarlo a config.php, pero lo mantenemos por ahora para no dañar tus otras vistas
define('SMLV', 1750905);
define('AUXILIO_TRANSPORTE', 249095);

if (isset($_POST['btn_calcular_nomina'])) {

    // Fechas simuladas para el periodo (Ej. Del 1 al 30 del mes actual)
    $fecha_inicio = date('Y-m-01');
    $fecha_fin = date('Y-m-t');
    $descripcion = "Nómina " . date('M Y');

    $id_empleado = $_POST['id_empleado'];
    // Suponemos que quien calcula es el admin en sesión
    session_start();
    $id_usuario_creo = $_SESSION['id_usuario'] ?? 1;

    $empleado = $modeloEmpleado->obtenerPorId($id_empleado);
    $sueldo = $empleado['sueldo_base']; // Cambió el nombre en la tabla

    $dias = $_POST['dias_laborados'];
    $dias_eps = $_POST['dias_eps'] ?? 0;
    $dias_arl = $_POST['dias_arl'] ?? 0;

    $total_dias = $dias + $dias_eps + $dias_arl;

    if ($total_dias > 30) {
        $mensaje = "Error: La suma total ($total_dias) no puede superar los 30 dias.";
    } else if ($modeloNomina->verificarNominaMes($id_empleado, $fecha_inicio)) {
        $mensaje = "Error: Este empleado ya tiene una nomina liquidada para este mes.";
    } else {
        $horas_nocturnas = $_POST['horas_nocturnas'] ?? 0;
        $horas_dominicales = $_POST['horas_dominicales'] ?? 0;

        // Matemáticas
        $salario_prop = ($sueldo / 30) * $dias;
        $incapacidad_eps = ($sueldo / 30) * $dias_eps * 0.6667;
        $incapacidad_arl = ($sueldo / 30) * $dias_arl * 1.0;

        $valor_hora = $sueldo / 240;
        $recargo_noct = $valor_hora * $horas_nocturnas * 0.35;
        $recargo_dom = $valor_hora * $horas_dominicales * 1.75;
        $auxilio_trans = ($sueldo <= (SMLV * 2)) ? (AUXILIO_TRANSPORTE / 30) * $dias : 0;

        $total_devengado = $salario_prop + $incapacidad_eps + $incapacidad_arl + $recargo_noct + $recargo_dom + $auxilio_trans;

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

        // Empaquetamos todo en el nuevo formato normalizado para la BD.
        // ADVERTENCIA: Los IDs 1, 2, 3, etc. deben existir en tu tabla `conceptos_nomina`.
        $detalles_calculados = [
            ['id_concepto' => 1, 'cantidad_dias' => $dias, 'valor' => $salario_prop],           // 1: Sueldo Básico
            ['id_concepto' => 2, 'cantidad_dias' => $dias_eps, 'valor' => $incapacidad_eps],    // 2: Incapacidad EPS
            ['id_concepto' => 3, 'cantidad_dias' => $dias_arl, 'valor' => $incapacidad_arl],    // 3: Incapacidad ARL
            ['id_concepto' => 4, 'cantidad_dias' => $horas_nocturnas, 'valor' => $recargo_noct], // 4: Recargos
            ['id_concepto' => 5, 'cantidad_dias' => $horas_dominicales, 'valor' => $recargo_dom], // 5: Dominicales
            ['id_concepto' => 6, 'cantidad_dias' => $dias, 'valor' => $auxilio_trans],          // 6: Auxilio Transporte
            ['id_concepto' => 7, 'cantidad_dias' => 0, 'valor' => $salud],                      // 7: Salud (Deducción)
            ['id_concepto' => 8, 'cantidad_dias' => 0, 'valor' => $pension],                    // 8: Pensión (Deducción)
            ['id_concepto' => 9, 'cantidad_dias' => 0, 'valor' => $fondo_sol],                  // 9: Fondo Solidaridad
        ];

        if ($cuota_prestamo > 0) {
            $detalles_calculados[] = ['id_concepto' => 10, 'cantidad_dias' => 0, 'valor' => $cuota_prestamo]; // 10: Préstamo
        }

        if ($modeloNomina->guardarHistorial($id_empleado, $id_usuario_creo, $fecha_inicio, $fecha_fin, $descripcion, $detalles_calculados)) {
            $mensaje = "Nomina calculada y guardada (Normalizada) para: " . $empleado['nombre_completo'];
        } else {
            $mensaje = "Error al guardar la nomina en la base de datos.";
        }
    }
    $empleado_seleccionado = $empleado;
} else if (isset($_GET['id'])) {
    $empleado_seleccionado = $modeloEmpleado->obtenerPorId($_GET['id']);
}
?>