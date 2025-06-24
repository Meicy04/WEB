<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data || !isset($data['horario'])) {
    http_response_code(400);
    exit('Datos inválidos');
}

require_once('tcpdf/tcpdf.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SCENet');
$pdf->SetTitle('Horario Escolar');
$pdf->SetSubject('Horario de Clases');
$pdf->SetKeywords('horario, clases, escuela');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$html = '
<style>
    h1 {
        color: #003366;
        text-align: center;
        font-size: 18pt;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th {
        background-color: #003366;
        color: white;
        font-weight: bold;
        padding: 5px;
        border: 1px solid #003366;
    }
    td {
        padding: 5px;
        border: 1px solid #003366;
    }
    .header-info {
        margin-bottom: 20px;
        font-size: 12pt;
    }
</style>

<h1>HORARIO ESCOLAR</h1>
<div class="header-info">
    <strong>Alumno:</strong> '.htmlspecialchars($data['usuario']).'<br>
    <strong>Fecha:</strong> '.date('d/m/Y').'
</div>

<table>
    <tr>
        <th width="40%">Materia</th>
        <th width="15%">Grupo</th>
        <th width="30%">Horario</th>
        <th width="15%">Créditos</th>
    </tr>';

foreach ($data['horario'] as $materia) {
    $html .= '
    <tr>
        <td>'.htmlspecialchars($materia['nombre']).'</td>
        <td>'.htmlspecialchars($materia['grupo'] ?? '').'</td>
        <td>'.htmlspecialchars($materia['horario']).'</td>
        <td>'.htmlspecialchars($materia['creditos'] ?? '').'</td>
    </tr>';
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('horario_'.$data['usuario'].'.pdf', 'D');
exit;
?>