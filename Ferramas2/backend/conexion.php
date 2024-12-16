<?php
$host = "localhost";
$port = 3306;
$dbname = "ferramas";
$username = "root";
$password = "Macaa1603_";

// Crear una conexión usando mysqli
$conexion = new mysqli($host, $username, $password, $dbname, $port);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8 para evitar problemas con caracteres especiales
$conexion->set_charset("utf8");
?>
