<?php
session_start();
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/empleados/funcionesCrud.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: auth/login.php');
    exit;
}

$resultado = listarEmpleados($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del administrador - Gestión de Nómina</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor-panel">
        <header class="encabezado-panel">
            <h1>Gestión de Nómina</h1>
            <div class="usuario-sesion">
                <span>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?></span>
                <a href="auth/logout.php" class="boton boton-secundario">Cerrar sesión</a>
            </div>
        </header>

        <main>
            <?php if (isset($_GET['exito'])): ?>
            <div class="alerta alerta-exito">Empleado registrado correctamente.</div>
            <?php endif; ?>
            <div style="margin-bottom: 16px;">
                <a href="empleados/insertar_empleado.php" class="boton boton-primario">+ Insertar empleado</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th><th>Identificación</th><th>Nombre</th><th>Cargo</th>
                        <th>Centro de costo</th><th>Sueldo base</th><th>Fecha ingreso</th>
                        <th>Estado</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado->num_rows === 0): ?>
                        <tr><td colspan="9">No hay empleados registrados.</td></tr>
                    <?php else: ?>
                        <?php while ($emp = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?= $emp['id_empleado'] ?></td>
                                <td><?= htmlspecialchars($emp['numero_identificacion']) ?></td>
                                <td><?= htmlspecialchars($emp['nombre_completo']) ?></td>
                                <td><?= htmlspecialchars($emp['nombre_cargo']) ?></td>
                                <td><?= htmlspecialchars($emp['centro_costo']) ?></td>
                                <td><?= number_format($emp['sueldo_base'], 2) ?></td>
                                <td><?= $emp['fecha_ingreso'] ?></td>
                                <td><?= $emp['estado'] ?></td>
                                <td>
                                    <a href="empleados/editar_empleado.php?id=<?= $emp['id_empleado'] ?>" class="boton boton-secundario">Modificar</a>
                                    <a href="empleados/eliminar_empleado.php?id=<?= $emp['id_empleado'] ?>"
                                       class="boton boton-secundario"
                                       onclick="return confirm('¿Eliminar a <?= htmlspecialchars($emp['nombre_completo']) ?>?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>

    </div>
</body>
</html>