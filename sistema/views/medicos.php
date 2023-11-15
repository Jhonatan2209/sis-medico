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
//Añadir medico
if (!empty($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['correo'];
    $user = $_POST['usuario'];
    $clave = $_POST['clave'];
    $rol = $_POST['rol'];
    $DNI = $_POST['DNI'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
    }

    $query_insert = mysqli_query($conexion, "INSERT INTO usuario(nombre,correo,usuario,clave,rol,telefono,direccion,foto,DNI) VALUES ('$nombre', '$email', '$user', '$clave', '$rol','$telefono','$direccion', '$foto','$DNI')");
    if ($query_insert) {
        $successMessage = "Usuario registrado";
    } else {
        $errorMessage = "Error al registrar el usuario";
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
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Medicos</h6>
                <br>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#medico">
                    <span class="glyphicon glyphicon-plus"></span> Agregar Medico <i class="fa-solid fa-user-doctor"></i>
                    </a></button>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>CORREO</th>
                                <th>USUARIO</th>
                                <th>DNI</th>
                                <th>DIRECCIÓN</th>
                                <th>TELEFONO</th>
                                <th>FOTO</th>
                                <th>ESPECIALIDAD</th>
                                <?php if ($_SESSION['rol'] == 1) { ?>
                                    <th>ACCIONES</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conexion, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, u.direccion, u.telefono, u.foto,u.DNI, r.rol 
                                 FROM usuario u 
                                 INNER JOIN rol r ON u.rol = r.idrol 
                                 WHERE u.rol NOT IN (1, 2)");
                            $result = mysqli_num_rows($query);

                            if ($result > 0) {
                                while ($data = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <td><?php echo $data['idusuario']; ?></td>
                                        <td><?php echo $data['nombre']; ?></td>
                                        <td><?php echo $data['correo']; ?></td>
                                        <td><?php echo $data['usuario']; ?></td>
                                        <td><?php echo $data['DNI']; ?></td>
                                        <td><?php echo $data['direccion']; ?></td>
                                        <td><?php echo $data['telefono']; ?></td>
                                        <td> <?php
                                                if (!empty($data['foto'])) {
                                                    echo '<img src="data:image/jpeg;base64,' . base64_encode($data['foto']) . '" width="100" height="100" alt="Foto de perfil">';
                                                } else {
                                                    echo '<img src="../img/sinfoto.png" width="100" height="100" alt="Imagen por defecto">';
                                                }
                                                ?></td>
                                        <td><?php echo $data['rol']; ?></td>
                                        <?php if ($_SESSION['rol'] == 1) { ?>
                                            <td>

                                                <a href="../includes/editar_medico.php?id=<?php echo $data['idusuario']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                                                <form action="../includes/eliminar_medico.php?id=<?php echo $data['idusuario']; ?>" method="post" class="confirmar d-inline">
                                                    <button class="btn btn-danger btn-del" type="button">
                                                        <i class='fas fa-trash-alt'></i>
                                                    </button>
                                                </form>

                                            </td>
                                        <?php } ?>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>


                    <script>
                        $(document).ready(function() {
                            $('.btn-del').on('click', function(e) {
                                e.preventDefault();
                                const href = $(this).closest('form').attr('action');

                                Swal.fire({
                                    title: '¿Estás seguro de eliminar este usuario?',
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
                    <script src="../package/dist/sweetalert2.all.js"></script>
                    <script src="../package/dist/sweetalert2.all.min.js"></script>
                    <script src="../package/jquery-3.6.0.min.js"></script>


                    <!-- ALerta de usuario registrado -->
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
                        window.location.href = '../views/medicos.php';
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
                    <!-- Modal para agregar usuario -->
                    <div class="modal fade" id="medico" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-dark text-white">
                                    <h3 class="modal-title" id="exampleModalLabel">Agregar un nuevo personal de salud</h3>
                                    <button type="button" class="btn btn-black" data-dismiss="modal">
                                        <i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                                <div class="modal-body">

                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="nombre" class="form-label">Nombre Completo</label>
                                            <input type="text" class="form-control" placeholder="Ingrese Nombre" name="nombre" id="nombre" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="sexo" class="form-label">Correo:</label>
                                            <input type="email" class="form-control" placeholder="Ingrese Correo Electrónico" name="correo" id="correo" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="username">Usuario:</label><br>
                                            <input type="text" class="form-control" placeholder="Ingrese Usuario" name="usuario" id="usuario" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Contraseña:</label><br>
                                            <input type="password" class="form-control" placeholder="Ingrese Contraseña" name="clave" id="clave" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="telefono">DNI:</label><br>
                                            <input type="text" class="form-control" placeholder="Ingrese DNI" name="DNI" id="telefono" maxlength="8" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="telefono">Telefono:</label><br>
                                            <input type="text" class="form-control" placeholder="Ingrese telefono" name="telefono" id="telefono" maxlength="9" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="telefono">Dirección:</label><br>
                                            <input type="text" class="form-control" placeholder="Ingrese su dirección" name="direccion" id="direccion" required>
                                        </div>


                                        <div class="form-group">
                                            <label for="pendiente" class="form-label">Tipo de usuario:</label>
                                            <select name="rol" id="rol" class="custom-select" required>
                                                <option value="">Seleccionar</option>
                                                <?php
                                                $query_rol = mysqli_query($conexion, "SELECT * FROM rol");
                                                $resultado_rol = mysqli_num_rows($query_rol);
                                                if ($resultado_rol > 0) {
                                                    while ($rol = mysqli_fetch_array($query_rol)) {
                                                        // Omitir roles con id 1 y 2
                                                        if ($rol["idrol"] != 1 && $rol["idrol"] != 2) {
                                                ?>
                                                            <option value="<?php echo $rol["idrol"]; ?>"><?php echo $rol["rol"] ?></option>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="foto">Foto:</label><br>
                                            <input type="file" name="foto" class="form-control-file" id="foto" accept="image/*">
                                        </div>
                                        <input type="hidden" name="accion" value="insert_paciente">
                                        <br>

                                        <div class="mb-3">

                                            <button type="submit" class="btn btn-success btn-lg mb-3">
                                                <i class="fas fa-floppy-disk"></i> Guardar
                                            </button>
                                            <button type="button" class="btn btn-danger btn-lg mb-3" onclick="window.location.href='medicos.php'">
                                                <i class="fas fa-times"></i> Cancelar
                                            </button>


                                        </div>
                                </div>
                            </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php include "../includes/footer.php"; ?>

    <?php include "../includes/form_doctor.php"; ?>

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->




</body>

</html>