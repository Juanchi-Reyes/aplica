<?php
include("./connection_inc.php");
$link=Conectar();
$id=$_REQUEST['id'];
$sql="delete from alumnos where id_a=$id";
$res=mysqli_query($link,$sql) or die ("ERROR".mysqli_error($link));
echo "Alumno con $id Eliminado <a href='./regalu.php'>VOLVER</a>";
mysqli_close($link);
?>