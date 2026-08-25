<?php 
include('./conection_inc.php');
$link = conectar();
// traemos los datos enviados por el formulario de registro de alumnos
$cod = $_POST['codigo'];
$nom = $_POST['nombre'];
$ape = $_POST['apellido'];
$email = $_POST['email'];
$tel = $_POST['telefono'];
$fn = $_POST['fecha_nacimiento'];

$sql = "INSERT INTO alumnos values ($cod, '$nom', '$ape', '$email', '$tel', '$fn')";

// ejecutamos la consulta
$res = mysqli_query($link, $sql) or die("Error al insertar el alumno: " . mysqli_error($link));

echo "<h2>Alumno registrado correctamente</h2>" . "<a href='./regalu.php'>Volver</a>";

// cerramos la conexion
mysqli_close($link);
?>