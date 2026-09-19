<?php
require 'conexao.php';

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['nome_empresa']) || empty($dados['email']) || empty($dados['senha'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Preencha nome da empresa, e-mail e senha']);
    exit;
}

$senha_hash = password_hash($dados['senha'], PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO empresas (nome_empresa, nome_responsavel, email, senha, cep, cidade, estado) 
                            VALUES (:nome_empresa, :nome_responsavel, :email, :senha, :cep, :cidade, :estado)");
    $stmt->execute([
        'nome_empresa' => $dados['nome_empresa'],
        'nome_responsavel' => $dados['nome_responsavel'] ?? '',
        'email' => $dados['email'],
        'senha' => $senha_hash,
        'cep' => $dados['cep'] ?? null,
        'cidade' => $dados['cidade'] ?? null,
        'estado' => $dados['estado'] ?? null
    ]);

    echo json_encode(['sucesso' => true, 'id' => $pdo->lastInsertId()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao cadastrar: e-mail já pode estar em uso']);
}