<?php
// controllers/EditarEmpleadoController.php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Empleado.php';

$modeloEmpleado = new Empleado($conexion);
$mensaje = "";
$empleado = null;

if (isset($_POST['btn_actualizar'])) {
    $id_empleado = $_POST['id_empleado'];
    $numero_identificacion = trim($_POST['numero_identificacion']);

    // Como ahora usamos 'nombre_completo' en la BD, lo enviamos todo en la variable nombre y dejamos apellido vacío
    $nombre_completo = trim($_POST['nombre_completo']);
    $apellido = "";

    $id_centro_costo = $_POST['id_centro_costo'];
    $id_cargo = $_POST['id_cargo'];
    $sueldo_base = $_POST['sueldo_base'];

    if ($modeloEmpleado->actualizar($id_empleado, $numero_identificacion, $nombre_completo, $apellido, $id_centro_costo, $id_cargo, $sueldo_base)) {
        $mensaje = "Datos actualizados correctamente.";
    } else {
        $mensaje = "Error al actualizar los datos.";
    }

    $empleado = $modeloEmpleado->obtenerPorId($id_empleado);
} else if (isset($_GET['id'])) {
    $id_empleado = $_GET['id'];
    $empleado = $modeloEmpleado->obtenerPorId($id_empleado);

    if (!$empleado) {
        die("Empleado no encontrado en la base de datos.");
    }
} else {
    die("Acceso denegado. Faltan parámetros.");
}
?>