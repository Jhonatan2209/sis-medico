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

if (!empty($_POST['nombres'])) {
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
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
    }

    $query_pacientes = "INSERT INTO pacientes(apellido_paterno, apellido_materno, nombres, fecha_nacimiento, telefono, edad, direccion, distrito, correo, sangre, medico_asignado, foto, DNI) 
                    VALUES ('$apellido_paterno', '$apellido_materno', '$nombres', '$fecha_nacimiento', '$telefono', '$edad', '$direccion', '$distrito', '$correo', '$grupo_sanguineo', '$medico_asignado_id', '$foto', '$dni')";

    if ($conexion->query($query_pacientes) === TRUE) {
        // Obtener el ID del paciente insertado
        $paciente_id = $conexion->insert_id;
        $nombres1  = $nombres . " " . $apellido_paterno . " " . $apellido_materno;
        $rol = 2;

        $query_insert = mysqli_query($conexion, "INSERT INTO usuario(nombre,correo,usuario,clave,rol,telefono,direccion,foto,DNI) VALUES ('$nombres1', '$correo', '$dni', '$dni', '$rol','$telefono','$direccion', '$foto','$dni')");
        if ($query_insert) {
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
            $query_antecedentes = "INSERT INTO antecedentes (paciente_id,edad_menstruacion, regularidad_ciclo_menstrual, uso_anticonceptivos, trastornos_mentales, transtornos_alimenticios, alcohol, tabaquismo, drogas, antecedentes_quirurgicos, otros, tiene_alergias, detalles_alergias, diabetes_familiar, detalles_diabetes, hipertension_familiar, detalles_hipertension, cardiovascular_familiar, detalles_cardiovascular, cancer_familiar, detalles_cancer) 
              VALUES ('$paciente_id','$edad_menstruacion', '$regularidad_ciclo_menstrual', '$uso_anticonceptivos', '$trastornos_mentales', '$transtornos_alimenticios', '$alcohol', '$tabaquismo', '$drogas', '$antecedentes_quirurgicos', '$otros', '$tiene_alergias', '$detalles_alergias', '$diabetes_familiar', '$detalles_diabetes', '$hipertension_familiar', '$detalles_hipertension', '$cardiovascular_familiar', '$detalles_cardiovascular', '$cancer_familiar', '$detalles_cancer')";


            if ($conexion->query($query_antecedentes) === TRUE) {
                $successMessage = "Usuario registrado";
            } else {
                $errorMessage = "Error al registrar los antecedentes: " . $conexion->error;
            }
        }
    } else {
        $errorMessage = "Error al registrar el usuario: " . $conexion->error;
    }
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
<?php include "../includes/header.php"; ?>



<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid"></div>


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Añadir Pacientes</h6>
            <br>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#PacienteModal">
                <span class="glyphicon glyphicon-plus"></span> Agregar Paciente <i class="fa fa-user-plus"></i>
            </button>


            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Fecha_Registro</th>
                                <th>DNI</th>
                                <th>Nombre</th>
                                <th>Foto</th>
                                <th>Edad</th>
                                <th>Direccion</th>
                                <th>Telefono</th>
                                <th>Medico</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <?php
                        $result = mysqli_query($conexion, "SELECT * FROM pacientes ");
                        while ($fila = mysqli_fetch_assoc($result)) :

                        ?>
                            <tr>
                                <td><?php echo $fila['fecha_registro']; ?></td>
                                <td><?php echo $fila['DNI']; ?></td>
                                <td><?php $nombreCompleto = $fila['nombres'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno'];

                                    echo $nombreCompleto; ?></td>
                                <td>
                                    <?php
                                    if (!empty($fila['foto'])) {
                                        echo '<img src="data:image/jpeg;base64,' . base64_encode($fila['foto']) . '" width="100" height="100" alt="Foto de perfil">';
                                    } else {
                                        echo '<img src="../img/sin_foto.png" width="100" height="100" alt="Imagen por defecto">';
                                    }
                                    ?>
                                </td>

                                <td><?php echo $fila['edad']; ?></td>
                                <td><?php echo $fila['direccion']; ?></td>
                                <td><?php echo $fila['telefono']; ?></td>
                                <td><?php $idMedicoAsignado = $fila['medico_asignado'];

                                    // Realizar la consulta para obtener el nombre del médico
                                    $queryMedico = mysqli_query($conexion, "SELECT nombre FROM usuario WHERE idusuario = '$idMedicoAsignado'");

                                    // Verificar si se encontró el médico y mostrar el nombre
                                    if ($queryMedico) {
                                        $filaMedico = mysqli_fetch_assoc($queryMedico);
                                        $nombreMedico = $filaMedico['nombre'];
                                    } else {
                                        // Si hay un error en la consulta, mostrar un mensaje de error o manejarlo según sea necesario
                                        echo 'Error al recuperar el nombre del médico';
                                    }
                                    echo $nombreMedico; ?></td>

                                <td>
                                    <a href="#" class="btn btn-success ver-detalle" data-id="<?php echo $fila['id']; ?>">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                                    <script>
                                        $(document).ready(function() {
                                            $(".ver-detalle").click(function() {
                                                var id = $(this).data("id");
                                                $.ajax({
                                                    url: "../includes/informacion_paciente.php",
                                                    type: "POST",
                                                    data: {
                                                        id: id
                                                    },
                                                    success: function(response) {
                                                        // Mostrar el contenido en el modal
                                                        $('#modalContenido').html(response);
                                                        $('#myModal').modal('show'); // Mostrar el modal
                                                    }
                                                });
                                            });
                                        });
                                    </script>

                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-dark text-white">
                                                    <h3 class="modal-title" id="exampleModalLabel">Información del paciente</h3>
                                                    <button type="button" class="btn btn-black" data-dismiss="modal">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Contenido del modal se llenará dinámicamente a través de JavaScript -->
                                                    <div class="p-5" id="modalContenido"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="btn btn-warning" href="../includes/editar_paciente.php?id=<?php echo $fila['id'] ?> ">
                                        <i class="fa fa-edit "></i> </a>
                                    <form action="../includes/eliminar_paciente.php?id=<?php echo $fila['id']; ?>" method="post" class="confirmar d-inline">
                                        <button class="btn btn-danger btn-del" type="button">
                                            <i class='fas fa-trash-alt'></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>

                    <script src="../package/jquery-3.6.0.min.js"></script>
                    <script src="../package/dist/sweetalert2.all.js"></script>
                    <script src="../package/dist/sweetalert2.all.min.js"></script>

                    <script>
                        $(document).ready(function() {
                            $('.btn-del').on('click', function(e) {
                                e.preventDefault();
                                const href = $(this).closest('form').attr('action');

                                Swal.fire({
                                    title: '¿Estás seguro de eliminar este paciente?',
                                    text: "¡No podrás revertir esto!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sí, eliminar!',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.value) {
                                        // Realiza la redirección si se confirma la eliminación
                                        document.location.href = href;
                                    }
                                });
                            });
                        });
                    </script>

                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php include "../includes/footer.php"; ?>
    <!-- Botón para abrir el modal -->

    <style>
        .modal-lg {
            max-width: 80%;
            /* Puedes ajustar este valor para que se adapte a tus necesidades */
        }
    </style>

    <div class="modal fade" id="PacienteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h3 class="modal-title" id="exampleModalLabel">Agregar Paciente</h3>
                    <button type="button" class="btn btn-black" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <h4 class="text-dark">Detalles del paciente</h4>
                        <hr class="my-4 bg-dark">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">Apellido Paterno*</label>
                                <input type="text" id="Apellido_paterno" name="Apellido_paterno" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom02">Apellido Materno*</label>
                                <input type="text" id="Apellido_materno" name="Apellido_materno" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustomUsername">Nombres*</label>
                                <div class="input-group">
                                    <input type="text" id="nombres" name="nombres" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento*</label>
                                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Telefono*</label>
                                <input type="text" id="telefono" name="telefono" class="form-control" required>
                            </div>
                            <div class="col-md-1 mb-3">
                                <label>Edad*</label>
                                <input type="text" id="edad" name="edad" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>DNI*</label>
                                <input type="text" id="dni" name="dni" class="form-control" required>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-9 mb-3">
                                <label class="form-label">Dirección*</label>
                                <input type="text" id="direccion" name="direccion" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Distrito*</label>
                                <input type="text" id="distrito" name="distrito" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-9 mb-3">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" id="correo" name="correo" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">grupo Sanguineo*</label>
                                <input type="text" id="sangre" name="sangre" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="medico_asignado" class="form-label">Médico Asignado*</label>
                                <select name="medico" class="custom-select" required>
                                    <option value="">Seleccionar</option>
                                    <?php
                                    $query_nivel = mysqli_query($conexion, "SELECT * FROM usuario WHERE rol NOT IN (1,2)");
                                    $resultado_nivel = mysqli_num_rows($query_nivel);
                                    if ($resultado_nivel > 0) {
                                        while ($nivel = mysqli_fetch_array($query_nivel)) {
                                    ?>
                                            <option value="<?php echo $nivel["idusuario"]; ?>"><?php echo $nivel["nombre"] ?>
                                            </option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="foto" class="form-label">Foto del paciente</label>
                                <input type="file" id="foto" name="foto" class="form-control-file" accept="image/*">
                            </div>
                        </div>
                        <h4 class="text-dark">Antecedentes personales del paciente</h4>
                        <hr class="my-4 bg-dark">
                        <h4>Historial Ginecológico:</h4>

                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="edad_menstruacion">Edad de la primera menstruación:</label>
                                <input type="text" id="edad_menstruacion" name="edad_menstruacion" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="regularidad_ciclo_menstrual">Regularidad del ciclo menstrual:</label>
                                <input type="text" id="regularidad_ciclo_menstrual" name="regularidad_ciclo_menstrual" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="uso_anticonceptivos">Uso previo de anticonceptivos:</label>
                                <input type="text" id="uso_anticonceptivos" name="uso_anticonceptivos" class="form-control">
                            </div>
                        </div>
                        <h4>Historial de Salud Mental y Emocional:</h4>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="trastornos_mentales">Historial de trastornos mentales:</label>
                                <textarea type="text" id="trastornos_mentales" name="trastornos_mentales" class="form-control"></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="abuso_sexual_fisico">Historial de Trastornos Alimenticios:</label>
                                <textarea type="text" name="transtornos_alimenticios" class="form-control"></textarea>
                            </div>
                        </div>
                        <h4>Hábitos de Salud:</h4>
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="input-group  mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Alcohol</span>
                                    </div>
                                    <input name="alcohol" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group  mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Tabaquismo</span>
                                    </div>
                                    <input name="tabaquismo" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group  mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Drogas</span>
                                    </div>
                                    <input name="drogas" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <h4>Historial quirúrgicos:</h4>
                                <input type="text" id="antecedentes_quirurgicos" name="antecedentes_quirurgicos" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <h4>Otros:</h4>
                                <input type="text" id="otros" name="otros" class="form-control">
                            </div>
                        </div>
                        <fieldset class="mb-3">
                            <legend>Alergias a medicamentos:</legend>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="alergias_medicamentos[tiene_alergias]" id="alergias_medicamentos_si" value="Si">
                                <label class="form-check-label" for="alergias_medicamentos_si">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="alergias_medicamentos[tiene_alergias]" id="alergias_medicamentos_no" value="No">
                                <label class="form-check-label" for="alergias_medicamentos_no">No</label>
                            </div>
                            <!-- Detalles adicionales en caso de "Sí" -->
                            <div id="detalles_alergias_medicamentos" style="display: none;">
                                <label for="alergias_medicamentos_detalle">Detalles:</label>
                                <input type="text" id="alergias_medicamentos_detalle" name="alergias_medicamentos[detalles]" class="form-control">
                            </div>
                        </fieldset>
                        <h4 class="text-dark">Antecedentes Familiares del paciente</h4>
                        <hr class="my-4 bg-dark">
                        <fieldset>
                            <legend>Diabetes en la familia:</legend>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="diabetes_familiar" id="diabetes_si" value="Si">
                                <label class="form-check-label" for="diabetes_si">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="diabetes_familiar" id="diabetes_no" value="No">
                                <label class="form-check-label" for="diabetes_no">No</label>
                            </div>
                            <!-- Detalles adicionales en caso de "Sí" -->
                            <div id="detalles_diabetes" style="display: none;">
                                <label for="diabetes_detalle">Detalles:</label>
                                <input type="text" id="diabetes_detalle" name="diabetes_detalle" class="form-control">
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend>Hipertensión en la familia:</legend>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hipertension_familiar" id="hipertension_si" value="Si">
                                <label class="form-check-label" for="hipertension_si">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hipertension_familiar" id="hipertension_no" value="No">
                                <label class="form-check-label" for="hipertension_no">No</label>
                            </div>
                            <!-- Detalles adicionales en caso de "Sí" -->
                            <div id="detalles_hipertension" style="display: none;">
                                <label for="hipertension_detalle">Detalles:</label>
                                <input type="text" id="hipertension_detalle" name="hipertension_detalle" class="form-control">
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Enfermedad cardiovascular en la familia:</legend>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cardiovascular_familiar" id="cardiovascular_si" value="Si">
                                <label class="form-check-label" for="cardiovascular_si">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cardiovascular_familiar" id="cardiovascular_no" value="No">
                                <label class="form-check-label" for="cardiovascular_no">No</label>
                            </div>
                            <!-- Detalles adicionales en caso de "Sí" -->
                            <div id="detalles_cardiovascular" style="display: none;">
                                <label for="cardiovascular_detalle">Detalles:</label>
                                <input type="text" id="cardiovascular_detalle" name="cardiovascular_detalle" class="form-control">
                            </div>
                        </fieldset>

                        <fieldset class="mb-3">
                            <legend>Cáncer en la familia:</legend>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cancer_familiar" id="cancer_si" value="Si">
                                <label class="form-check-label" for="cancer_si">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cancer_familiar" id="cancer_no" value="No">
                                <label class="form-check-label" for="cancer_no">No</label>
                            </div>
                            <!-- Detalles adicionales en caso de "Sí" -->
                            <div id="detalles_cancer" style="display: none;">
                                <label for="cancer_detalle">Detalles:</label>
                                <input type="text" id="cancer_detalle" name="cancer_detalle" class="form-control">
                            </div>
                        </fieldset>

                        <!-- Script para mostrar/ocultar detalles según la selección -->
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
                            <button type="submit" class="btn btn-success btn-lg mb-3">
                                <i class="fas fa-floppy-disk"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-danger btn-lg mb-3" onclick="window.location.href='pacientes.php'">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (isset($successMessage)) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Confirmación de registro!',
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