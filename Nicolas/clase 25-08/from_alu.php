<?php
include("./conexion.inc.php");
$link = conectar();
$consulta = mysqli_query($link, "SELECT id_a AS codigo, nom_a AS nombre, apel_a AS apellido, email_a AS email, tel_a AS telefono, fecha_n AS fecha_nacimiento FROM alumnos ORDER BY id_a")
    or die("Error en la consulta: " . mysqli_error($link));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de alumnos</title>
</head>

<body>
    <h2 align="center">Registro de Alumnos</h2>
    <form action="insertar_alu.php" method="post">
        <table border="1" align="center">
            <tr>
                <th>Codigo:</th>
                <td><input type="number" name="codigo" placeholder="Ingrese el código"></td>
            </tr>
            <tr>
                <th>Nombre:</th>
                <td><input type="text" name="nombre" placeholder="Ingrese el nombre"></td>
            </tr>
            <tr>
                <th>Apellido:</th>
                <td><input type="text" name="apellido" placeholder="Ingrese el apellido"></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><input type="email" name="email" placeholder="Ingrese el email"></td>
            </tr>
            <tr>
                <th>Telefono:</th>
                <td><input type="number" name="telefono" placeholder="Ingrese el telefono"></td>
            </tr>
            <tr>
                <th>Fecha de nacimiento:</th>
                <td><input type="date" name="fecha_nacimiento" placeholder="Ingrese la fecha de nacimiento"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Registrar Alumno">
                    <input type="reset" value="Limpiar formulario">
                </td>
            </tr>
        </table>
    </form>

    <h2 align="center">Alumnos registrados</h2>
    <table border="1" align="center">
        <tr>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Telefono</th>
            <th>Fecha de nacimiento</th>
        </tr>
        <?php while ($alumno = mysqli_fetch_assoc($consulta)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($alumno['codigo']); ?></td>
            <td><?php echo htmlspecialchars($alumno['nombre']); ?></td>
            <td><?php echo htmlspecialchars($alumno['apellido']); ?></td>
            <td><?php echo htmlspecialchars($alumno['email']); ?></td>
            <td><?php echo htmlspecialchars($alumno['telefono']); ?></td>
            <td><?php echo htmlspecialchars($alumno['fecha_nacimiento']); ?></td>
        </tr>
        <?php } ?>
    </table>
</body>

</html>