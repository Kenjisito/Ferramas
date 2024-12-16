<?php
session_start();
// Configuración de la transacción
$apiUrl = "https://webpay3gint.transbank.cl/rswebpaytransaction/api/webpay/v1.0/transactions";
$apiKeyId = "597055555532";
$apiKeySecret = "579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C";

// Verificar si se envió el monto en USD desde el formulario
if (isset($_POST['amount_usd'])) {
    $amount = (float) $_POST['amount_usd'];
    if ($amount <= 0) {
        die("Error: El monto en USD es inválido.");
    }

    // Redondear el monto a un entero (sin decimales)
    $amount = round($amount);

} else {
    die("Error: No se recibió el monto en USD.");
}

// Datos de la transacción
$buyOrder = uniqid(); // Genera un número único de orden
$sessionId = session_id(); // Obtiene el ID de la sesión actual
if (empty($sessionId)) {
    $sessionId = uniqid(); // Genera un ID único si no hay sesión activa
}
$returnUrl = "http://localhost/www/Ferramas/backend/retorno_transbank.php"; // URL de retorno

// Datos de la transacción en formato JSON
$data = [
    "buy_order" => $buyOrder,
    "session_id" => $sessionId,
    "amount" => $amount, // Monto en USD redondeado a un entero
    "return_url" => $returnUrl,
];

$dataString = json_encode($data);

// Iniciar cURL para hacer la solicitud a la API REST
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Tbk-Api-Key-Id: $apiKeyId",
    "Tbk-Api-Key-Secret: $apiKeySecret",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

// Decodificar la respuesta de la API
$responseData = json_decode($response, true);

// Verificar si se obtuvo una URL para redirigir al usuario
if (isset($responseData['url']) && isset($responseData['token'])) {
    $url = $responseData['url'];
    $token = $responseData['token'];

    // Redirigir al usuario a la página de pago de Transbank
    header("Location: {$url}?token_ws={$token}");
    exit;
} else {
    echo "Error al iniciar la transacción: " . json_encode($responseData);
}
?>
