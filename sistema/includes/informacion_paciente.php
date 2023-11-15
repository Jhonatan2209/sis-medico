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
if (isset($_POST['id'])) {
    $paciente_id = $_POST['id'];
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
        $foto
            = $row['foto'];
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

    echo "
    <h4 class='text-dark'>Detalles del paciente</h4>
    <hr class='my-4 bg-dark'>";

    echo
    "
    <div class='form-row'>
      <div class='col-md-2 mb-3'>
    ";
    if (!empty($row['foto'])) {
        echo '<img src="data:image/jpeg;base64,' . base64_encode($row['foto']) . '" width="100%" height="100%" alt="Foto de perfil" style="border: 2px solid #000;">';
    } else {
        echo '<img src="../img/sin_foto.png" width="80" height="80" alt="Imagen por defecto" style="border: 2px solid #000;">';
    }
    echo "
    </div>
    <div class='col-md-10 mb-3'>
    <div class='form-row'>
        <div class='col-md-4 mb-3'>
            <label for='validationCustom01'>Apellido Paterno*</label>
            <input type='text' id='Apellido_paterno' name='Apellido_paterno' class='form-control' required value='$apellido_paterno'>
        </div>
        <div class='col-md-4 mb-3'>
            <label for='validationCustom02'>Apellido Materno*</label>
            <input type='text' id='Apellido_materno' name='Apellido_materno' class='form-control' required value='$apellido_materno'>
        </div>
        <div class='col-md-4 mb-3'>
            <label for='validationCustomUsername'>Nombres*</label>
            <div class='input-group'>
                <input type='text' id='nombres' name='nombres' class='form-control' required value='$nombres'>
            </div>
        </div>";

    echo "
    </div>
    <div class='form-row'>
        <div class='col-md-4 mb-3'>
            <label for='fecha_nacimiento' class='form-label'>Fecha de Nacimiento*</label>
            <input type='date' id='fecha_nacimiento' name='fecha_nacimiento' class='form-control' required value='$fecha_nacimiento'>
        </div>
        <div class='col-md-4 mb-3'>
            <label>Telefono*</label>
            <input type='text' id='telefono' name='telefono' class='form-control' required value='$telefono'>
        </div>
        <div class='col-md-1 mb-3'>
            <label>Edad*</label>
            <input type='text' id='edad' name='edad' class='form-control' required value='$edad'>
        </div>
        <div class='col-md-3 mb-3'>
            <label>DNI*</label>
            <input type='text' id='dni' name='dni' class='form-control' required value='$dni'>
        </div>
    </div>
    <div class='form-row'>
    <div class='col-md-9 mb-3'>
        <label class='form-label'>Dirección*</label>
        <input type='text' id='direccion' name='direccion' class='form-control' required value='$direccion'>
    </div>
    <div class='col-md-3 mb-3'>
        <label class='form-label'>Distrito*</label>
        <input type='text' id='distrito' name='distrito' class='form-control' required value='$distrito'>
    </div>
</div>
    </div>
  
    </div>
";
    echo "

<div class='form-row'>
    <div class='col-md-9 mb-3'>
        <label for='correo' class='form-label'>Correo Electrónico</label>
        <input type='email' id='correo' name='correo' class='form-control' value='$correo'>
    </div>
    <div class='col-md-3 mb-3'>
        <label class='form-label'>grupo Sanguineo*</label>
        <input type='text' id='sangre' name='sangre' class='form-control' required value='$grupo_sanguineo'>
    </div>
</div>";

    echo '
<div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="medico_asignado" class="form-label">Médico Asignado*</label>
            <select name="medico" class="custom-select" required>
                <option value="">Seleccionar</option>';
    $query_nivel = mysqli_query($conexion, " select * from usuario");
    mysqli_close($conexion);
    $resultado_nivel = mysqli_num_rows($query_nivel);
    if ($resultado_nivel > 0) {
        while ($nivel = mysqli_fetch_array($query_nivel)) {
            echo '<option value="' . $nivel["idusuario"] . '" ' . (($medico_asignado_id == $nivel["idusuario"]) ? 'selected' : '') . '>' . $nivel["nombre"] . '</option>';
        }
    }
    echo '
        </select>
        </div>';


    echo '  
 </div>
';

    echo "

    <h4 class='text-dark'>Antecedentes personales del paciente</h4>
<hr class='my-4 bg-dark'>
<div class='form-row'>
    <div class='col-md-4 mb-3'>
        <label for='edad_menstruacion'>Edad de la primera menstruación:</label>
        <input type='text' id='edad_menstruacion' name='edad_menstruacion' class='form-control' value='$edad_menstruacion'>
    </div>
    <div class='col-md-4 mb-3'>
        <label for='regularidad_ciclo_menstrual'>Regularidad del ciclo menstrual:</label>
        <input type='text' id='regularidad_ciclo_menstrual' name='regularidad_ciclo_menstrual' class='form-control' value='$regularidad_ciclo_menstrual'>
    </div>
    <div class='col-md-4 mb-3'>
        <label for='uso_anticonceptivos'>Uso previo de anticonceptivos:</label>
        <input type='text' id='uso_anticonceptivos' name='uso_anticonceptivos' class='form-control' value='$uso_anticonceptivos'>
    </div>
</div>

<h4>Historial de Salud Mental y Emocional:</h4>
<div class='form-row'>
    <div class='col-md-6 mb-3'>
        <label for='trastornos_mentales'>Historial de trastornos mentales:</label>
        <textarea type='text' id='trastornos_mentales' name='trastornos_mentales' class='form-control'>$trastornos_mentales</textarea>
    </div>
    <div class='col-md-6 mb-3'>
        <label for='abuso_sexual_fisico'>Historial de Trastornos Alimenticios:</label>
        <textarea type='text' name='transtornos_alimenticios' class='form-control'>$transtornos_alimenticios</textarea>
    </div>
</div>

<h4>Hábitos de Salud:</h4>
<div class='form-row'>
    <div class='col-md-4'>
        <div class='input-group  mb-3'>
            <div class='input-group-prepend'>
                <span class='input-group-text' id='inputGroup-sizing-default'>Alcohol</span>
            </div>
            <input name='alcohol' type='text' class='form-control' aria-label='Default' aria-describedby='inputGroup-sizing-default' value='$alcohol'>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='input-group  mb-3'>
            <div class='input-group-prepend'>
                <span class='input-group-text' id='inputGroup-sizing-default'>Tabaquismo</span>
            </div>
            <input name='tabaquismo' type='text' class='form-control' aria-label='Default' aria-describedby='inputGroup-sizing-default' value='$tabaquismo'>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='input-group  mb-3'>
            <div class='input-group-prepend'>
                <span class='input-group-text' id='inputGroup-sizing-default'>Drogas</span>
            </div>
            <input name='drogas' type='text' class='form-control' aria-label='Default' aria-describedby='inputGroup-sizing-default' value='$drogas'>
        </div>
    </div>
</div>

<div class='form-row'>
    <div class='col-md-6 mb-3'>
        <h4>Historial quirúrgicos:</h4>
        <input type='text' id='antecedentes_quirurgicos' name='antecedentes_quirurgicos' class='form-control' value='$antecedentes_quirurgicos'>
    </div>
    <div class='col-md-6 mb-3'>
        <h4>Otros:</h4>
        <input type='text' id='otros' name='otros' class='form-control' value='$otros'>
    </div>
</div>
";
    echo '<fieldset class="mb-3">
    <legend>Alergias a medicamentos:</legend>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="alergias_medicamentos[tiene_alergias]" id="alergias_medicamentos_si" value="Si" ' . (($tiene_alergias == "Si") ? 'checked' : '') . '>
        <label class="form-check-label" for="alergias_medicamentos_si">Sí</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="alergias_medicamentos[tiene_alergias]" id="alergias_medicamentos_no" value="No" ' . (($tiene_alergias == "No") ? 'checked' : '') . '>
        <label class="form-check-label" for="alergias_medicamentos_no">No</label>
    </div>
    <!-- Detalles adicionales en caso de "Sí" -->
    <div id="detalles_alergias_medicamentos" style="' . (($tiene_alergias == "No") ? 'display: none;' : '') . '">
        <label for="alergias_medicamentos_detalle">Detalles:</label>
        <input type="text" id="alergias_medicamentos_detalle" name="alergias_medicamentos[detalles]" class="form-control" value="' . $detalles_alergias . '">
    </div>
</fieldset>';
    echo '
<h4 class="text-dark">Antecedentes Familiares del paciente</h4>
<hr class="my-4 bg-dark">

<fieldset>
    <legend>Diabetes en la familia:</legend>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="diabetes_familiar" id="diabetes_si" value="Si" ' . (($diabetes_familiar == "Si") ? 'checked' : '') . '>
        <label class="form-check-label" for="diabetes_si">Sí</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="diabetes_familiar" id="diabetes_no" value="No" ' . (($diabetes_familiar == "No") ? 'checked' : '') . '>
        <label class="form-check-label" for="diabetes_no">No</label>
    </div>
    <!-- Detalles adicionales en caso de "Sí" -->
    <div id="detalles_diabetes" style="' . (($diabetes_familiar == "No") ? 'display: none;' : '') . '">
        <label for="diabetes_detalle">Detalles:</label>
        <input type="text" id="diabetes_detalle" name="diabetes_detalle" class="form-control" value="' . $detalles_diabetes . '">
    </div>
</fieldset>

<fieldset>
    <legend>Hipertensión en la familia:</legend>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="hipertension_familiar" id="hipertension_si" value="Si" ' . (($hipertension_familiar == "Si") ? 'checked' : '') . '>
        <label class="form-check-label" for="hipertension_si">Sí</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="hipertension_familiar" id="hipertension_no" value="No" ' . (($hipertension_familiar == "No") ? 'checked' : '') . '>
        <label class="form-check-label" for="hipertension_no">No</label>
    </div>
    <!-- Detalles adicionales en caso de "Sí" -->
    <div id="detalles_hipertension" style="' . (($hipertension_familiar == "No") ? 'display: none;' : '') . '">
        <label for="hipertension_detalle">Detalles:</label>
        <input type="text" id="hipertension_detalle" name="hipertension_detalle" class="form-control" value="' . $detalles_hipertension . '">
    </div>
</fieldset>

<fieldset>
    <legend>Enfermedad cardiovascular en la familia:</legend>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="cardiovascular_familiar" id="cardiovascular_si" value="Si" ' . (($cardiovascular_familiar == "Si") ? 'checked' : '') . '>
        <label class="form-check-label" for="cardiovascular_si">Sí</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="cardiovascular_familiar" id="cardiovascular_no" value="No" ' . (($cardiovascular_familiar == "No") ? 'checked' : '') . '>
        <label class="form-check-label" for="cardiovascular_no">No</label>
    </div>
    <!-- Detalles adicionales en caso de "Sí" -->
    <div id="detalles_cardiovascular" style="' . (($cardiovascular_familiar == "No") ? 'display: none;' : '') . '">
        <label for="cardiovascular_detalle">Detalles:</label>
        <input type="text" id="cardiovascular_detalle" name="cardiovascular_detalle" class="form-control" value="' . $detalles_cardiovascular . '">
    </div>
</fieldset>

<fieldset class="mb-3">
    <legend>Cáncer en la familia:</legend>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="cancer_familiar" id="cancer_si" value="Si" ' . (($cancer_familiar == "Si") ? 'checked' : '') . '>
        <label class="form-check-label" for="cancer_si">Sí</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="cancer_familiar" id="cancer_no" value="No" ' . (($cancer_familiar == "No") ? 'checked' : '') . '>
        <label class="form-check-label" for="cancer_no">No</label>
    </div>
    <!-- Detalles adicionales en caso de "Sí" -->
    <div id="detalles_cancer" style="' . (($cancer_familiar == "No") ? 'display: none;' : '') . '">
        <label for="cancer_detalle">Detalles:</label>
        <input type="text" id="cancer_detalle" name="cancer_detalle" class="form-control" value="' . $detalles_cancer . '">
    </div>
</fieldset>';
} else {
    echo "Error: No se ha enviado el ID del paciente.";
}

// Cerrar la conexión a la base de datos
