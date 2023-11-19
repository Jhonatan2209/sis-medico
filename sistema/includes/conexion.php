<?php
    $host = "localhost:3307";
    $user = "root";
    $clave = "1234";
    $bd = "sistema-medico2";

    $conexion = mysqli_connect($host,$user,$clave,$bd);
    if (mysqli_connect_errno()){
        echo "No se pudo conectar a la base de datos";
        exit();
    }

    mysqli_select_db($conexion,$bd) or die("No se encuentra la base de datos");
