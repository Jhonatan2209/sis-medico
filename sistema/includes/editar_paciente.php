<?php
// Seguridad de sesiones
session_start();
error_reporting(0);
$varsesion = $_SESSION['nombre'];

if ($varsesion == null || $varsesion == '') {
    header("Location: ../../index.php");
    die(); // Asegúrate de salir del script después de la redirección
}
include '../../conexion.php';
if (!empty($_POST['dni'])) {
    $apellido_paterno = $_POST['Apellido_paterno'];
    $apellido_materno = $_POST['Apellido_materno'];
    $nombres = $_POST['nombres'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $telefono = $_POST['telefono'];
    $edad = $_POST['edad'];
    $dni = $_POST['dni'];
    $direccion = $_POST['direccion'];
    $distrito = $_POST['distrito'];
    $correo = $_POST['correo'];
    $grupo_sanguineo = $_POST['sangre'];
    $medico_asignado_id = $_POST['medico'];
    $paciente_id
        = $_POST['paciente_id'];
    $nombres1  = $nombres . " " . $apellido_paterno . " " . $apellido_materno;
    if (!empty($_FILES['foto']['tmp_name']) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
        // Procesar y guardar la nueva imagen
        $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
        $query_actualizar_paciente = "UPDATE pacientes SET 
        apellido_paterno = '$apellido_paterno', 
        apellido_materno = '$apellido_materno', 
        nombres = '$nombres', 
        fecha_nacimiento = '$fecha_nacimiento', 
        telefono = '$telefono', 
        edad = '$edad', 
        direccion = '$direccion', 
        distrito = '$distrito', 
        correo = '$correo', 
        sangre = '$grupo_sanguineo', 
        medico_asignado = '$medico_asignado_id',
        foto = '$foto', 
        DNI = '$dni'
        WHERE id = '$paciente_id'";
        $query_update = "UPDATE usuario SET  nombres = '$nombres1', correo = '$correo', direccion = '$direccion',telefono = '$telefono',foto = '$foto' WHERE DNI='$dni'";

        // Ejecutar la consulta y verificar si la actualización fue exitosa.
        if ($conexion->query($query_update) === TRUE) {
            echo "Actualización exitosa.";
        } else {
            echo "La actualización falló: " . $conexion->error;
        }
    } else {
        // Conservar la imagen existente en la base de datos
        $query_actualizar_paciente = "UPDATE pacientes SET 
        apellido_paterno = '$apellido_paterno', 
        apellido_materno = '$apellido_materno', 
        nombres = '$nombres', 
        fecha_nacimiento = '$fecha_nacimiento', 
        telefono = '$telefono', 
        edad = '$edad', 
        direccion = '$direccion', 
        distrito = '$distrito', 
        correo = '$correo', 
        sangre = '$grupo_sanguineo', 
        medico_asignado = '$medico_asignado_id', 
        DNI = '$dni'
        WHERE id = '$paciente_id'";
    }
    if ($conexion->query($query_actualizar_paciente) === TRUE) {
        // Obtener los datos del formulario
        $edad_menstruacion = $_POST['edad_menstruacion'];
        $regularidad_ciclo_menstrual = $_POST['regularidad_ciclo_menstrual'];
        $uso_anticonceptivos = $_POST['uso_anticonceptivos'];
        $trastornos_mentales = $_POST['trastornos_mentales'];
        $transtornos_alimenticios = $_POST['transtornos_alimenticios'];
        $alcohol = $_POST['alcohol'];
        $tabaquismo = $_POST['tabaquismo'];
        $drogas = $_POST['drogas'];
        $antecedentes_quirurgicos = $_POST['antecedentes_quirurgicos'];
        $otros = $_POST['otros'];
        $tiene_alergias = $_POST['alergias_medicamentos']['tiene_alergias'];
        $detalles_alergias = ($_POST['alergias_medicamentos']['tiene_alergias'] === 'Si') ? $_POST['alergias_medicamentos']['detalles'] : null;
        $diabetes_familiar = $_POST['diabetes_familiar'];
        $detalles_diabetes = ($_POST['diabetes_familiar'] === 'Si') ? $_POST['diabetes_detalle'] : null;
        $hipertension_familiar = $_POST['hipertension_familiar'];
        $detalles_hipertension = ($_POST['hipertension_familiar'] === 'Si') ? $_POST['hipertension_detalle'] : null;
        $cardiovascular_familiar = $_POST['cardiovascular_familiar'];
        $detalles_cardiovascular = ($_POST['cardiovascular_familiar'] === 'Si') ? $_POST['cardiovascular_detalle'] : null;
        $cancer_familiar = $_POST['cancer_familiar'];
        $detalles_cancer = ($_POST['cancer_familiar'] === 'Si') ? $_POST['cancer_detalle'] : null;

        // Realizar la inserción en la base de datos con los datos obtenidos del formulario
        $query_actualizar_antecedentes = "UPDATE antecedentes SET 
                edad_menstruacion = '$edad_menstruacion', 
                regularidad_ciclo_menstrual = '$regularidad_ciclo_menstrual', 
                uso_anticonceptivos = '$uso_anticonceptivos', 
                trastornos_mentales = '$trastornos_mentales', 
                transtornos_alimenticios = '$transtornos_alimenticios', 
                alcohol = '$alcohol', 
                tabaquismo = '$tabaquismo', 
                drogas = '$drogas', 
                antecedentes_quirurgicos = '$antecedentes_quirurgicos', 
                otros = '$otros', 
                tiene_alergias = '$tiene_alergias', 
                detalles_alergias = '$detalles_alergias', 
                diabetes_familiar = '$diabetes_familiar', 
                detalles_diabetes = '$detalles_diabetes', 
                hipertension_familiar = '$hipertension_familiar', 
                detalles_hipertension = '$detalles_hipertension', 
                cardiovascular_familiar = '$cardiovascular_familiar', 
                detalles_cardiovascular = '$detalles_cardiovascular', 
                cancer_familiar = '$cancer_familiar', 
                detalles_cancer = '$detalles_cancer'
                WHERE paciente_id = '$paciente_id'";


        if ($conexion->query($query_actualizar_antecedentes) === TRUE) {
            $successMessage = "Paciente actualizado";
        } else {
            $errorMessage = "Error al registrar los antecedentes: " . $conexion->error;
        }
    } else {
        $errorMessage = "Error al actualizar el paciente: " . $conexion->error;
    }
}

// Verificar si se ha proporcionado un ID de paciente válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $paciente_id = $_GET['id'];

    // Consulta SQL para obtener todos los campos de pacientes y antecedentes para el paciente específico
    $query = "SELECT p.*, a.* FROM pacientes p
              LEFT JOIN antecedentes a ON p.id = a.paciente_id
              WHERE p.id = $paciente_id";

    // Ejecutar la consulta
    $result = $conexion->query($query);

    if ($result->num_rows > 0) {
        // Obtener la fila de resultados
        $row = $result->fetch_assoc();

        // Acceder a todos los campos de pacientes
        $apellido_paterno = $row['apellido_paterno'];
        $apellido_materno = $row['apellido_materno'];
        $nombres = $row['nombres'];
        $fecha_nacimiento = $row['fecha_nacimiento'];
        $telefono = $row['telefono'];
        $edad = $row['edad'];
        $dni = $row['DNI'];
        $direccion = $row['direccion'];
        $distrito = $row['distrito'];
        $correo = $row['correo'];
        $grupo_sanguineo = $row['sangre'];
        $medico_asignado_id = $row['medico_asignado'];
        // ... obtener otros campos de pacientes ...

        // Acceder a todos los campos de antecedentes
        $edad_menstruacion = $row['edad_menstruacion'];
        $regularidad_ciclo_menstrual = $row['regularidad_ciclo_menstrual'];
        $uso_anticonceptivos = $row['uso_anticonceptivos'];
        $trastornos_mentales = $row['trastornos_mentales'];
        $transtornos_alimenticios = $row['transtornos_alimenticios'];
        $alcohol = $row['alcohol'];
        $tabaquismo = $row['tabaquismo'];
        $drogas = $row['drogas'];
        $antecedentes_quirurgicos = $row['antecedentes_quirurgicos'];
        $otros = $row['otros'];
        $tiene_alergias = $row['tiene_alergias'];
        $detalles_alergias = $row['detalles_alergias'];
        $diabetes_familiar = $row['diabetes_familiar'];
        $detalles_diabetes = $row['detalles_diabetes'];
        $hipertension_familiar = $row['hipertension_familiar'];
        $detalles_hipertension = $row['detalles_hipertension'];
        $cardiovascular_familiar = $row['cardiovascular_familiar'];
        $detalles_cardiovascular = $row['detalles_cardiovascular'];
        $cancer_familiar = $row['cancer_familiar'];
        $detalles_cancer = $row['detalles_cancer'];
    } else {
        echo "No se encontraron datos para el paciente con ID: $paciente_id";
    }
} else {
    echo "ID de paciente no válido";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <script src="../js/jquery.min.js"></script>

</head>
<?php include "header.php"; ?>

<body id="page-top">

    <!-- Begin Page Content -->

    <div class="container-fluid">

        <div class="card o-hidden border-0 shadow-lg my-1">
            <div class="p-4">
                <form action="" method="POST" enctype="multipart/form-data">
                    <h4 class="text-dark">Detalles del paciente</h4>
                    <hr class="my-4 bg-dark">
                    <input type="hidden" id="paciente_id" name="paciente_id" value="<?php echo $paciente_id; ?>">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom01">Apellido Paterno*</label>
                            <input type="text" id="Apellido_paterno" name="Apellido_paterno" class="form-control" required value="<?php echo $apellido_paterno; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationCustom02">Apellido Materno*</label>
                            <input type="text" id="Apellido_materno" name="Apellido_materno" class="form-control" required value="<?php echo $apellido_materno; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationCustomUsername">Nombres*</label>
                            <div class="input-group">
                                <input type="text" id="nombres" name="nombres" class="form-control" required value="<?php echo $nombres; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento*</label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" required value="<?php echo $fecha_nacimiento; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Telefono*</label>
                            <input type="text" id="telefono" name="telefono" class="form-control" required value="<?php echo $telefono; ?>">
                        </div>
                        <div class="col-md-1 mb-3">
                            <label>Edad*</label>
                            <input type="text" id="edad" name="edad" class="form-control" required value="<?php echo $edad; ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>DNI*</label>
                            <input type="text" id="dni" name="dni" class="form-control" required value="<?php echo $dni; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9 mb-3">
                            <label class="form-label">Dirección*</label>
                            <input type="text" id="direccion" name="direccion" class="form-control" required value="<?php echo $direccion; ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Distrito*</label>
                            <input type="text" id="distrito" name="distrito" class="form-control" required value="<?php echo $distrito; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-9 mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" id="correo" name="correo" class="form-control" value="<?php echo $correo; ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">grupo Sanguineo*</label>
                            <input type="text" id="sangre" name="sangre" class="form-control" required value="<?php echo $grupo_sanguineo; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="medico_asignado" class="form-label">Médico Asignado*</label>
                            <select name="medico" class="custom-select" required>
                                <option value="">Seleccionar</option>
                                <?php
                                $query_nivel = mysqli_query($conexion, " select * from usuario");
                                $resultado_nivel = mysqli_num_rows($query_nivel);
                                if ($resultado_nivel > 0) {
                                    while ($nivel = mysqli_fetch_array($query_nivel)) {
                                ?>
                                        <option value="<?php echo $nivel["idusuario"]; ?>" <?php if ($medico_asignado_id == $nivel["idusuario"]) echo "selected"; ?>><?php echo $nivel["nombre"] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="foto" class="form-label">Actualizar foto del paciente</label>
                            <input type="file" class="form-control-file" name="foto" accept="image/*">
                        </div>
                        <div class="col-md-3 mb-3">
                            <h1 class="h5  mb-2">Foto actual</h1>
                            <?php
                            if (!empty($row['foto'])) {
                            ?>
                            <?php
                                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['foto']) . '" width="150" height="150" alt="Foto de perfil"  style="border: 2px solid #000;" >';
                            } else {
                                echo '<div class="alert alert-danger" role="alert">
                            El usuario no tiene foto de perfil!
                            </div>';
                            }
                            ?>
                        </div>
                    </div>
                    <h4 class="text-dark">Antecedentes personales del paciente</h4>
                    <hr class="my-4 bg-dark">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="edad_menstruacion">Edad de la primera menstruación:</label>
                            <input type="text" id="edad_menstruacion" name="edad_menstruacion" class="form-control" value="<?php echo $edad_menstruacion; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="regularidad_ciclo_menstrual">Regularidad del ciclo menstrual:</label>
                            <input type="text" id="regularidad_ciclo_menstrual" name="regularidad_ciclo_menstrual" class="form-control" value="<?php echo $regularidad_ciclo_menstrual; ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="uso_anticonceptivos">Uso previo de anticonceptivos:</label>
                            <input type="text" id="uso_anticonceptivos" name="uso_anticonceptivos" class="form-control" value="<?php echo $uso_anticonceptivos; ?>">
                        </div>
                    </div>
                    <h4>Historial de Salud Mental y Emocional:</h4>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="trastornos_mentales">Historial de trastornos mentales:</label>
                            <textarea type="text" id="trastornos_mentales" name="trastornos_mentales" class="form-control"><?php echo $trastornos_mentales; ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="abuso_sexual_fisico">Historial de Trastornos Alimenticios:</label>
                            <textarea type="text" name="transtornos_alimenticios" class="form-control"><?php echo $transtornos_alimenticios; ?></textarea>
                        </div>
                    </div>
                    <h4>Hábitos de Salud:</h4>
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Alcohol</span>
                                </div>
                                <input name="alcohol" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $alcohol; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Tabaquismo</span>
                                </div>
                                <input name="tabaquismo" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $tabaquismo; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group  mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Drogas</span>
                                </div>
                                <input name="drogas" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" value="<?php echo $drogas; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <h4>Historial quirúrgicos:</h4>
                            <input type="text" id="antecedentes_quirurgicos" name="antecedentes_quirurgicos" class="form-control" value="<?php echo $antecedentes_quirurgicos; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <h4>Otros:</h4>
                            <input type="text" id="otros" name="otros" class="form-control" value="<?php echo $otros; ?>">
                        </div>
                    </div>
                    <fieldset class="mb-3">
                        <legend>Alergias a medicamentos:</legend>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="alergias_medicamentos[tiene_alergias]" id="alergias_medicamentos_si" value="Si" <?php if ($tiene_alergias == "Si") echo "checked"; ?>>
                            <label class="form-check-label" for="alergias_medicamentos_si">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="alergias_medicamentos[tiene_alergias]" id="alergias_medicamentos_no" value="No" <?php if ($tiene_alergias == "No") echo "checked"; ?>>
                            <label class="form-check-label" for="alergias_medicamentos_no">No</label>
                        </div>
                        <!-- Detalles adicionales en caso de "Sí" -->
                        <div id="detalles_alergias_medicamentos" style="<?php if ($tiene_alergias == "No") echo "display: none;"; ?>">
                            <label for="alergias_medicamentos_detalle">Detalles:</label>
                            <input type="text" id="alergias_medicamentos_detalle" name="alergias_medicamentos[detalles]" class="form-control" value="<?php echo $detalles_alergias; ?>">
                        </div>
                    </fieldset>
                    <h4 class="text-dark">Antecedentes Familiares del paciente</h4>
                    <hr class="my-4 bg-dark">
                    <fieldset>
                        <legend>Diabetes en la familia:</legend>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="diabetes_familiar" id="diabetes_si" value="Si" <?php if ($diabetes_familiar == "Si") echo "checked"; ?>>
                            <label class="form-check-label" for="diabetes_si">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="diabetes_familiar" id="diabetes_no" value="No" <?php if ($diabetes_familiar == "No") echo "checked"; ?>>
                            <label class="form-check-label" for="diabetes_no">No</label>
                        </div>
                        <!-- Detalles adicionales en caso de "Sí" -->
                        <div id="detalles_diabetes" style="<?php if ($diabetes_familiar == "No") echo "display: none;"; ?>">
                            <label for="diabetes_detalle">Detalles:</label>
                            <input type="text" id="diabetes_detalle" name="diabetes_detalle" class="form-control" value="<?php echo $detalles_diabetes; ?>">
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Hipertensión en la familia:</legend>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hipertension_familiar" id="hipertension_si" value="Si" <?php if ($hipertension_familiar == "Si") echo "checked"; ?>>
                            <label class="form-check-label" for="hipertension_si">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hipertension_familiar" id="hipertension_no" value="No" <?php if ($hipertension_familiar == "No") echo "checked"; ?>>
                            <label class="form-check-label" for="hipertension_no">No</label>
                        </div>
                        <!-- Detalles adicionales en caso de "Sí" -->
                        <div id="detalles_hipertension" style="<?php if ($hipertension_familiar == "No") echo "display: none;"; ?>">
                            <label for="hipertension_detalle">Detalles:</label>
                            <input type="text" id="hipertension_detalle" name="hipertension_detalle" class="form-control" value="<?php echo $detalles_hipertension; ?>">
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Enfermedad cardiovascular en la familia:</legend>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="cardiovascular_familiar" id="cardiovascular_si" value="Si" <?php if ($cardiovascular_familiar == "Si") echo "checked"; ?>>
                            <label class="form-check-label" for="cardiovascular_si">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="cardiovascular_familiar" id="cardiovascular_no" value="No" <?php if ($cardiovascular_familiar == "No") echo "checked"; ?>>
                            <label class="form-check-label" for="cardiovascular_no">No</label>
                        </div>
                        <!-- Detalles adicionales en caso de "Sí" -->
                        <div id="detalles_cardiovascular" style="<?php if ($cardiovascular_familiar == "No") echo "display: none;"; ?>">
                            <label for="cardiovascular_detalle">Detalles:</label>
                            <input type="text" id="cardiovascular_detalle" name="cardiovascular_detalle" class="form-control" value="<?php echo $detalles_cardiovascular; ?>">
                        </div>
                    </fieldset>

                    <fieldset class="mb-3">
                        <legend>Cáncer en la familia:</legend>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="cancer_familiar" id="cancer_si" value="Si" <?php if ($cancer_familiar == "Si") echo "checked"; ?>>
                            <label class="form-check-label" for="cancer_si">Sí</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="cancer_familiar" id="cancer_no" value="No" <?php if ($cancer_familiar == "No") echo "checked"; ?>>
                            <label class="form-check-label" for="cancer_no">No</label>
                        </div>
                        <!-- Detalles adicionales en caso de "Sí" -->
                        <div id="detalles_cancer" style="<?php if ($cancer_familiar == "No") echo "display: none;"; ?>">
                            <label for="cancer_detalle">Detalles:</label>
                            <input type="text" id="cancer_detalle" name="cancer_detalle" class="form-control" value="<?php echo $detalles_cancer; ?>">
                        </div>
                    </fieldset>

                    <script>
                        // Función para mostrar/ocultar detalles de acuerdo a la selección
                        function toggleDetalles(elemento, detallesId) {
                            var detalles = document.getElementById(detallesId);
                            detalles.style.display = "block";
                            if (elemento.value === "No") {
                                detalles.style.display = "none";
                            }
                        }

                        // Asocia la función con los elementos correspondientes para diabetes
                        document.getElementById("diabetes_si").addEventListener("change", function() {
                            toggleDetalles(this, "detalles_diabetes");
                        });

                        document.getElementById("diabetes_no").addEventListener("change", function() {
                            toggleDetalles(this, "detalles_diabetes");
                        });

                        // Asocia la función con los elementos correspondientes para hipertensión
                        document.getElementById("hipertension_si").addEventListener("change", function() {
                            toggleDetalles(this, "detalles_hipertension");
                        });

                        document.getElementById("hipertension_no").addEventListener("change", function() {
                            toggleDetalles(this, "detalles_hipertension");
                        });
                        document.getElementById("cardiovascular_si").addEventListener("change", function() {
                            toggleDetalles(this, "detalles_cardiovascular");
                        });
                        document.getElementById("cardiovascular_no").addEventListener("change", function() {
                            toggleDetalles(this, "detalles_cardiovascular");
                        });
                        document.getElementById("cancer_si").addEventListener("change", function() {
                            toggleDetalles(this, "detalles_cancer");
                        });
                        document.getElementById("cancer_no").addEventListener("change", function() {
                            toggleDetalles(this, "detalles_cancer");
                        });

                        function toggleDetallesAlergiasMedicamentos() {
                            var detalles = document.getElementById("detalles_alergias_medicamentos");
                            detalles.style.display = "block";
                            var siCheckbox = document.getElementById("alergias_medicamentos_si");
                            var noCheckbox = document.getElementById("alergias_medicamentos_no");
                            if (noCheckbox.checked) {
                                detalles.style.display = "none";
                            }
                        }
                        document.getElementById("alergias_medicamentos_si").addEventListener("change", toggleDetallesAlergiasMedicamentos);
                        document.getElementById("alergias_medicamentos_no").addEventListener("change", toggleDetallesAlergiasMedicamentos);
                        // Repite esto para otros antecedentes familiares si es necesario
                    </script>


                    <div class="mb-3">
                        <input type="submit" value="Guardar" id="register" class="btn btn-success">
                        <a href="../views/pacientes.php" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php include "../includes/footer.php"; ?>

    <script src="../package/jquery-3.6.0.min.js"></script>
    <script src="../package/dist/sweetalert2.all.js"></script>
    <script src="../package/dist/sweetalert2.all.min.js"></script>


    <!-- Asegúrate de incluir jQuery y SweetAlert antes de este script -->

    <!-- ALerta de usuario registrado -->
    <?php
    if (isset($successMessage)) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Confirmación de actualización!',
                    text: '$successMessage',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../views/pacientes.php';
                    }
                });
            </script>";
    }

    if (isset($errorMessage)) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '$errorMessage',
                    confirmButtonText: 'OK'
                });
            </script>";
    }
    ?>

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->




</body>

</html>