<?php
$cod=$_REQUEST['cod'];
$nom=$_REQUEST['nom'];
$ape=$_REQUEST['ape'];
$email=$_REQUEST['em'];
$fn=$_REQUEST['fn'];
$tam=count($cod);

for($i=0;$i<$tam;$i++){
    echo "Codigo: ".$cod[$i]." - Nombre: ".$nom[$i]." - Apellido: ".$ape[$i]." - Email: ".$email[$i]." - Fecha de Nacimiento: ".$fn[$i]."<br>";
}
// volver al formulario de registro de empleados
echo "<button><a href='form_emple.php'>Volver</a></button>";

?>