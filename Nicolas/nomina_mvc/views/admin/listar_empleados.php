<?php
require_once '../../controllers/seguridad_admin.php';
require_once '../../controllers/ListarEmpleadoController.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Empleados</title>
    <link rel="stylesheet" href="../../css/estilo.css">
</head>

<body>
    <h2>Listado General de Empleados</h2>

    <?php if (!empty($mensaje_accion)): ?>
    <p><strong><?= htmlspecialchars($mensaje_accion) ?></strong></p>
    <?php endif; ?>

    <p>
        <a href="registrar_empleado.php">Registrar Nuevo Empleado</a> |
        <a href="../../logout.php">Cerrar Sesion</a>
    </p>

    <table border="1">
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Nombre Completo</th>
                <th>Cargo</th>
                <th>Centro de Costo</th>
                <th>Salario Base</th>
                <th>Estado Nómina</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($listaEmpleados)): ?>
            <tr>
                <td colspan="7">No hay empleados registrados.</td>
            </tr>
            <?php else: ?>
            <?php foreach ($listaEmpleados as $empleado): ?>
            <tr>
                <td><?= htmlspecialchars($empleado['numero_identificacion']) ?></td>
                <td><?= htmlspecialchars($empleado['nombre_completo']) ?></td>
                <td><?= htmlspecialchars($empleado['nombre_cargo']) ?></td>
                <td><?= htmlspecialchars($empleado['nombre_centro_costo']) ?></td>
                <td>$<?= number_format($empleado['sueldo_base'], 2) ?></td>

                <td>
                    <?php if ($empleado['nomina_calculada']): ?>
                    <span>Validada</span>
                    <?php else: ?>
                    <span>Pendiente</span>
                    <?php endif; ?>
                </td>

                <td>
                    <!-- ¡AQUÍ ESTÁ EL NUEVO BOTÓN VER! -->
                    <a href="ver_empleado.php?id=<?= $empleado['id_usuario'] ?>">Ver</a> |

                    <a href="editar_empleado.php?id=<?= $empleado['id_usuario'] ?>">Editar</a> |
                    <a href="listar_empleados.php?eliminar=<?= $empleado['id_usuario'] ?>"
                        onclick="return confirm('¿Seguro de eliminar?');">Eliminar</a> |

                    <?php if ($empleado['prestamo_activo']): ?>
                    <a href="asignar_prestamo.php?id=<?= $empleado['id_usuario'] ?>">Préstamo en curso</a> |
                    <?php else: ?>
                    <a href="asignar_prestamo.php?id=<?= $empleado['id_usuario'] ?>">Asignar Préstamo</a> |
                    <?php endif; ?>

                    <?php if ($empleado['nomina_calculada']): ?>
                    <a href="generar_pdf.php?id=<?= $empleado['id_usuario'] ?>" target="_blank">
                        <button type="button">pdf</button>
                    </a>
                    <?php else: ?>
                    <a href="generar_nomina.php?id=<?= $empleado['id_usuario'] ?>">Liquidar</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>