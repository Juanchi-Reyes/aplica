<?php
// controllers/ListarEmpleadoController.php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Empleado.php';
require_once __DIR__ . '/../models/Nomina.php';
require_once __DIR__ . '/../models/Prestamo.php';

$modeloEmpleado = new Empleado($conexion);
$modeloNomina = new Nomina($conexion);
$modeloPrestamo = new Prestamo($conexion);
$mensaje_accion = "";

// Usamos isset para validar si llega una orden de eliminación
if (isset($_GET['eliminar'])) {
    $id_a_eliminar = $_GET['eliminar'];
    if ($modeloEmpleado->eliminar($id_a_eliminar)) {
        $mensaje_accion = "Empleado eliminado correctamente.";
    } else {
        $mensaje_accion = "Error al intentar eliminar.";
    }
}

// Obtenemos los empleados y verificamos el estado del mes actual y prestamos
$empleadosBrutos = $modeloEmpleado->listarTodos();
$listaEmpleados = [];
$mes_actual = date('n');
$anio_actual = date('Y');

foreach ($empleadosBrutos as $emp) {
    // Verificamos si tiene nomina calculada este mes
    $emp['nomina_calculada'] = $modeloNomina->verificarNominaMes($emp['id_empleado'], $mes_actual, $anio_actual);
    
    // Verificamos si tiene un prestamo activo en curso
    $emp['prestamo_activo'] = $modeloPrestamo->obtenerPrestamoActivo($emp['id_empleado']);
    
    $listaEmpleados[] = $emp;
}
?>