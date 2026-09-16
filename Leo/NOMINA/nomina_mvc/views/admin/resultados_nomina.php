<?php require_once '../../controllers/seguridad_admin.php'; ?>
<?php
// views/admin/resultados_nomina.php
session_start();

// Validamos usando isset() que existan datos calculados en la memoria
if (!isset($_SESSION['ultima_nomina'])) {
    die("No hay datos de nómina recientes para mostrar. Por favor, calcule la nómina primero.");
}

$nominas = $_SESSION['ultima_nomina'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resultados de Nómina</title>
</head>

<body>
    <h2>Nómina Mensual Calculada</h2>

    <p>Los cálculos se han guardado exitosamente en el historial de la base de datos.</p>

    <table border="1">
        <thead>
            <tr>
                <th>Cédula</th>
                <th>Empleado</th>
                <th>Total Devengado</th>
                <th>Deducciones Ley (Salud/Pensión)</th>
                <th>Cuota Préstamo Descontada</th>
                <th>Neto a Pagar</th>
                <th>Costo Empresa</th>
            </tr>
        </thead>
        <tbody>
            <!-- Recorremos la lista dinámica de resultados[cite: 1] -->
            <?php foreach ($nominas as $nom): ?>
            <tr>
                <td><?= $nom['empleado']['cedula'] ?></td>
                <td><?= $nom['empleado']['nombre'] . ' ' . $nom['empleado']['apellido'] ?></td>
                <td>$<?= number_format($nom['devengado'], 2) ?></td>

                <!-- Restamos la cuota del total de deducciones para mostrar solo la ley -->
                <td>$<?= number_format($nom['deducciones'] - $nom['cuota_prestamo'], 2) ?></td>

                <td>$<?= number_format($nom['cuota_prestamo'], 2) ?></td>
                <td><b>$<?= number_format($nom['neto'], 2) ?></b></td>
                <td>$<?= number_format($nom['costo_empresa'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <!-- Botón para ir al generador de PDF -->
    <a href="generar_pdf.php?id=<?= $nom['empleado']['id_empleado'] ?>">Descargar PDF Individual</a>
    <a href="generar_pdf.php" target="_blank">Descargar Desprendibles en PDF</a> |
    <a href="listar_empleados.php">Volver al inicio</a>
</body>

</html>