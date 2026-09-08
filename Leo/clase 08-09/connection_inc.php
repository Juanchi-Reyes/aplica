<?php
function conectar() {
    $host = "localhost";
    $user = "root";
    $password = "";
    $name_bd = "aplica";
    //Creamos la conceccion a la base de datos
    $link = mysqli_connect($host, $user, $password) or die("Error al conectar a la base de datos: " . mysqli_connect_error());
    //Seleccionamos la base de datos
    mysqli_select_db($link, $name_bd) or die("Error al seleccionar la base de datos: " . mysqli_error($link));
    return $link;
}
?>