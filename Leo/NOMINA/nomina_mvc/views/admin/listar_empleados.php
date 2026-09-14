<?php
// vista de listar_empleados
// Traemos el controlador
require_once '../../controllers/ListarEmpleadoController.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Empleados - Nómina</title>
</head>

<body>

    <h2>Listado de Empleados</h2>

    <!-- Mostrar mensajes de éxito o error -->
    <?php if (!empty($mensaje_accion)): ?>
    <p><strong><?= $mensaje_accion ?></strong></p>
    <?php endif; ?>

    <p><a href="registrar_empleado.php">Registrar Nuevo Empleado</a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cédula</th>
                <th>Rol</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Centro Costo</th>
                <th>Cargo</th>
                <th>Salario Base</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Si la lista está vacía, mostramos un mensaje, si no, recorremos el array -->
            <?php if (empty($listaEmpleados)): ?>
            <tr>
                <td colspan="9">No hay empleados registrados en la base de datos.</td>
            </tr>
            <?php else: ?>
            <?php foreach ($listaEmpleados as $empleado): ?>
            <tr>
                <td><?= $empleado['id_empleado'] ?></td>
                <td><?= $empleado['cedula'] ?></td>
                <td><?= $empleado['rol'] ?></td>
                <td><?= $empleado['nombre'] ?></td>
                <td><?= $empleado['apellido'] ?></td>
                <td><?= $empleado['centro_costo'] ?></td>
                <td><?= $empleado['cargo'] ?></td>
                <!-- number_format para que el dinero se vea con buen formato -->
                <td>$<?= number_format($empleado['salario_base'], 2) ?></td>
                <td>
                    <!-- Botones Editar y Eliminar -->
                    <a href="editar_empleado.php?id=<?= $empleado['id_empleado'] ?>">Editar</a> |
                    <!-- Enviamos la petición de eliminar -->
                    <a href="listar_empleados.php?eliminar=<?= $empleado['id_empleado'] ?>"
                        onclick="return confirm('¿Estás seguro de eliminar a este empleado?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>