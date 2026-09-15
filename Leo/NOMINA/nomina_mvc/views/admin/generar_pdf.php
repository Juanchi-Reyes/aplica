<?php
// views/admin/generar_pdf.php
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../models/Empleado.php';
require_once __DIR__ . '/../../models/Nomina.php';
require_once '../../dompdf/autoload.inc.php';

use Dompdf\Dompdf;

if (!isset($_GET['id'])) {
    die("Error: No se especificó el empleado.");
}

$id_empleado = $_GET['id'];
$modeloEmpleado = new Empleado($conexion);
$modeloNomina = new Nomina($conexion);

$empleado = $modeloEmpleado->obtenerPorId($id_empleado);
$nomina = $modeloNomina->obtenerUltimaNomina($id_empleado);

if (!$empleado || !$nomina) {
    die("No hay registros de nómina para este empleado en la base de datos.");
}

// === DESCOMPRESIÓN MATEMÁTICA PARA EL REPORTE DETALLADO ===
define('SMLV', 1750905);
define('AUXILIO_TRANSPORTE', 249095);

$sueldo = $empleado['salario_base'];
$dias = $nomina['dias_laborados'];
$dias_eps = $nomina['dias_incapacidad_eps'];
$dias_arl = $nomina['dias_incapacidad_arl'];

// Devengados detallados
$salario_prop = ($sueldo / 30) * $dias;
$incapacidad_eps = ($sueldo / 30) * $dias_eps * 0.6667; 
$incapacidad_arl = ($sueldo / 30) * $dias_arl * 1.0; 

$valor_hora = $sueldo / 240;
$recargo_noct = $valor_hora * $nomina['recargo_nocturno_horas'] * 0.35;
$recargo_dom = $valor_hora * $nomina['horas_dominicales'] * 1.75;
$auxilio_trans = ($sueldo <= (SMLV * 2)) ? (AUXILIO_TRANSPORTE / 30) * $dias : 0;

// Deducciones detalladas
$ibc = $nomina['total_devengado'] - $auxilio_trans;
$salud = $ibc * 0.04;
$pension = $ibc * 0.04;
$fondo_sol = ($ibc >= (SMLV * 4)) ? $ibc * 0.01 : 0;

// Costo Empresa (Provisiones y Aportes)
$prima = $ibc * 0.0833;
$cesantias = $ibc * 0.0833;
$int_cesantias = $cesantias * 0.12;
$vacaciones = $sueldo * 0.0417;
$emp_pension = $ibc * 0.12;
$emp_arl = $ibc * 0.00522;
$emp_ccf = $ibc * 0.04;
$total_costo_empresa = $nomina['total_devengado'] + $prima + $cesantias + $int_cesantias + $vacaciones + $emp_pension + $emp_arl + $emp_ccf;

// Iniciamos Output Buffering sin imprimir echo[cite: 1]
ob_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Comprobante de Nómina</title>
</head>

<body>
    <h2>COMPROBANTE DE NÓMINA INDIVIDUAL (DETALLADO)</h2>
    <p>Periodo Liquidado: Mes <?= $nomina['mes'] ?> del Año <?= $nomina['anio'] ?></p>

    <h3>1. INFORMACIÓN DEL TRABAJADOR</h3>
    <table border="1" width="100%" cellpadding="5">
        <tr>
            <th align="left">Cédula:</th>
            <td><?= $empleado['cedula'] ?></td>
            <th align="left">Nombre:</th>
            <td><?= $empleado['nombre'] ?> <?= $empleado['apellido'] ?></td>
        </tr>
        <tr>
            <th align="left">Cargo:</th>
            <td><?= $empleado['cargo'] ?></td>
            <th align="left">Salario Base Contratado:</th>
            <td>$<?= number_format($sueldo, 2) ?></td>
        </tr>
    </table>

    <br>
    <h3>2. DETALLE DE INGRESOS (Lo que recibe)</h3>
    <table border="1" width="100%" cellpadding="5">
        <tr>
            <th align="left">Concepto</th>
            <th align="left">Cantidad / Base</th>
            <th align="right">Valor Calculado</th>
        </tr>
        <tr>
            <td>Salario Proporcional a Días Trabajados</td>
            <td><?= $dias ?> días</td>
            <td align="right">$<?= number_format($salario_prop, 2) ?></td>
        </tr>
        <tr>
            <td>Pago Incapacidad EPS (Enfermedad Común)</td>
            <td><?= $dias_eps ?> días al 66.67%</td>
            <td align="right">$<?= number_format($incapacidad_eps, 2) ?></td>
        </tr>
        <tr>
            <td>Pago Incapacidad ARL (Riesgo Laboral)</td>
            <td><?= $dias_arl ?> días al 100%</td>
            <td align="right">$<?= number_format($incapacidad_arl, 2) ?></td>
        </tr>
        <tr>
            <td>Recargos Nocturnos</td>
            <td><?= $nomina['recargo_nocturno_horas'] ?> hrs (35% extra)</td>
            <td align="right">$<?= number_format($recargo_noct, 2) ?></td>
        </tr>
        <tr>
            <td>Horas Dominicales</td>
            <td><?= $nomina['horas_dominicales'] ?> hrs (175% extra)</td>
            <td align="right">$<?= number_format($recargo_dom, 2) ?></td>
        </tr>
        <tr>
            <td>Auxilio de Transporte (Por Ley)</td>
            <td><?= $dias ?> días proporcionales</td>
            <td align="right">$<?= number_format($auxilio_trans, 2) ?></td>
        </tr>
        <tr>
            <th colspan="2" align="right">SUBTOTAL INGRESOS BRUTOS:</th>
            <th align="right">$<?= number_format($nomina['total_devengado'], 2) ?></th>
        </tr>
    </table>

    <br>
    <h3>3. DETALLE DE DESCUENTOS (Lo que se le quita)</h3>
    <table border="1" width="100%" cellpadding="5">
        <tr>
            <th align="left">Concepto</th>
            <th align="left">Fórmula Aplicada</th>
            <th align="right">Valor Descontado</th>
        </tr>
        <tr>
            <td>Salud (Aporte Empleado)</td>
            <td>4% del Ingreso Base</td>
            <td align="right">$<?= number_format($salud, 2) ?></td>
        </tr>
        <tr>
            <td>Pensión (Aporte Empleado)</td>
            <td>4% del Ingreso Base</td>
            <td align="right">$<?= number_format($pension, 2) ?></td>
        </tr>
        <tr>
            <td>Fondo de Solidaridad Pensional</td>
            <td>1% (Solo si supera 4 SMLV)</td>
            <td align="right">$<?= number_format($fondo_sol, 2) ?></td>
        </tr>
        <tr>
            <td>Abono Automático a Préstamo</td>
            <td>Cuota según tabla de amortización</td>
            <td align="right">$<?= number_format($nomina['valor_cuota_prestamo'], 2) ?></td>
        </tr>
        <tr>
            <th colspan="2" align="right">SUBTOTAL DESCUENTOS:</th>
            <th align="right">$<?= number_format($nomina['total_deducciones'], 2) ?></th>
        </tr>
    </table>

    <br>
    <table border="1" width="100%" cellpadding="5">
        <tr>
            <th align="right" width="70%">NETO A PAGAR (CONSIGNACIÓN BANCARIA):</th>
            <th align="right" width="30%">$<?= number_format($nomina['neto_pagar'], 2) ?></th>
        </tr>
    </table>

    <br>
    <hr>
    <h3>4. TOTAL COSTO EMPRESA (Información Interna)</h3>
    <table border="1" width="100%" cellpadding="5">
        <tr>
            <th align="left">Aportes y Provisiones a Cargo del Empleador</th>
            <th align="right">Valor Mensual Provisionado</th>
        </tr>
        <tr>
            <td>Prima de Servicios (8.33%)</td>
            <td align="right">$<?= number_format($prima, 2) ?></td>
        </tr>
        <tr>
            <td>Cesantías (8.33%)</td>
            <td align="right">$<?= number_format($cesantias, 2) ?></td>
        </tr>
        <tr>
            <td>Intereses a Cesantías (12% de las Cesantías)</td>
            <td align="right">$<?= number_format($int_cesantias, 2) ?></td>
        </tr>
        <tr>
            <td>Provisión Vacaciones (4.17% del salario)</td>
            <td align="right">$<?= number_format($vacaciones, 2) ?></td>
        </tr>
        <tr>
            <td>Pensión Empleador (12%)</td>
            <td align="right">$<?= number_format($emp_pension, 2) ?></td>
        </tr>
        <tr>
            <td>ARL Nivel 1 (0.522%)</td>
            <td align="right">$<?= number_format($emp_arl, 2) ?></td>
        </tr>
        <tr>
            <td>Caja de Compensación Familiar (4%)</td>
            <td align="right">$<?= number_format($emp_ccf, 2) ?></td>
        </tr>
        <tr>
            <th align="right">COSTO TOTAL REAL DE ESTE EMPLEADO EN EL MES:</th>
            <th align="right">$<?= number_format($total_costo_empresa, 2) ?></th>
        </tr>
    </table>

</body>

</html>
<?php
$html = ob_get_clean();
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Detalle_Nomina_" . $empleado['cedula'] . ".pdf", ["Attachment" => true]);
exit;
?>