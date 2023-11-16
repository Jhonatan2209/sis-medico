<?php
include 'header.php';
include '../../conexion.php';

$successMessage = $errorMessage = ""; // Inicializa las variables de mensajes

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre_paciente'];
    $edad = $_POST['edad'];

    $fecha_examen = $_POST['fecha_examen'];
    $fecha_formateada = date('Y-m-d', strtotime($fecha_examen));
    //NUEVOS
    $gestacion = $_POST['gestacion'];
    $situacion = $_POST['situacion'];
    $presentacion = $_POST['presentacion'];
    $posicion = $_POST['posicion'];
    $fciafetal = $_POST['fciafetal'];
    $movfetal = $_POST['movfetal'];
    $movrespiratorio = $_POST['movrespiratorio'];
    $tonomuscular = $_POST['tonomuscular'];
    $dbp = $_POST['dbp'];
    $cc = $_POST['cc'];
    $ca = $_POST['ca'];
    $lf = $_POST['lf'];
    $ponderadofetal = $_POST['ponderadofetal'];
    $anatomiafetal = $_POST['anatomiafetal'];
    $espesor = $_POST['espesor'];
    $madurez = $_POST['madurez'];
    $arterias = $_POST['arterias'];
    $venas = $_POST['venas'];
    $descripcion_cordon = $_POST['descripcion_cordon'];
    $pozomayor = $_POST['pozomayor'];
    $ila = $_POST['ila'];
    $descripcion_liquido = $_POST['descripcion_liquido'];
    $ip = $_POST['ip'];
    $acm = $_POST['acm'];
    $pbf = $_POST['pbf'];
    //ANTIGUOS DATOS
    $tipo_examen = $_POST['tipo_examen'];
    // Preparar la consulta SQL utilizando sentencias preparadas

   
    $query_insert = $conexion->prepare("INSERT INTO registrar_examen(nombre_paciente,edad,fecha_examen,tipo_examen,gestacion,situacion,presentacion,posicion,frecuencia_fetal,movimiento_fetal, movimiento_respiratorio, tono_muscular,dbp,cc,lf,ponderado_fetal,anatomia_fetal,espesor,madurez,arterias,venas,descripcion_cordon,pozo_mayor,ila,descripcion_liquido,ip,acm, pbf ) VALUES ('$nombre',' $edad','$fecha_formateada','$tipo_examen','$gestacion','$situacion','$presentacion','$posicion','$fciafetal','$movfetal','$movrespiratorio','$tonomuscular','$dbp','$cc','$lf','$ponderadofetal','$anatomiafetal','$espesor','$madurez','$arterias','$venas','$descripcion_cordon','$pozomayor','$ila','$descripcion_liquido','$ip','$acm','$pbf')");
    
    if ($query_insert->execute()) {
        $successMessage = "Examen registrado exitosamente.";
    } else {
        throw new Exception("Error al registrar el examen: " . $conexion->error);
    }
    $query_insert->close();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title class="h1 text-gray-900 mb-2"> Registro de examen Médico</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />
</head>

<body>
    <div class="row justify-content-center">
        <div class="col-xl-8  col-md-8">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-4">
                                <h2 class="h3 text-gray-900 mb-2 text-center">Registro de los datos del examen médico</h2>

                                <form action="" method="POST">
                                    <div>
                                        <h1 type="text" class="h5 text-gray-900 mb-2" for="nombre_paciente">Nombre del
                                            Paciente:
                                        </h1>
                                        <input type="text" class="form-control" id="nombre_paciente"
                                            name="nombre_paciente" required>
                                    </div>                                   
                                    <div>
                                        <h1 type="text" class="h5 text-gray-900 mb-2" for="edad">Edad: 
                                        </h1>
                                        <input type="number" class="form-control" id="edad"
                                            name="edad" required>
                                    </div>
                                    <div>
                                        <h1 class="h5 text-gray-900 mb-2" for="fecha_examen">Fecha del Examen:</h1>
                                        <input type="date" class="form-control" id="fecha_examen" name="fecha_examen"
                                            required>
                                    </div>

                                    <div>
                                        <h1 class="h5 text-gray-900 mb-2" for="tipo_examen">Tipo de Examen:</h1>
                                        <select class="form-control" id="tipo_examen" name="tipo_examen" required>
                                            <option value="" disabled selected>Seleccione un tipo de examen</option>
                                            <option value="Ecografia">Ecografía</option>
                                            <option value="Analisis de sangre">Análisis de Sangre</option>
                                            <option value="Control de presion">Control de Presión Arterial</option>
                                        </select>
                                    </div>

                                    <div id="dateeco1" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="gestacion">Gestación: </h1>
                                        <input type="text" class="form-control" id="gestacion" name="gestacion">
                                    </div>
                                    <div id="dateeco2" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="situacion">Situación:</h1>
                                        <input type="text" class="form-control" id="situacion" name="situacion">
                                    </div>
                                    <div id="dateeco3" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="presentacion">Presentación: </h1>
                                        <input type="text" class="form-control" id="presentacion" name="presentacion">
                                    </div>
                                    <div id="dateeco4" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="posicion">Posición: </h1>
                                        <input type="text" class="form-control" id="posicion" name="posicion">
                                    </div>
                                    <div id="dateeco5" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="fciafetal">Fcia. Cardiaca fetal:</h1>
                                        <input type="number" class="form-control" id="fciafetal" name="fciafetal">
                                    </div>
                                    <div id="dateeco6" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="movfetal">Mov. Fetales: </h1>
                                        <input type="text" class="form-control" id="movfetal" name="movfetal">
                                    </div>
                                    <div id="dateeco7" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="movrespiratorio">Mov. Respitarios: </h1>
                                        <input type="text" class="form-control" id="movrespiratorio" name="movrespiratorio">
                                    </div>
                                    <div id="dateeco8" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="tonomuscular">Tono muscular: </h1>
                                        <input type="text" class="form-control" id="tonomuscular" name="tonomuscular">
                                    </div>
                                    <div id="biometriafisica1" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="dbp">D.B.P.: </h1>
                                        <input type="text" class="form-control" id="dbp" name="dbp">
                                    </div>
                                    <div id="biometriafisica2" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="cc">C.C.: </h1>
                                        <input type="text" class="form-control" id="cc" name="cc">
                                    </div>
                                    <div id="biometriafisica3" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="ca">C.A.: </h1>
                                        <input type="text" class="form-control" id="ca" name="ca">
                                    </div>
                                    <div id="biometriafisica4" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="lf">L.F.: </h1>
                                        <input type="text" class="form-control" id="lf" name="lf">
                                    </div>
                                    <div id="biometriafisica5" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="ponderadofetal">Ponderado fetal: </h1>
                                        <input type="text" class="form-control" id="ponderadofetal" name="ponderadofetal">
                                    </div>
                                    <div id="biometriafisica6" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="anatomiafetal">Anatomía fetal: </h1>
                                        <input type="text" class="form-control" id="anatomiafetal" name="anatomiafetal">
                                    </div>
                                    <div id="biometriafisica7" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="placenta">Placenta corporal anterior: </h1>
                                        <input type="text" class="form-control" id="espesor" name="espesor" placeholder="ESPESOR">
                                        <input type="text" class="form-control" id="madurez" name="madurez" placeholder="MADUREZ">
                                    </div>
                                    <div id="biometriafisica8" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="placenta">Cordon umbilical: </h1>
                                        <input type="number" class="form-control" id="arterias" name="arterias" placeholder="ARTERIAS">
                                        <input type="number" class="form-control" id="venas" name="venas" placeholder="VENAS">
                                        <input type="text" class="form-control" id="descripcion_cordon" name="descripcion_cordon" placeholder="DESCRIPCION">
                                    </div>
                                    <div id="biometriafisica9" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="amniotico">Liquido Amniotico(mm): </h1>
                                        <input type="text" class="form-control" id="pozomayor" name="pozomayor" placeholder= "POZO MAYOR">
                                        <input type="text" class="form-control" id="ila" name="ila" placeholder="INDICE LIQUIDO AMNIONITCO">
                                        <input type="text" class="form-control" id="descripcion_liquido" name="descripcion_liquido" placeholder= "DESCRIPCION">     
                                    </div>
                                    <div id="biometriafisica10" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="ip">Doppler de arteria umbilical: </h1>
                                        <input type="text" class="form-control" id="ip" name="ip" placeholder="Indice de pulsatilidad(IP)">
                                        <input type="text" class="form-control" id="acm" name="acm" placeholder="Indica de arteria cerebral media(ACM) ">
                                    </div>
                                    <div id="biometriafisica11" style="display: none;">
                                        <h1 class="h5 text-gray-900 mb-2" for="pbf">Perfil biofísico fetal PBF rango de 1 a 10 siendo 8 el más óptimo: </h1>
                                        <input type="number" class="form-control" id="pbf" name="pbf">
                                    </div>



                                    <script>
                                        const tipoExamen = document.getElementById("tipo_examen");
                                        const dateeco1 = document.getElementById("dateeco1");
                                        const dateeco2 = document.getElementById("dateeco2");
                                        const dateeco3 = document.getElementById("dateeco3");
                                        const dateeco4 = document.getElementById("dateeco4");
                                        const dateeco5 = document.getElementById("dateeco5");
                                        const dateeco6 = document.getElementById("dateeco6");
                                        const dateeco7 = document.getElementById("dateeco7");
                                        const dateeco8 = document.getElementById("dateeco8");
                                        const biometriafisica1 = document.getElementById("biometriafisica1");
                                        const biometriafisica2 = document.getElementById("biometriafisica2");
                                        const biometriafisica3 = document.getElementById("biometriafisica3");
                                        const biometriafisica4 = document.getElementById("biometriafisica4");
                                        const biometriafisica5 = document.getElementById("biometriafisica5");
                                        const biometriafisica6 = document.getElementById("biometriafisica6");
                                        const biometriafisica7 = document.getElementById("biometriafisica7");
                                        const biometriafisica8 = document.getElementById("biometriafisica8");
                                        const biometriafisica9 = document.getElementById("biometriafisica9");
                                        const biometriafisica10 = document.getElementById("biometriafisica10");
                                        const biometriafisica11 = document.getElementById("biometriafisica11");

                                        tipoExamen.addEventListener("change", function () {
                                            if (tipoExamen.value === "Ecografia") {

                                                dateeco1.style.display = "block";
                                                dateeco2.style.display = "block";
                                                dateeco3.style.display = "block";
                                                dateeco4.style.display = "block";
                                                dateeco5.style.display = "block";
                                                dateeco6.style.display = "block";
                                                dateeco7.style.display = "block";
                                                dateeco8.style.display = "block";
                                                biometriafisica1.style.display = "block";
                                                biometriafisica2.style.display = "block";
                                                biometriafisica3.style.display = "block";
                                                biometriafisica4.style.display = "block";
                                                biometriafisica5.style.display = "block";
                                                biometriafisica6.style.display = "block";
                                                biometriafisica7.style.display = "block";
                                                biometriafisica8.style.display = "block";
                                                biometriafisica9.style.display = "block";
                                                biometriafisica10.style.display = "block";
                                                biometriafisica11.style.display = "block";

                                            } else {
                                                dateeco1.style.display = "none";
                                                dateeco2.style.display = "none";
                                                dateeco3.style.display = "none";
                                                dateeco4.style.display = "none";
                                                dateeco5.style.display = "none";
                                                dateeco6.style.display = "none";
                                                dateeco7.style.display = "none";
                                                dateeco8.style.display = "none";
                                                biometriafisica1.style.display = "none";
                                                biometriafisica2.style.display = "none";
                                                biometriafisica3.style.display = "none";
                                                biometriafisica4.style.display = "none";
                                                biometriafisica5.style.display = "none";
                                                biometriafisica6.style.display = "none";
                                                biometriafisica7.style.display = "none";
                                                biometriafisica8.style.display = "none";
                                                biometriafisica9.style.display = "none";
                                                biometriafisica10.style.display = "none";
                                                biometriafisica11.style.display = "none";
                                            }
                                        });
                                    </script>

                                    <div class="text-center">
                                        <br>
                                        <input type="submit" value="Guardar" class="btn btn-success btn-lg mb-3">
                                        <a href="./views/index.php" class="btn btn-danger btn-lg mb-3">Cancelar</a>
                                        <a href="../views/vexamenes.php"class="btn btn-success btn-lg mb-3">Ver examenes</a>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>

<script src="../package/jquery-3.6.0.min.js"></script>
<script src="../package/dist/sweetalert2.all.js"></script>
<script src="../package/dist/sweetalert2.all.min.js"></script>



<?php
if (!empty($successMessage)) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: '¡Confirmación de registro!',
            text: '$successMessage',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../views/index.php';
            }
        });
    </script>";
}

if (!empty($errorMessage)) {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '$errorMessage',
            confirmButtonText: 'OK',
            console.log('$errorMessage')
        });
    </script>";
}
?>

</html> 