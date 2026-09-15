<?php 
require_once '../../controllers/seguridad_admin.php';
require_once '../../controllers/ListarEmpleadoController.php'; 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Empleados</title>
</head>

<body>
    <h2>Listado General de Empleados</h2>

    <?php if (!empty($mensaje_accion)): ?>
    <p><strong><?= $mensaje_accion ?></strong></p>
    <?php endif; ?>

    <p>
        <a href="registrar_empleado.php">Registrar Nuevo Empleado</a> |
        <a href="../../logout.php">Cerrar Sesion</a>
    </p>

    <table border="1">
        <thead>
            <tr>
                <th>Cedula</th>
                <th>Nombre y Apellido</th>
                <th>Cargo</th>
                <th>Salario Base</th>
                <th>Estado Nomina (Mes Actual)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($listaEmpleados)): ?>
            <tr>
                <td colspan="6">No hay empleados registrados.</td>
            </tr>
            <?php else: ?>
            <?php foreach ($listaEmpleados as $empleado): ?>
            <tr>
                <td><?= $empleado['cedula'] ?></td>
                <td><?= $empleado['nombre'] ?> <?= $empleado['apellido'] ?></td>
                <td><?= $empleado['cargo'] ?></td>
                <td>$<?= number_format($empleado['salario_base'], 2) ?></td>

                <td>
                    <?php if ($empleado['nomina_calculada']): ?>
                    <b>Calculada</b>
                    <?php else: ?>
                    <b>Pendiente</b>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="editar_empleado.php?id=<?= $empleado['id_empleado'] ?>">Editar</a> |
                    <a href="listar_empleados.php?eliminar=<?= $empleado['id_empleado'] ?>"
                        onclick="return confirm('Seguro de eliminar?');">Eliminar</a> |

                    <?php if ($empleado['prestamo_activo']): ?>
                    <a href="asignar_prestamo.php?id=<?= $empleado['id_empleado'] ?>">Prestamo en curso</a> |
                    <?php else: ?>
                    <a href="asignar_prestamo.php?id=<?= $empleado['id_empleado'] ?>">Asignar Prestamo</a> |
                    <?php endif; ?>

                    <?php if ($empleado['nomina_calculada']): ?>
                    <a href="generar_pdf.php?id=<?= $empleado['id_empleado'] ?>">Descargar PDF</a>
                    <?php else: ?>
                    <a href="generar_nomina.php?id=<?= $empleado['id_empleado'] ?>">Liquidar</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>