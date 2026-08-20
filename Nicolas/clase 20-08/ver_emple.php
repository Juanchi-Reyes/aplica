<?php
$cod=$_REQUEST['cod'];
$nom=$_REQUEST['nom'];
$ape=$_REQUEST['ape'];
$em=$_REQUEST['em'];
$fn=$_REQUEST['fn'];
$tam=count($cod);
for($i=0;$i<$tam;$i++){
    echo $cod[$i]."".$nom[$i]."".$ape[$i]."".$em[$i]."".$fn[$i]."<br>";
}
?>