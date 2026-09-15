<?php require_once '../../controllers/seguridad_admin.php'; ?>
<?php require_once '../../controllers/EditarEmpleadoController.php'; ?>

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

    <?php if (!empty($empleado)): ?>
    <form action="editar_empleado.php" method="POST">
        <input type="hidden" name="id_empleado" value="<?= $empleado['id_empleado'] ?>">

        <table border="1">
            <tr>
                <td><label>Número de Identificación:</label></td>
                <td><input type="text" name="numero_identificacion" value="<?= $empleado['numero_identificacion'] ?>"
                        required></td>
            </tr>
            <tr>
                <td><label>Nombre Completo:</label></td>
                <td><input type="text" name="nombre_completo" value="<?= $empleado['nombre_completo'] ?>" required></td>
            </tr>
            <tr>
                <td><label>Centro de Costo:</label></td>
                <td>
                    <select name="id_centro_costo" required>
                        <option value="1" <?= $empleado['id_centro_costo'] == 1 ? 'selected' : '' ?>>Administración
                        </option>
                        <option value="2" <?= $empleado['id_centro_costo'] == 2 ? 'selected' : '' ?>>Operaciones
                        </option>
                        <option value="3" <?= $empleado['id_centro_costo'] == 3 ? 'selected' : '' ?>>Ventas</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>Cargo:</label></td>
                <td>
                    <select name="id_cargo" required>
                        <option value="1" <?= $empleado['id_cargo'] == 1 ? 'selected' : '' ?>>Gerente</option>
                        <option value="2" <?= $empleado['id_cargo'] == 2 ? 'selected' : '' ?>>Asistente</option>
                        <option value="3" <?= $empleado['id_cargo'] == 3 ? 'selected' : '' ?>>Vendedor</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>Salario Base:</label></td>
                <td><input type="number" name="sueldo_base" value="<?= $empleado['sueldo_base'] ?>" step="0.01" min="0"
                        required></td>
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