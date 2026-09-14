<?php
// vista de registrar_empleado

// 1. LÓGICA ARRIBA: Incluimos el controlador para que procese el formulario si fue enviado
require_once '../../controllers/EmpleadoController.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Empleado - Nómina</title>
</head>

<body>
    <h2>Registrar Nuevo Empleado</h2>

    <!-- Sintaxis alternativa para mostrar mensajes -->
    <?php if (!empty($mensaje)): ?>
    <p><strong><?= $mensaje ?></strong></p>
    <?php endif; ?>

    <form action="registrar_empleado.php" method="POST">
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
                <td><label>Nombres:</label></td>
                <td><input type="text" name="nombre" required></td>
            </tr>
            <tr>
                <td><label>Apellidos:</label></td>
                <td><input type="text" name="apellido" required></td>
            </tr>
            <tr>
                <td><label>Centro de Costo:</label></td>
                <td>
                    <select name="centro_costo" required>
                        <option value="Administracion">Administración</option>
                        <option value="Operaciones">Operaciones</option>
                        <option value="Ventas">Ventas</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>Cargo:</label></td>
                <td><input type="text" name="cargo" required></td>
            </tr>
            <tr>
                <td><label>Salario Base:</label></td>
                <td><input type="number" name="salario_base" step="0.01" min="0" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="btn_registrar">Registrar Empleado</button>
                </td>
            </tr>
        </table>
    </form>

</body>

</html>