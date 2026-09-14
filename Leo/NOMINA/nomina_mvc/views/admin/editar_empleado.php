<?php
// views/admin/editar_empleado.php
require_once '../../controllers/EditarEmpleadoController.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Empleado - Nómina</title>
</head>

<body>

    <h2>Editar Datos del Empleado</h2>

    <?php if (!empty($mensaje)): ?>
    <p><strong><?= $mensaje ?></strong></p>
    <?php endif; ?>

    <p><a href="listar_empleados.php">Volver a la lista</a></p>

    <!-- Solo mostramos el formulario si el empleado existe en la base de datos -->
    <?php if ($empleado): ?>
    <form action="editar_empleado.php" method="POST">

        <!-- Input oculto indispensable para enviar el ID al controlador por POST -->
        <input type="hidden" name="id_empleado" value="<?= $empleado['id_empleado'] ?>">

        <table border="1">
            <tr>
                <td><label>Cédula:</label></td>
                <td><input type="text" name="cedula" value="<?= $empleado['cedula'] ?>" required></td>
            </tr>
            <tr>
                <td><label>Nombres:</label></td>
                <td><input type="text" name="nombre" value="<?= $empleado['nombre'] ?>" required></td>
            </tr>
            <tr>
                <td><label>Apellidos:</label></td>
                <td><input type="text" name="apellido" value="<?= $empleado['apellido'] ?>" required></td>
            </tr>
            <tr>
                <td><label>Centro de Costo:</label></td>
                <td>
                    <select name="centro_costo" required>
                        <!-- Usamos condicionales cortos para marcar la opción que el usuario ya tenía -->
                        <option value="Administracion"
                            <?= $empleado['centro_costo'] == 'Administracion' ? 'selected' : '' ?>>Administración
                        </option>
                        <option value="Operaciones" <?= $empleado['centro_costo'] == 'Operaciones' ? 'selected' : '' ?>>
                            Operaciones</option>
                        <option value="Ventas" <?= $empleado['centro_costo'] == 'Ventas' ? 'selected' : '' ?>>Ventas
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>Cargo:</label></td>
                <td><input type="text" name="cargo" value="<?= $empleado['cargo'] ?>" required></td>
            </tr>
            <tr>
                <td><label>Salario Base:</label></td>
                <td><input type="number" name="salario_base" value="<?= $empleado['salario_base'] ?>" step="0.01"
                        min="0" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="btn_actualizar">Guardar Cambios</button>
                </td>
            </tr>
        </table>
    </form>
    <?php endif; ?>

</body>

</html>