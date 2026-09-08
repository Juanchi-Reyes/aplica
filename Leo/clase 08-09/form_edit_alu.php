<!DOCTYPE html>
<html lang="es">

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
    $id = $_REQUEST['id_a'] ?? $_REQUEST['id'] ?? null;

    if ($id === null) {
        die('No se recibió el ID del alumno.');
    }

    $sql = "SELECT * FROM alumnos WHERE id_a = $id";
    $res = mysqli_query($link, $sql) or die("Error".mysqli_error($link));
    if($row = mysqli_fetch_array($res)){
        ?>
    <form action='edit_alu.php' method="post">
        <table border='0' align='center'>
            <tr>
                <th>CODIGO</th>
                <td><input type="number" name="cod" value="<?php echo $row['id_a'];?>" readonly></td>
            </tr>
            <tr>
                <th>NOMBRE</th>
                <td><input type="text" name="nom" value="<?php echo $row['nom_a'];?>"></td>
            </tr>
            <tr>
                <th>APELLIDO</th>
                <td><input type="text" name="ape" value="<?php echo $row['apel_a'];?>"></td>
            </tr>
            <tr>
                <th>EMAIL</th>
                <td><input type="text" name="em" value="<?php echo $row['email_a'];?>"></td>
            </tr>
            <tr>
                <th>TELEFONO</th>
                <td><input type="number" name="tel" value="<?php echo $row['tel_a'];?>"></td>
            </tr>
            <tr>
                <th>FECHA Nac</th>
                <td><input type="date" name="fn" value="<?php echo $row['fecha_n'];?>"></td>
            </tr>
            <tr>
                <td><input type='submit' value='EDITAR ALUMNO'></td>
            </tr>
        </table>
    </form>
    <?php } ?>
</body>

</html>