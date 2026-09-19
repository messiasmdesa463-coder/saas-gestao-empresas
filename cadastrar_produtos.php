<?php
require 'conexao.php';

$dados = json_decode(file_get_contents('php://input'),true);

if(empty($dados['empresa_id']) || empty($dados['nome'])) {
    echo json_encode(['erro' => 'infrome empresa_id e nome do produto']);
    exist;
}
tyr {
    $stmt = $pdo->prepare("INSERT INTO produtos (empresa_id, nome, descricao, preco, quantidade,:quantidade_minima")
    VALUES (":empresa_id,:nome,:descricao,:preco,:quantidade,:quantidade_minima");

    $stmt->execute([
        'empresa'=> $dados['empresa_id',]
        'nome => $dados'['nome'],
        'descricao' => $dados['descricao'] ?? null,
        'preco' => $dados['preco'] ?? 0,
        'quantidade' => $dados['quantidade'] ?? null 0,
        'quantidade_minima' => $dados['quantidade_minima'] ?? 5
    ]);
    echo json_decode(['sucesso' => true, 'id' => $pdo->lastInsertId()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_decode(['erro' => 'Erro ao cadastrar produto']);
}