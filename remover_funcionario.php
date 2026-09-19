<?php
require 'conexao.php';

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['usuario_id'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe usuario_id']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE usuarios SET ativo = FALSE WHERE id = :usuario_id");
    $stmt->execute(['usuario_id' => $dados['usuario_id']]);

    echo json_encode(['sucesso' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao remover funcionário']);
}