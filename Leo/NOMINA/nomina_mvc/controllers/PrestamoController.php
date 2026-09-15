<?php
// controllers/PrestamoController.php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Empleado.php';
require_once __DIR__ . '/../models/Prestamo.php';

$modeloEmpleado = new Empleado($conexion);
$modeloPrestamo = new Prestamo($conexion);

// ESTA LÍNEA ES VITAL: Trae la lista dinámica de la base de datos
$listaEmpleados = $modeloEmpleado->listarTodos();
$mensaje = "";

if (isset($_POST['btn_asignar_prestamo'])) { // Validamos que se envíe el formulario[cite: 1]
    $id_empleado = $_POST['id_empleado'];
    $monto_total = $_POST['monto_total'];
    $cuotas_totales = $_POST['cuotas_totales'];
    $fecha_desembolso = date('Y-m-d');
    
    $prestamo_activo = $modeloPrestamo->obtenerPrestamoActivo($id_empleado);
    
    if ($prestamo_activo) {
        $mensaje = "Error: Este empleado ya tiene un préstamo activo.";
    } else {
        $valor_cuota = $monto_total / $cuotas_totales;
        if ($modeloPrestamo->registrarPrestamo($id_empleado, $monto_total, $cuotas_totales, $valor_cuota, $fecha_desembolso)) {
            $mensaje = "Préstamo asignado exitosamente. Cuota mensual: $" . number_format($valor_cuota, 2);
        } else {
            $mensaje = "Error al guardar el préstamo.";
        }
    }
}
?>