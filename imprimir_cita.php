<?php
require 'dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

include("controller.php");

// Obtener ID y tipo desde la URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'solicitud';

$data = getCitaForPDF($id, $tipo);

if (empty($data)) {
    exit("Cita o solicitud no encontrada.");
}


$html = '
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    h1 { text-align: center; margin-bottom: 20px; }
    .section { margin-bottom: 15px; }
    .section-title { font-weight: bold; margin-bottom: 8px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #333; padding: 6px; }
    th { background: #f0f0f0; }
  </style>
</head>
<body>
  <h1>Solicitud de Cita #'.htmlspecialchars($data['solicitud_id']).'</h1>

<div class="section">
    <div class="section-title">Solicitante</div>
    <p>'.htmlspecialchars($data['solicitante_nombre']).'</p>
  </div>

  <div class="section">
    <div class="section-title">Datos del Cliente</div>
    <table>
      <tr><th>Nombre</th>   <td>'.htmlspecialchars($data['cliente']).'</td></tr>
      <tr><th>Email</th>    <td>'.htmlspecialchars($data['cliente_email']).'</td></tr>
      <tr><th>Teléfono</th> <td>'.htmlspecialchars($data['cliente_telefono']).'</td></tr>
    </table>
  </div>

  <div class="section">
    <div class="section-title">Datos del Vehículo</div>
    <table>
      <tr><th>Marca</th>     <td>'.htmlspecialchars($data['vehiculo_marca']).'</td></tr>
      <tr><th>Modelo</th>    <td>'.htmlspecialchars($data['vehiculo_modelo']).'</td></tr>
      <tr><th>Año</th>       <td>'.htmlspecialchars($data['vehiculo_anio']).'</td></tr>
      <tr><th>Matrícula</th> <td>'.htmlspecialchars($data['vehiculo_matricula']).'</td></tr>
    </table>
  </div>

  <div class="section">
    <div class="section-title">Detalles de la Solicitud</div>
    <table>
      <tr><th>Fecha Solicitada</th> <td>'.htmlspecialchars($data['fecha_solicitada']).'</td></tr>
      <tr><th>Estado Solicitud</th> <td>'.htmlspecialchars($data['estado_solicitud']).'</td></tr>
      <tr><th>Descripción</th>      <td>'.nl2br(htmlspecialchars($data['descripcion_solicitud'])).'</td></tr>
    </table>
  </div>

  <div class="section">
    <div class="section-title">Datos de Atención</div>
    <table>
      <tr><th>Fecha Atención</th>     <td>'.htmlspecialchars($data['fecha_atencion'] ?: 'N/A').'</td></tr>
      <tr><th>Estado Cita</th>        <td>'.htmlspecialchars($data['estado_cita'] ?: 'N/A').'</td></tr>
      <tr><th>Descripción Cita</th>   <td>'.nl2br(htmlspecialchars($data['descripcion_cita'])).'</td></tr>
      <tr><th>Veredicto Mecánico</th> <td>'.nl2br(htmlspecialchars($data['veredicto_mecanico'])).'</td></tr>
      <tr><th>Mecánico</th>           <td>'.htmlspecialchars($data['mecanico_nombre'] ?: 'No asignado').'</td></tr>
    </table>
  </div>
</body>
</html>
';

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Limpia la salida y envía el PDF
if (ob_get_length()) ob_end_clean();
$dompdf->stream("cita_{$id}.pdf", ["Attachment" => true]);
exit;
