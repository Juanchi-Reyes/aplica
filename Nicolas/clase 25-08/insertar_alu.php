<?php
include("./conexion.inc.php");
$link = conectar();
//traemos los datos del formulario:
$cod = $_REQUEST['codigo'];
$nombre = $_REQUEST['nombre'];
$apellido = $_REQUEST['apellido'];
$correo = $_REQUEST['email'];
$telefono = $_REQUEST['telefono'];
$fecha_nacimiento = $_REQUEST['fecha_nacimiento'];
//insertar los datos en la tabla:
$sql = "INSERT INTO alumnos (id_a, nom_a, apel_a, email_a, tel_a, fecha_n)
        VALUES ('$cod', '$nombre', '$apellido', '$correo', '$telefono', '$fecha_nacimiento')";
//ejecutar la sentencia sql:
$res = mysqli_query($link, $sql) or die("Error en la consulta" . mysqli_error($link));
echo "Alumno Registrado correctamente <a href='from_alu.php'>Volver</a>";

?>