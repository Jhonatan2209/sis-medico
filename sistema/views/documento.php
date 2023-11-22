<?php
require 'C:/laragon/www/sis-medico/vendor/autoload.php';
include "../../conexion.php";
use Dompdf\Dompdf;

// Verificar si se ha proporcionado un ID válido en la URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_paciente = $_GET['id'];

    // Consultar los detalles del paciente con el ID proporcionado
    $query = mysqli_query($conexion, "SELECT * FROM registrar_examen WHERE id = $id_paciente");
    $result = mysqli_num_rows($query);

    if ($result > 0) {
        $data = mysqli_fetch_assoc($query);

        $fecha_examen = date('d-m-Y', strtotime($data['fecha_examen']));

        // Crear el contenido del informe PDF para el paciente específico
        $html = '
        <html lang="es">
        <head>
        <title>Informe Paciente</title>
        <meta charset="utf-8">
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            h1 {
                color: blue;
                text-align: ;
            }
            .info {
                margin-bottom: 10px;
            }
            .info label {
                font-weight: bold;
                display: inline-block;
                width: 180px; /* Ancho fijo para las etiquetas */
                line-height: 1.7;
            }
            
        </style>
        </head>
        <body>
            <h1>HOSPITAL CARLOS SHOWING FERRARI</h1>
            <p>Este es un ejemplo para la creación del documento en PDF para un servicio mejorado:</p>
            <div class="info">
                <label>Nombre:</label> ' . $data['nombre_paciente'] . '<br>
                <label>Edad:</label> ' . $data['edad'] . '<br>
                <label>Fecha del Examen:</label> ' . $fecha_examen . '<br>
                
                <!-- Agrega más campos aquí según la estructura de tu base de datos -->
            </div>
        </body>
        </html>';

        // Generar el documento PDF y mostrarlo en el navegador
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream("documento_paciente_$id_paciente.pdf", array('Attachment' => false));
    } else {
        // Si no se encuentra ningún paciente con ese ID, puedes mostrar un mensaje o redirigir a otra página
        echo "No se encontró ningún paciente con el ID proporcionado.";
    }
} else {
    // Si no se proporciona un ID válido en la URL, puedes mostrar un mensaje o redirigir a otra página
    echo "ID de paciente no válido.";
}
?>
