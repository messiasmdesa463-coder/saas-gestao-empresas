<?php
require __DIR__ . '/conexao.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco. Verifique o MySQL no Laragon.']);
    exit;
}

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['empresa_id']) || empty($dados['assunto'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe empresa_id e assunto']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO tickets (empresa_id, assunto, descricao) VALUES (:empresa_id, :assunto, :descricao)");
    $stmt->execute([
        'empresa_id' => $dados['empresa_id'],
        'assunto' => $dados['assunto'],
        'descricao' => $dados['descricao'] ?? null
    ]);

    echo json_encode(['sucesso' => true, 'id' => $pdo->lastInsertId()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao criar chamado']);
}
