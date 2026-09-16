<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/funcionesCrud.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../auth/login.php');
    exit;
}

$id = $_GET['id'] ?? $_POST['id_empleado'] ?? null;
if (!$id) { header('Location: ../index.php'); exit; }

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_identificacion = trim($_POST['numero_identificacion']);
    $nombre_completo       = trim($_POST['nombre_completo']);
    $id_cargo              = $_POST['id_cargo'];
    $id_centro_costo       = $_POST['id_centro_costo'];
    $sueldo_base           = $_POST['sueldo_base'];
    $fecha_ingreso         = $_POST['fecha_ingreso'];

    $resultado = actualizarEmpleado($conexion, $id, $numero_identificacion, $nombre_completo, $id_cargo, $id_centro_costo, $sueldo_base, $fecha_ingreso);

    if ($resultado === true) {
        header('Location: ../index.php');
        exit;
    } else {
        $error = 'Error al actualizar: ' . $resultado;
    }
}

$emp = obtenerEmpleado($conexion, $id);
if (!$emp) { header('Location: ../index.php'); exit; }

$cargos  = obtenerCargos($conexion);
$centros = obtenerCentrosCosto($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar empleado</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="contenedor-panel">
        <header class="encabezado-panel">
            <h1>Modificar empleado</h1>
            <a href="../index.php" class="boton boton-secundario">Volver</a>
        </header>
        <main class="tarjeta">
            <?php if ($error): ?><div class="alerta alerta-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
            <form method="POST">
                <div class="campo"><label>Número de identificación</label>
                    <input type="text" name="numero_identificacion" value="<?= htmlspecialchars($emp['numero_identificacion']) ?>" required></div>
                <div class="campo"><label>Nombre completo</label>
                    <input type="text" name="nombre_completo" value="<?= htmlspecialchars($emp['nombre_completo']) ?>" required></div>
                <div class="campo"><label>Cargo</label>
                    <select name="id_cargo" required>
                        <?php while ($c = $cargos->fetch_assoc()): ?>
                            <option value="<?= $c['id_cargo'] ?>" <?= $c['id_cargo']==$emp['id_cargo']?'selected':'' ?>><?= htmlspecialchars($c['nombre_cargo']) ?></option>
                        <?php endwhile; ?>
                    </select></div>
                <div class="campo"><label>Centro de costo</label>
                    <select name="id_centro_costo" required>
                        <?php while ($c = $centros->fetch_assoc()): ?>
                            <option value="<?= $c['id_centro_costo'] ?>" <?= $c['id_centro_costo']==$emp['id_centro_costo']?'selected':'' ?>><?= htmlspecialchars($c['nombre']) ?></option>
                        <?php endwhile; ?>
                    </select></div>
                <div class="campo"><label>Sueldo base</label>
                    <input type="number" step="0.01" name="sueldo_base" value="<?= $emp['sueldo_base'] ?>" required></div>
                <div class="campo"><label>Fecha de ingreso</label>
                    <input type="date" name="fecha_ingreso" value="<?= $emp['fecha_ingreso'] ?>" required></div>
                <button type="submit" class="boton boton-primario boton-bloque">Actualizar</button>
            </form>
        </main>
    </div>
</body>
</html>