<?php require_once '../../controllers/seguridad_admin.php'; ?>
<?php require_once '../../controllers/NominaController.php'; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Generar Nomina Individual</title>
</head>

<body>
    <h2>Liquidar Nomina por Empleado</h2>

    <?php if (!empty($mensaje)): ?>
    <p><strong><?= $mensaje ?></strong></p>
    <?php endif; ?>

    <p><a href="listar_empleados.php">Ver listado de empleados</a></p>

    <?php if ($empleado_seleccionado): ?>
    <form action="generar_nomina.php" method="POST">
        <input type="hidden" name="id_empleado" value="<?= $empleado_seleccionado['id_empleado'] ?>">

        <table border="0">
            <tr>
                <td><label>Empleado:</label></td>
                <td>
                    <b><?= $empleado_seleccionado['numero_identificacion'] ?> -
                        <?= $empleado_seleccionado['nombre_completo'] ?></b>
                </td>
            </tr>
            <tr>
                <td><label>Dias Laborados:</label></td>
                <td><input type="number" name="dias_laborados" value="30" max="30" min="0" required></td>
            </tr>
            <tr>
                <td><label>Dias Incapacidad EPS:</label></td>
                <td><input type="number" name="dias_eps" value="0" min="0"></td>
            </tr>
            <tr>
                <td><label>Dias Incapacidad ARL:</label></td>
                <td><input type="number" name="dias_arl" value="0" min="0"></td>
            </tr>
            <tr>
                <td><label>Horas Recargo Nocturno:</label></td>
                <td><input type="number" name="horas_nocturnas" value="0" min="0"></td>
            </tr>
            <tr>
                <td><label>Horas Dominicales:</label></td>
                <td><input type="number" name="horas_dominicales" value="0" min="0"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="btn_calcular_nomina">Calcular y Guardar</button>
                </td>
            </tr>
        </table>
    </form>
    <?php endif; ?>
</body>

</html>