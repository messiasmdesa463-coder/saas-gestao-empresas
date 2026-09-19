<?php
require __DIR__ . '/conexao.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco. Verifique o MySQL no Laragon.']);
    exit;
}

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['ticket_id']) || empty($dados['status'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe ticket_id e status']);
    exit;
}

$validos = ['aberto', 'em_andamento', 'resolvido', 'fechado'];
if (!in_array($dados['status'], $validos)) {
    http_response_code(400);
    echo json_encode(['erro' => 'Status inválido']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE tickets SET status = :status WHERE id = :id");
    $stmt->execute(['status' => $dados['status'], 'id' => $dados['ticket_id']]);
    echo json_encode(['sucesso' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao atualizar chamado']);
}
