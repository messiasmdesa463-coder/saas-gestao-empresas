<?php
function enviarWhatsApp($numeroDestino, $mensagem) {
    $token = getenv('WHATSAPP_TOKEN') ?: 'SEU_TOKEN_AQUI';
    $phoneNumberId = getenv('WHATSAPP_PHONE_NUMBER_ID') ?: 'SEU_PHONE_NUMBER_ID_AQUI';

    $url = "https://graph.facebook.com/v21.0/$phoneNumberId/messages";

    $dados = [
        'messaging_product' => 'whatsapp',
        'to' => $numeroDestino,
        'type' => 'text',
        'text' => ['body' => $mensagem]
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $token",
            "Content-Type: application/json"
        ],
        CURLOPT_POSTFIELDS => json_encode($dados)
    ]);

    $resposta = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $statusCode >= 200 && $statusCode < 300;
}

if (php_sapi_name() !== 'cli' && basename($_SERVER['SCRIPT_FILENAME'] ?? '') === basename(__FILE__)) {
    $dados = json_decode(file_get_contents('php://input'), true);

    if (empty($dados['numero']) || empty($dados['mensagem'])) {
        http_response_code(400);
        echo json_encode(['erro' => 'Informe numero e mensagem']);
        exit;
    }

    $enviado = enviarWhatsApp($dados['numero'], $dados['mensagem']);
    echo json_encode(['sucesso' => $enviado]);
}