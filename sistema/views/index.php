<?php
// Seguridad de sesiones
session_start();
error_reporting(0);
$varsesion = $_SESSION['nombre'];

if ($varsesion == null || $varsesion = '') {

    header("Location: ../../index.php");
    die();
}


include '../includes/header.php';
include '../../conexion.php';
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <h1>Bienvenido <?php echo $_SESSION['nombre']; ?></h1>
    <br>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Panel Administrativo</h1>

    </div>


    <!-- Content Row -->
    <div class="row">
        <!-- tarjetas-->
        <a class="col-xl-3 col-md-6 mb-4 text-decoration-none" href="pacientes.php">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"> Pacientes</div>

                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-users fa-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <!-- tarjetas-->
        <a class="col-xl-3 col-md-6 mb-4 text-decoration-none" href="medicos.php">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Medicos</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-user-doctor fa-2xl" style="color: #02bb74;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>

        <!-- tarjetas-->
        <a class="col-xl-3 col-md-6 mb-4 text-decoration-none" href="">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Citas</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-calendar-days fa-2xl" style="color: #0c9d9a;"></i>
                        </div>

                    </div>
                </div>
            </div>
        </a>

        <!-- examenes y pruebas-->
        <a class="col-xl-3 col-md-6 mb-4 text-decoration-none" href="informacion.php">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Examenes y pruebas
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-flask fa-2xl" style="color: #e7a20d;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <?php
                    $sentencia = $conexion->prepare("SELECT u.nombre, r.rol AS nombre_rol FROM usuario u 
                                                                JOIN rol r ON u.rol = r.idrol 
                                                                WHERE u.rol IN (3, 4) 
                                                                ORDER BY u.idusuario DESC LIMIT 3;");
                    $sentencia->execute();
                    $resultado = $sentencia->get_result();

                    $data = array();
                    while ($fila = $resultado->fetch_assoc()) {
                        $data[] = $fila;
                    }
                    ?>
                    <?php if (count($data) > 0) : ?>
                        <div class="m-4">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Nuevos médicos</th>
                                        <th>Rol</th>

                                    </tr>
                                </thead>

                                <?php foreach ($data as $d) : ?>
                                    <tr>
                                        <td><?php echo $d['nombre'] ?></td>
                                        <td><?php echo $d['nombre_rol'] ?></td>
                                        <!-- Agrega más columnas según las necesidades -->

                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>

                        <div class="alert">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <strong>Danger!</strong> No hay datos.
                        </div>
                    <?php endif; ?>

                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card shadow mb-4">
                    <?php
                    $sentencia = $conexion->prepare("SELECT u.nombre, r.rol AS nombre_rol FROM usuario u 
                                             JOIN rol r ON u.rol = r.idrol 
                                             WHERE u.rol = 2 
                                             ORDER BY u.idusuario DESC LIMIT 3;");
                    $sentencia->execute();
                    $resultado = $sentencia->get_result();

                    $data = array();
                    while ($fila = $resultado->fetch_assoc()) {
                        $data[] = $fila;
                    }
                    ?>
                    <?php if (count($data) > 0) : ?>
                        <div class="m-4">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Nuevos Pacientes</th>
                                    </tr>
                                </thead>

                                <?php foreach ($data as $d) : ?>
                                    <tr>
                                        <td><?php echo $d['nombre'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>

                        <div class="alert">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <strong>Danger!</strong> No hay datos.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- End of Content Wrapper -->

</div>

<!-- End of Page Wrapper -->

<?php include '../includes/footer.php'; ?>

</html>