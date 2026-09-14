<?php
// controllers/ListarEmpleadoController.php

// DIR para obtener la ruta absoluta del directorio actual
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Empleado.php';

$modeloEmpleado = new Empleado($conexion);
$mensaje_accion = "";

// Eliminar: Verificamos si llegó un ID
if (isset($_GET['eliminar'])) {
    $id_a_eliminar = $_GET['eliminar'];
    if ($modeloEmpleado->eliminar($id_a_eliminar)) {
        $mensaje_accion = "Empleado eliminado correctamente.";
    } else {
        $mensaje_accion = "Error al intentar eliminar el empleado.";
    }
}

// Listar: Obtenemos todos los empleados después de cualquier eliminación
// la variuable $listaEmpleados tiene todos los empleados para ser mostrados en la vista
$listaEmpleados = $modeloEmpleado->listarTodos();
?>