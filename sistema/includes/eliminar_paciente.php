<?php
if (!empty($_GET['id'])) {
    require("../../conexion.php");
    $id = $_GET['id'];
    $query_delete1 = mysqli_query($conexion, "DELETE FROM antecedentes WHERE paciente_id = $id");
    $query_delete = mysqli_query($conexion, "DELETE FROM pacientes WHERE id= $id");
    header("location: ../views/pacientes.php");
}
