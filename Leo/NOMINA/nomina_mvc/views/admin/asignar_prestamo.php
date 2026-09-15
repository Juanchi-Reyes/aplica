<?php 
// vista de asignar prestamo a empleado
require_once '../../controllers/seguridad_admin.php'; 
require_once '../../controllers/PrestamoController.php'; // Procesamos la lógica arriba[cite: 1]
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Asignar Préstamo</title>
</head>

<body>
    <h2>Asignar Préstamo a Empleado</h2>

    <?php if (!empty($mensaje)): ?>
    <p><strong><?= $mensaje ?></strong></p>
    <?php endif; ?>

    <p><a href="listar_empleados.php">Volver a la lista de empleados</a></p>

    <form action="asignar_prestamo.php" method="POST">
        <table border="0">
            <tr>
                <td><label>Seleccionar Empleado:</label></td>
                <td>
                    <select name="id_empleado" required>
                        <option value="">-- Seleccione un empleado --</option>
                        <?php foreach ($listaEmpleados as $emp): ?>
                        <option value="<?= $emp['id_empleado'] ?>">
                            <?= $emp['cedula'] ?> - <?= $emp['nombre'] ?> <?= $emp['apellido'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>Monto Total del Préstamo ($):</label></td>
                <td><input type="number" name="monto_total" step="0.01" min="1" required></td>
            </tr>
            <tr>
                <td><label>Número de Cuotas Mensuales:</label></td>
                <td><input type="number" name="cuotas_totales" min="1" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="submit" name="btn_asignar_prestamo">Guardar Préstamo</button>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>