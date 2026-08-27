<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar alumno</title>
</head>

<body>
    <h2 align="center">Editar Alumno</h2>
    <?php
    include('./connection_inc.php');
    $link = conectar();
    $id = $_REQUEST['id'];
    $sql = "SELECT * FROM alumnos WHERE id_a = $id";
    $res = mysqli_query($link, $sql) or die("Error".mysqli_error($link));
    if($res)
</body>
</html>