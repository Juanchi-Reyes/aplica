<?php
// Controlador para editar un empleado

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Empleado.php';

$modeloEmpleado = new Empleado($conexion);
$mensaje = "";
$empleado = null;

// formulario fue enviado para actualizar los datos
if (isset($_POST['btn_actualizar'])) {
    $id_empleado = $_POST['id_empleado'];
    $cedula = trim($_POST['cedula']);
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $centro_costo = trim($_POST['centro_costo']);
    $cargo = trim($_POST['cargo']);
    $salario_base = $_POST['salario_base'];

    if ($modeloEmpleado->actualizar($id_empleado, $cedula, $nombre, $apellido, $centro_costo, $cargo, $salario_base)) {
        $mensaje = "Datos actualizados correctamente.";
    } else {
        $mensaje = "Error al actualizar los datos.";
    }
    
    // Recargamos los datos frescos desde la base de datos
    $empleado = $modeloEmpleado->obtenerPorId($id_empleado);
} 
// Si venimos de la lista y traemos el ID por la URL ($_GET)
else if (isset($_GET['id'])) {
    $id_empleado = $_GET['id'];
    $empleado = $modeloEmpleado->obtenerPorId($id_empleado);
    
    if (!$empleado) {
        die("Empleado no encontrado en la base de datos.");
    }
} 
// En caso de que no haya ID
else {
    die("Acceso denegado. Faltan parámetros.");
}
?>