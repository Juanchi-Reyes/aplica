<?php
// controllers/VerEmpleadoController.php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Empleado.php';

// Si no nos envían un ID, no podemos mostrar nada
if (!isset($_GET['id'])) {
    die("Acceso denegado. No se especificó el empleado a consultar.");
}

$id_usuario = $_GET['id'];
$modeloEmpleado = new Empleado($conexion);

// Usamos tu función que cruza las tablas y trae el nombre del cargo y centro de costo
$datos_empleado = $modeloEmpleado->obtenerPorId($id_usuario);

if (!$datos_empleado) {
    die("Error: El empleado consultado no existe en la base de datos.");
}
?>