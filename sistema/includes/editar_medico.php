<?php
include 'header.php';
include '../../conexion.php';
if (!empty($_POST['nombre'])) {
    $idusuario = $_POST['idusuario']; // Obtener el idusuario del campo oculto
    $nombre = $_POST['nombre'];
    $email = $_POST['correo'];
    $user = $_POST['usuario'];
    $clave = $_POST['clave'];
    $rol = $_POST['rol'];
    $DNI = $_POST['DNI'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Verificar si se seleccionó un archivo de imagen
    if (!empty($_FILES['foto']['tmp_name']) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
        // Procesar y guardar la nueva imagen
        $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
        $query_update = mysqli_query($conexion, "UPDATE usuario SET nombre='$nombre', correo='$email', usuario='$user', clave='$clave', rol='$rol', telefono='$telefono', direccion='$direccion', foto='$foto',DNI='$DNI' WHERE idusuario='$idusuario'");
    } else {
        // Conservar la imagen existente en la base de datos
        $query_update = mysqli_query($conexion, "UPDATE usuario SET nombre='$nombre', correo='$email', usuario='$user', clave='$clave', rol='$rol', telefono='$telefono', direccion='$direccion',DNI='$DNI' WHERE idusuario='$idusuario'");
    }

    if ($query_update) {
        $successMessage = "Usuario Actualizado";
    } else {
        $errorMessage = "Error al actualizar el usuario";
    }
} ?>
<script src="../package/jquery-3.6.0.min.js"></script>
<script src="../package/dist/sweetalert2.all.js"></script>
<script src="../package/dist/sweetalert2.all.min.js"></script>

<div class="container-fluid">
    <!-- ALerta de usuario registrado -->
    <?php
    if (isset($successMessage)) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: '¡Confirmación de Actualización!',
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
    <?php
    // Mostrar Datos

    if (empty($_REQUEST['id'])) {
        header("Location: medicos.php");
    }
    $idusuario = $_REQUEST['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM usuario WHERE idusuario = $idusuario");
    $result_sql = mysqli_num_rows($sql);
    if ($result_sql == 0) {
        header("Location: medicos.php");
    } else {
        if ($data = mysqli_fetch_array($sql)) {
            $idcliente = $data['idusuario'];
            $nombre = $data['nombre'];
            $correo = $data['correo'];
            $contra = $data['clave'];
            $DNI = $data['DNI'];
            $usuario = $data['usuario'];
            $rol = $data['rol'];
            $telefono = $data['telefono'];
            $direccion = $data['direccion'];
        }
    }
    ?>

    <div class="container my-3">

        <div class="row justify-content-center">
            <div class="col-xl-8  col-md-8">
                <div class="card o-hidden border-0 shadow-lg my-3">
                    <div class="card-body p-0">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-4">
                                    <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
                                        <h1 class="h3 text-gray-900 mb-2 text-center">Editar usuario</h1>
                                        <input type="hidden" name="idusuario" value="<?php echo $idcliente; ?>">
                                        <div class="form-group">
                                            <h1 class="h5 text-gray-900 mb-2">Nombre</h1>
                                            <input type="text" placeholder="Ingrese nombre" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <h1 class="h5 text-gray-900 mb-2">Correo</h1>
                                            <input type="text" placeholder="Ingrese correo" class="form-control" name="correo" id="correo" value="<?php echo $correo; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <h1 class="h5 text-gray-900 mb-2">Usuario</h1>
                                            <input type="text" placeholder="Ingrese usuario" class="form-control" name="usuario" id="usuario" value="<?php echo $usuario; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <h1 class="h5 text-gray-900 mb-2">Contraseña</h1>
                                            <input type="password" placeholder="Ingrese contraseña" class="form-control" name="clave" id="clave" value="<?php echo $contra; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <h1 class="h5 text-gray-900 mb-2">DNI</h1>
                                            <input type="text" class="form-control" placeholder="Ingrese DNI" name="DNI" id="DNI" maxlength="8" value="<?php echo $DNI; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <h1 class="h5 text-gray-900 mb-2">Telefono</h1>
                                            <input type="number" class="form-control" placeholder="Ingrese telefono" value="<?php echo $telefono; ?>" name="telefono" id="telefono" maxlength="9" required>
                                        </div>
                                        <div class="form-group">
                                            <h1 class="h5 text-gray-900 mb-2">Direccion</h1>
                                            <input type="text" class="form-control" placeholder="Ingrese direccion" value="<?php echo $direccion; ?>" name="direccion" id="direccion" maxlength="9" required>
                                        </div>
                                        <div class="form-group">
                                            <h1 class="h5 text-gray-900 mb-2">Tipo de usuario</h1>
                                            <select name="rol" id="rol" class="form-control" required>
                                                <option value="1" <?php
                                                                    if ($rol == 1) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Administrador</option>
                                                <option value="2" <?php
                                                                    if ($rol == 2) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Gestante</option>
                                                <option value="3" <?php
                                                                    if ($rol == 3) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Obstetra</option>
                                                <option value="4" <?php
                                                                    if ($rol == 4) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Ginecologa</option>
                                                <option value="5" <?php
                                                                    if ($rol == 5) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Enfermera</option>

                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <?php
                                            if (!empty($data['foto'])) {
                                            ?> <h1 class="h5 text-gray-900 mb-2">Foto actual</h1>
                                            <?php
                                                echo '<img src="data:image/jpeg;base64,' . base64_encode($data['foto']) . '" width="150" height="150" alt="Foto de perfil"  style="border: 2px solid #000;" >';
                                            } else {
                                                echo '<div class="alert alert-danger" role="alert">
El usuario no tiene foto de perfil!
</div>';
                                            }
                                            ?>
                                            <h1 class="h5 text-gray-900 mb-2">Foto de perfil</h1>
                                            <input type="file" class="form-control-file" name="foto" accept="image/*">
                                        </div>
                                        <div class="text-center">
                                            <input type="submit" value="Actualizar" class="btn btn-success btn-lg mb-3">
                                            <a href="../views/medicos.php" class="btn btn-danger btn-lg mb-3">Cancelar</a>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






</div>


<?php include_once "footer.php"; ?>