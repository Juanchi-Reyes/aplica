<?php
include('./connection_inc.php');
$link = conectar();
//traemos los datos del fromulario
$cod = $_REQUEST['cod'];
$nom = $_REQUEST['nom'];
$ape = $_REQUEST['ape'];
$em = $_REQUEST['em'];
$tel = $_REQUEST['tel'];
$fn = $_REQUEST['fn'];
//hacemos la consulta para actualizar los datos
$consulta = "UPDATE alumnos SET nom_a='$nom', apel_a='$ape', email_a='$em', tel_a='$tel', fecha_n='$fn' WHERE id_a=$cod";
$res = mysqli_query($link, $consulta) or die("Error".mysqli_error($link));
echo "ALUMNO $cod EDITADO CORRECTAMENTE <a href='regalu.php'>VOLVER</a>";
mysqli_close($link);
?>