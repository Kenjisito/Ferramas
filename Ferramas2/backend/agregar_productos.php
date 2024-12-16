<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Obtener datos del formulario (ejemplo)
$nombre = $_POST['nombre'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$precio = $_POST['precio'] ?? 0;
$categoria_id = $_POST['categoria_id'] ?? 1;

// Insertar el producto en la base de datos
$sql = "INSERT INTO productos (nombre, descripcion, precio, categoria_id) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $categoria_id);

if ($stmt->execute()) {
    echo "Producto agregado correctamente.";
} else {
    echo "Error al agregar producto: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
