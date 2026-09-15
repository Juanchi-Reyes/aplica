<?php
// controllers/EmpleadoController.php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Empleado.php';

$mensaje = "";

if (isset($_POST['btn_registrar'])) {

    $cedula = trim($_POST['cedula']);
    $password = $_POST['password'];
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);

    // Ahora en el formulario (vista) los selects deberán enviar el ID, no el texto.
    $id_centro_costo = $_POST['id_centro_costo'];
    $id_cargo = $_POST['id_cargo'];

    $salario_base = $_POST['salario_base'];
    $fecha_ingreso = date('Y-m-d'); // Asignamos fecha actual por defecto

    $modeloEmpleado = new Empleado($conexion);

    // Pasamos los nuevos campos a la función registrar
    if ($modeloEmpleado->registrar($cedula, $password, $nombre, $apellido, $telefono, $correo, $id_centro_costo, $id_cargo, $salario_base, $fecha_ingreso)) {
        $mensaje = "Empleado y usuario registrado exitosamente.";
    } else {
        $mensaje = "Error al registrar el empleado. Es posible que el correo o número de identificación ya existan.";
    }
}
?>