<?php
require 'C:/laragon/www/sis-medico/vendor/autoload.php';
include "../../conexion.php";
use Dompdf\Dompdf;
$query = mysqli_query($conexion, "SELECT id, nombre_paciente, edad, fecha_examen FROM registrar_examen ORDER BY id");
$result = mysqli_num_rows($query);

$html = '
<html lang="es">
<head>
<meta charset="utf-8">
<style>
    body {
        font-family: Arial, sans-serif;
    }
    h1 {
        color: red;
        text-align: center;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #333;
        padding: 8px;
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
</head>
<body>
    <h1>Documento generado</h1>
    <p>Este es un ejemplo para la creacion del documento en PDF para un servicio mejorado:</p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Paciente</th>
                <th>Edad</th>
                <th>Fecha del Examen</th>
            </tr>
        </thead>
        <tbody>';

        if ($result > 0) {
            while ($data = mysqli_fetch_assoc($query)) {
                $html .= "<tr>";
                $html .= "<td>{$data['id']}</td>";
                $html .= "<td>{$data['nombre_paciente']}</td>";
                $html .= "<td>{$data['edad']}</td>";
                $html .= "<td>{$data['fecha_examen']}</td>";
                $html .= "</tr>";
            }
        }

$html .= '
        </tbody>
    </table>
</body>
</html>';


$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("documento.pdf", array('Attachment' => false));
?>
