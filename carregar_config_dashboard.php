<?php
require __DIR__ . '/conexao.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco. Verifique o MySQL no Laragon.']);
    exit;
}

$stmt = $pdo->query("SELECT chave, valor FROM configuracoes_sistema");
$config = $stmt->fetchAll(PDO::FETCH_ASSOC);
$saida = [];

foreach ($config as $item) {
    $saida[$item['chave']] = $item['valor'];
}

echo json_encode(['sucesso' => true, 'config' => $saida]);
