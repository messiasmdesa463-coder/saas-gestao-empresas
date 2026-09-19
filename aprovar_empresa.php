<?php
require 'conexao.php';

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['empresa_id']) || empty($dados['status'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe empresa_id e status (aprovado/reprovado)']);
    exit;
}

$status = $dados['status'];

if (!in_array($status, ['aprovado', 'reprovado'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Status deve ser "aprovado" ou "reprovado"']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE empresas SET status_aprovacao = :status WHERE id = :empresa_id");
    $stmt->execute([
        'status' => $status,
        'empresa_id' => $dados['empresa_id']
    ]);

    echo json_encode(['sucesso' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao atualizar status']);
}