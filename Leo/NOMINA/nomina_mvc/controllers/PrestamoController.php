<?php
// controllers/PrestamoController.php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Empleado.php';
require_once __DIR__ . '/../models/Prestamo.php';

$modeloEmpleado = new Empleado($conexion);
$modeloPrestamo = new Prestamo($conexion);

$mensaje = "";
$empleado_seleccionado = null;
$prestamo_activo = null;

if (isset($_POST['btn_asignar_prestamo'])) { 
    $id_empleado = $_POST['id_empleado'];
    $monto_total = $_POST['monto_total'];
    $cuotas_totales = $_POST['cuotas_totales'];
    $fecha_desembolso = date('Y-m-d');
    
    $prestamo_activo = $modeloPrestamo->obtenerPrestamoActivo($id_empleado);
    
    if ($prestamo_activo) {
        $mensaje = "Error: Este empleado ya tiene un prestamo activo.";
    } else {
        $valor_cuota = $monto_total / $cuotas_totales;
        if ($modeloPrestamo->registrarPrestamo($id_empleado, $monto_total, $cuotas_totales, $valor_cuota, $fecha_desembolso)) {
            $mensaje = "Prestamo asignado exitosamente. Cuota mensual: $" . number_format($valor_cuota, 2);
        } else {
            $mensaje = "Error al guardar el prestamo.";
        }
    }
    // Mantenemos al empleado y refrescamos el estado del prestamo para la vista despues de guardar
    $empleado_seleccionado = $modeloEmpleado->obtenerPorId($id_empleado);
    $prestamo_activo = $modeloPrestamo->obtenerPrestamoActivo($id_empleado);
    
} else if (isset($_GET['id'])) {
    $empleado_seleccionado = $modeloEmpleado->obtenerPorId($_GET['id']);
    if (!$empleado_seleccionado) {
        die("Empleado no encontrado.");
    }
    // Traemos el prestamo para saber si mostramos el resumen o el formulario
    $prestamo_activo = $modeloPrestamo->obtenerPrestamoActivo($_GET['id']);
} else {
    die("Acceso denegado. Seleccione un empleado desde la lista.");
}
?>