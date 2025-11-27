<?php
$host = "localhost"; 
$db   = "artesaniaslaura";
$user = "root";
$pass = "";

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

