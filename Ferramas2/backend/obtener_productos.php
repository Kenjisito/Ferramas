<?php
// Habilitar la visualización de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir la conexión a la base de datos
include('conexion.php');

// Preparar la consulta SQL para obtener todos los productos
$sql = "SELECT id_producto, nombre, descripcion, precio, categoria_id FROM productos";
$result = $conexion->query($sql);

// Verificar si la consulta SQL fue exitosa
if ($result === false) {
    echo json_encode(["error" => $conexion->error]);
    exit; // Detener la ejecución si hay un error
}

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Crear un array para almacenar los productos
    $productos = [];

    // Recorrer los resultados y agregarlos al array
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }

    // Enviar los datos de los productos como JSON
    echo json_encode($productos);
} else {
    // Enviar un mensaje si no se encontraron productos
    echo json_encode(["message" => "No se encontraron productos."]);
}

// Cerrar la conexión
$conexion->close();
?>
