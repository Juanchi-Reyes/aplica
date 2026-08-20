<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro Empleados</title>
</head>
<body>
  <h1>Registro Empleados</h1>
  <form action="form_emple.php" method="post">
    <table border="0">
      <tr>
        <td>Digite la cantidad de datos:<input type="number" name="tam" required></td>
      </tr>
      <tr>
        <td><input type="submit" name="val" value="MOSTRAR"></td>
      </tr>
    </table>
  </form>
  <hr>
  <?php
  if (isset($_POST['val'])) {
    $t = $_POST['tam'];
    echo "
    <form action='ver_emple.php' method='get'>
    <table border='0'>
    <tr>
    <th>CODIGO</th>
    <th>NOMBRE</th>
    <th>APELLIDO</th>
    <th>EMAIL</th>
    <th>FECHA</th>
    <th>ACCIONES</th>
    </tr>";
    for($i=0; $i<$t; $i++){
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
    echo "<tr>
    <td><input type='submit' name='val' value='REGISTRAR'></td>
    </tr>
    </table>
    </form>";
  }
  ?>
</body>
</html>
