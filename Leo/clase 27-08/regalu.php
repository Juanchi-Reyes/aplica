<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>Registro de alumnos BD</title>
</head>

<body>
    <h2 align="center">Registro de Alumnos</h2>
    <form action="insertar_alu.php" method="post">
        <table border="1" align="center">
            <tr>
                <th>Codigo:</th>
                <td><input type="number" name="codigo" placeholder="Ingrese el código" required></td>
            </tr>
            <tr>
                <th>Nombre:</th>
                <td><input type="text" name="nombre" placeholder="Ingrese el nombre" required></td>
            </tr>
            <tr>
                <th>Apellido:</th>
                <td><input type="text" name="apellido" placeholder="Ingrese el apellido" required></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><input type="email" name="email" placeholder="Ingrese el email" required></td>
            </tr>
            <tr>
                <th>Telefono:</th>
                <td><input type="number" name="telefono" placeholder="Ingrese el telefono" required></td>
            </tr>
            <tr>
                <th>Fecha de nacimiento:</th>
                <td><input type="date" name="fecha_nacimiento" placeholder="Ingrese la fecha de nacimiento" required>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Registrar Alumno">
                    <input type="reset" value="Limpiar formulario">
                </td>
        </table>
    </form>

    <table border="0" align='center'>
        <tr>
            <th>CODIGO</th>
            <th>NOMBRE</th>
            <th>APELLIDO</th>
            <th>EMAIL</th>
            <th>TELEFONO</th>
            <th>FECHA Nac</th>
            <th>ACCIONES</th>

        </tr>
        <?php
include("./connection_inc.php");
$link=Conectar();
$sql="select * from alumnos";
$res=mysqli_query($link,$sql) or die ("ERROR en la consulta $sql".mysqli_error($link));
while($row=mysqli_fetch_array($res)){
echo "
        <tr>
        <td>".$row['id_a']."</td>
        <td>".$row['nom_a']."</td>
        <td>".$row['apel_a']."</td>
        <td>".$row['email_a']."</td>
        <td>".$row['tel_a']."</td>        
        <td>".$row['fecha_n']."</td>
        <td><a href='./form_edit_alu.php?id=".$row['id_a']."'>
        <span class='material-symbols-outlined'>edit_square</span></a>
        <span class='material-symbols-outlined'>delete_sweep</span>
        <span class='material-symbols-outlined'>folder_eye</span>
        </td>
        </tr>";
}
?>
    </table>

</body>

</html>