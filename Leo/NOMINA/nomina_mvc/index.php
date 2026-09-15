<?php
// index.php (En la raíz del proyecto)
session_start();

// Si el usuario ya había iniciado sesión, lo redirigimos automáticamente a su panel
if (isset($_SESSION['rol'])) {
    if ($_SESSION['rol'] == 'admin') {
        header("Location: views/admin/listar_empleados.php");
    } else {
        header("Location: views/empleado/perfil_empleado.php");
    }
    exit;
}

// Si no ha iniciado sesión, cargamos el controlador del login
require_once 'controllers/LoginController.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Nómina</title>
</head>

<body>

    <h2>Iniciar Sesión</h2>

    <!-- Mensaje de error en HTML puro -->
    <?php if (!empty($mensaje_error)): ?>
    <p><strong><?= $mensaje_error ?></strong></p>
    <?php endif; ?>

    <form action="index.php" method="POST">
        <table border="0">
            <tr>
                <td><label>Cédula:</label></td>
                <td><input type="text" name="cedula" required></td>
            </tr>
            <tr>
                <td><label>Contraseña:</label></td>
                <td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="btn_login">Entrar</button>
                </td>
            </tr>
        </table>
    </form>

</body>

</html>