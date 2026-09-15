<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/funcionesCrud.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../auth/login.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_identificacion = trim($_POST['numero_identificacion']);
    $nombre_completo       = trim($_POST['nombre_completo']);
    $id_cargo              = $_POST['id_cargo'];
    $id_centro_costo       = $_POST['id_centro_costo'];
    $sueldo_base           = $_POST['sueldo_base'];
    $fecha_ingreso         = $_POST['fecha_ingreso'];

    $resultado = insertarEmpleado($conexion, $numero_identificacion, $nombre_completo, $id_cargo, $id_centro_costo, $sueldo_base, $fecha_ingreso);

    if ($resultado === true) {
            header('Location: ../index.php?exito=1');
        exit;
    } else {
        $error = 'Error al registrar: ' . $resultado;
    }
}

$cargos  = obtenerCargos($conexion);
$centros = obtenerCentrosCosto($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Insertar empleado</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor-panel">
        <header class="encabezado-panel">
            <h1>Insertar empleado</h1>
            <a href="../index.php" class="boton boton-secundario">Volver</a>
        </header>
        <main class="tarjeta">
            <?php if ($error): ?><div class="alerta alerta-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
            <form method="POST">
                <div class="campo"><label>Número de identificación</label>
                    <input type="text" name="numero_identificacion" required></div>
                <div class="campo"><label>Nombre completo</label>
                    <input type="text" name="nombre_completo" required></div>
                <div class="campo"><label>Cargo</label>
                    <select name="id_cargo" required>
                        <option value="">Seleccione...</option>
                        <?php while ($c = $cargos->fetch_assoc()): ?>
                            <option value="<?= $c['id_cargo'] ?>"><?= htmlspecialchars($c['nombre_cargo']) ?></option>
                        <?php endwhile; ?>
                    </select></div>
                <div class="campo"><label>Centro de costo</label>
                    <select name="id_centro_costo" required>
                        <option value="">Seleccione...</option>
                        <?php while ($c = $centros->fetch_assoc()): ?>
                            <option value="<?= $c['id_centro_costo'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                        <?php endwhile; ?>
                    </select></div>
                <div class="campo"><label>Sueldo base</label>
                    <input type="number" step="0.01" name="sueldo_base" required></div>
                <div class="campo"><label>Fecha de ingreso</label>
                    <input type="date" name="fecha_ingreso" required></div>
                <button type="submit" class="boton boton-primario boton-bloque">Guardar</button>
            </form>
        </main>
    </div>
</body>
</html>