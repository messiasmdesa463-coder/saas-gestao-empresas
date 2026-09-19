<?php
function enviarWhatsApp($numeroDestino, $mensagem) {
    $token = 'SEU_TOKEN_AQUI';
    $phoneNumberId = 'SEU_PHONE_NUMBER_ID_AQUI';

    $url = "https://graph.facebook.com/v21.0/$phoneNumberId/messages";

    $dados = [
        'messaging_product' => 'whatsapp',
        'to' => $numeroDestino, // formato: 5511999999999 (com código do país, sem + ou espaços)
        'type' => 'text',
        'text' => ['body' => $mensagem]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));

    $resposta = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $statusCode === 200;
}
<?php
require 'enviar_whatsapp.php';

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['numero']) || empty($dados['mensagem'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe numero e mensagem']);
    exit;
}

$enviado = enviarWhatsApp($dados['numero'], $dados['mensagem']);

echo json_encode(['sucesso' => $enviado]);