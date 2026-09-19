<?php
require __DIR__ . '/conexao.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco. Verifique o MySQL no Laragon.']);
    exit;
}

$dados = json_decode(file_get_contents('php://input'), true);
if (!is_array($dados)) {
    http_response_code(400);
    echo json_encode(['erro' => 'Dados inválidos']);
    exit;
}

$chaves = [
    'nome',
    'email',
    'cargo',
    'whatsapp',
    'fotoPerfil',
    'fotoLogo',
    'banner',
    'empresaNome',
    'empresaCnpj',
    'endereco'
];

foreach ($chaves as $chave) {
    $valor = $dados[$chave] ?? '';
    $tipo = 'string';

    $stmt = $pdo->prepare("INSERT INTO configuracoes_sistema (chave, valor, tipo) VALUES (:chave, :valor, :tipo)
        ON DUPLICATE KEY UPDATE valor = VALUES(valor), tipo = VALUES(tipo), atualizado_em = CURRENT_TIMESTAMP");

    $stmt->execute([
        'chave' => $chave,
        'valor' => (string)$valor,
        'tipo' => $tipo
    ]);
}

echo json_encode(['sucesso' => true, 'mensagem' => 'Salvo com sucesso.']);
