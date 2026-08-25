<?php
function conectar()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db_name = "aplica";

    $link = mysqli_connect($host, $user, $pass, $db_name)
        or die("Error al conectar a la base de datos: " . mysqli_connect_error());

    return $link;
}
?>