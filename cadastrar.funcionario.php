<?php
require 'conexao.php';

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['empresa_id']) || empty($dados['nome']) || empty($dados['email']) || empty($dados['senha'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe empresa_id, nome, email e senha']);
    exit;
}

$papel = $dados['papel'] ?? 'funcionario';
if (!in_array($papel, ['dono', 'gerente', 'funcionario'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Papel deve ser dono, gerente ou funcionario']);
    exit;
}

$senha_hash = password_hash($dados['senha'], PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (empresa_id, nome, email, senha, papel) 
                            VALUES (:empresa_id, :nome, :email, :senha, :papel)");
    $stmt->execute([
        'empresa_id' => $dados['empresa_id'],
        'nome' => $dados['nome'],
        'email' => $dados['email'],
        'senha' => $senha_hash,
        'papel' => $papel
    ]);

    echo json_encode(['sucesso' => true, 'id' => $pdo->lastInsertId()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao cadastrar funcionário: e-mail já pode estar em uso']);
}