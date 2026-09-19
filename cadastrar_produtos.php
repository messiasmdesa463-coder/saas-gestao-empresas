<?php
require __DIR__ . '/conexao.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco. Verifique o MySQL no Laragon.']);
    exit;
}

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['empresa_id']) || empty($dados['nome'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe empresa_id e nome do produto']);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO produtos (empresa_id, nome, descricao, preco, quantidade, quantidade_minima, foto) VALUES (:empresa_id, :nome, :descricao, :preco, :quantidade, :quantidade_minima, :foto)");

    $stmt->execute([
        'empresa_id' => $dados['empresa_id'],
        'nome' => $dados['nome'],
        'descricao' => $dados['descricao'] ?? null,
        'preco' => $dados['preco'] ?? 0,
        'quantidade' => $dados['quantidade'] ?? 0,
        'quantidade_minima' => $dados['quantidade_minima'] ?? 5,
        'foto' => !empty($dados['foto']) ? $dados['foto'] : null
    ]);

    echo json_encode(['sucesso' => true, 'id' => $pdo->lastInsertId()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao cadastrar produto: ' . $e->getMessage()]);
}