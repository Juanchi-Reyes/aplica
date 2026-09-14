<?php
// Controlador de empleado
// Incluimos la conexión y el modelo
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Empleado.php';

$mensaje = ""; // Variable para mostrar alertas al usuario
if(isset($_POST['btn_registrar'])){
    // Recolectamos los datos del formulario
    $cedula = trim($_POST['cedula']);
    $password = $_POST['password'];
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $centro_costo = trim($_POST['centro_costo']);
    $cargo = trim($_POST['cargo']);
    $salario_base = $_POST['salario_base'];

    //Instanciamos el modelo de empleado
    $modeloEmpleado = new Empleado($conexion);
    if ($modeloEmpleado->registrar($cedula, $password, $nombre, $apellido, $centro_costo, $cargo, $salario_base)) {
        $mensaje = "Empleado registrado exitosamente.";
    } else {
        $mensaje = "Error al registrar el empleado. Es posible que la cédula ya exista.";
    }
}

?>