<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empleados</title>
</head>
<body>
    <h1>Registro de Empleados</h1>
    <form action="form_emple.php" method="post">
        <table border="0">
            <tr>
                <td>Digite la cantidad de datos:<input type="number" name="tam" required></td>
            </tr>
            <tr>
                <td><input type="submit" name="btn_mostrar" value="Mostrar"></td>
            </tr>
        </table>
    </form>
<hr>
<?php
    if(isset($_POST['btn_mostrar'])){
        $tam = $_POST['tam']; //recuperar el tamaño del arreglo (cantidad de empleados)
        echo "
        <form action='ver_emple.php' method='get'>
            <table border='0'>
                <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Fecha Nac</th>
                    <th>Acciones</th>
                </tr>"; //toda esta es una cadena de impresion en html
        for($i=0;$i<$tam;$i++){
            //aca le indicamos que cada vez que este en el ciclo
            //imprima una fila de la tabla con los inputs para cada empleado
            //si puse 3 empleados, se imprimira 3 veces la fila con los inputs
            echo "
                <tr>
                    <td><input type='number' name='cod[]' required></td>
                    <td><input type='text' name='nom[]' required></td>
                    <td><input type='text' name='ape[]' required></td>
                    <td><input type='email' name='em[]' required></td>
                    <td><input type='date' name='fn[]' required></td>
                    <td>Editar Eliminar Ver</td>
                </tr>";
        }
        echo "
                <tr>
                <td><input type='submit' value='Registrar'></td>
                </tr>
            </table>
        </form>
        ";
    }
?>
</body>
</html>