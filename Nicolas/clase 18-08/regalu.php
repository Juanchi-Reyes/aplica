<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de alumnos</title>
</head>
<body>
<?php
// Declarar variables
// anteriormente se declaraban variables con $_POST, ahora se declaran con $_REQUEST para aceptar tanto GET como POST
$cod = $_REQUEST['codigo'];
$nombre = $_REQUEST['nombre'];
$apellido = $_REQUEST['apellido'];
$correo = $_REQUEST['email'];
$telefono = $_REQUEST['telefono'];
$fecha_nacimiento = $_REQUEST['fecha_nacimiento'];
$ciudad = $_REQUEST['ciudad'];
$sexo = $_REQUEST['sexo'];

echo "<h2>Datos del Alumno Registrado</h2>";
echo "codigo: " .$cod. "<br>";
echo "nombre: " .$nombre. "<br>";
echo "apellido: " .$apellido. "<br>";
echo "correo: " .$correo. "<br>";
echo "telefono: " .$telefono. "<br>";
echo "fecha de nacimiento: " .$fecha_nacimiento. "<br>";
echo "ciudad: " .$ciudad. "<br>";
if ($sexo == "M") {
    echo "sexo: Masculino<br>";
} elseif ($sexo == "F") {
    echo "sexo: Femenino<br>";
}
/*
echo "<h2>Datos del Alumno Registrado</h2>";
echo "<p><strong>Código:</strong> " . htmlspecialchars($cod) . "</p>";
echo "<p><strong>Nombre:</strong> " . htmlspecialchars($nombre) . "</p>";
echo "<p><strong>Apellido:</strong> " . htmlspecialchars($apellido) . "</p>";
echo "<p><strong>Correo:</strong> " . htmlspecialchars($correo) . "</p>";
echo "<p><strong>Teléfono:</strong> " . htmlspecialchars($telefono) . "</p>";
echo "<p><strong>Fecha de Nacimiento:</strong> " . htmlspecialchars($fecha_nacimiento) . "</p>";
echo "<p><strong>Ciudad:</strong> " . htmlspecialchars($ciudad) . "</p>";
echo "<p><strong>Género:</strong> " . htmlspecialchars($sexo) . "</p>";
*/
?>
</body>
</html> 
