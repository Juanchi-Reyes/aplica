<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Alumnos</title>
</head>
<body>
    <?php
        // Recibir el código enviado desde el formulario

        $codigo = $_REQUEST['codigo'];
        $nombre = $_REQUEST['nombre'];
        $apellido = $_REQUEST['apellido'];
        $telefono = $_REQUEST['telefono'];
        $email = $_REQUEST['email'];
        $genero = $_REQUEST['sexo'];
        $ciudad = $_REQUEST['ciudad'];

        echo "Codigo recibido: ".$codigo."<br>";
        echo "Nombre recibido: ".$nombre."<br>";
        echo "Apellido recibido: ".$apellido."<br>";
        echo "Telefono recibido: ".$telefono."<br>";
        echo "Email recibido: ".$email."<br>";
        echo "Genero recibido: ".$genero."<br>";
        echo "Ciudad recibida: ".$ciudad."<br>";
    ?>
</body>
</html>