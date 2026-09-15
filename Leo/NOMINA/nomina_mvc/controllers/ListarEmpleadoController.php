<?php
// ccontrolador de listar empleados
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Empleado.php';
require_once __DIR__ . '/../models/Nomina.php'; // Incluimos la nómina

$modeloEmpleado = new Empleado($conexion);
$modeloNomina = new Nomina($conexion);
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

// Obtenemos los empleados y verificamos el estado del mes actual
$empleadosBrutos = $modeloEmpleado->listarTodos();
$listaEmpleados = [];
$mes_actual = date('n');
$anio_actual = date('Y');

foreach ($empleadosBrutos as $emp) {
    // Le creamos una nueva llave para saber si ya se le calculó este mes
    $emp['nomina_calculada'] = $modeloNomina->verificarNominaMes($emp['id_empleado'], $mes_actual, $anio_actual);
    $listaEmpleados[] = $emp;
}
?>