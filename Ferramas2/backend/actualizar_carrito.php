<?php
header('Content-Type: application/json');

// Recibir datos del cliente
$datos = json_decode(file_get_contents('php://input'), true);

// Validar datos recibidos
if (isset($datos['productoId']) && isset($datos['cantidad'])) {
    // Aquí irían las operaciones de base de datos para actualizar el carrito
    // Por ahora solo simulamos una respuesta exitosa
    echo json_encode([
        "success" => true,
        "message" => "Carrito actualizado correctamente",
        "productoId" => $datos['productoId'],
        "nuevaCantidad" => $datos['cantidad']
    ]);
} else {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Datos inválidos"
    ]);
}
?>
