<?php
//conexion.php
$host = "localhost";
$usuario = "root";
$password = ""; // Base de datos sin contraseña por defecto
$base_datos = "nomina_mvc";

// Establecemos la conexión
$conexion = mysqli_connect($host, $usuario, $password, $base_datos);

// miramos si hay error en la conexión
if(!$conexion){
    die("Error de conexión a MySQL: " . mysqli_connect_error());
}

// Forzamos el uso de UTF-8 para no tener problemas con tildes o eñes
mysqli_set_charset($conexion, "utf8mb4");
?>