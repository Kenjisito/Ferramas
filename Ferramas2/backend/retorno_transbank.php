<?php
$token = $_POST['token_ws'] ?? null;

$statusMessage = "Pago rechazado o no autorizado.";
$statusClass = "status-failed"; // Clase por defecto para el estado fallido
$orderNumber = "-"; // Número de orden por defecto

if ($token) {
    // Configuración de la API
    $apiUrl = "https://webpay3gint.transbank.cl/rswebpaytransaction/api/webpay/v1.0/transactions/$token";
    $apiKeyId = "597055555532"; 
    $apiKeySecret = "579B532A7440BB0C9079DED94D31EA1615BACEB56610332264630D42D0A36B1C";

    // Confirmar la transacción con cURL
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Tbk-Api-Key-Id: $apiKeyId",
        "Tbk-Api-Key-Secret: $apiKeySecret",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['status']) && $responseData['status'] === 'AUTHORIZED') {
        $statusMessage = "Pago aprobado. ¡Gracias por su compra!";
        $statusClass = "status-success";
        $orderNumber = $responseData['buy_order'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado del Pago - Ferramas Online</title>
    <link rel="stylesheet" href="assets/estilos.css">
</head>
<body>
    <div class="retorno-container">
        <div class="retorno-box <?php echo $statusClass; ?>">
            <h1>Resultado de la Transacción</h1>
            <p class="status-message"><?php echo $statusMessage; ?></p>
            <p><strong>Número de Orden:</strong> <?php echo $orderNumber; ?></p>
        </div>
    </div>
</body>
</html>
