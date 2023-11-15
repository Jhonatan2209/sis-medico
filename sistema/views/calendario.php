<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario con FullCalendar y Bootstrap</title>
    <!-- Enlace al archivo CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a la biblioteca de iconos de Bootstrap (opcional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <style>
        /* Ajusta el tamaño de las celdas del calendario */
        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }

        /* Cambia el color de los días de la semana */
        .fc-widget-header {
            background-color: #007bff;
            color: white;
        }

        /* Cambia el color de los botones */
        .fc-button-group button {
            background-color: #007bff;
            border-color: #007bff;
        }

        /* Cambia el color de los botones cuando se les pasa el mouse por encima */
        .fc-button-group button:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <!-- Incluye el archivo del idioma español de FullCalendar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/es.js"></script>
</head>

<body>
    <div class="container-fluid m-5">
        <div class="card o-hidden border-0 shadow-lg my-1">
            <div class="p-4">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Enlace a la biblioteca de JavaScript de Bootstrap (opcional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Enlace a la biblioteca de popper.js (opcional, requerido para ciertas funcionalidades de Bootstrap) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                editable: true,
                eventLimit: true,
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    // Aquí puedes manejar la selección de fechas, si es necesario
                },
                eventRender: function(event, element) {
                    // Aquí puedes personalizar la apariencia de los eventos, si es necesario
                },
                // Establece el idioma del calendario a español
                locale: 'es'
            });
        });
    </script>
</body>

</html>