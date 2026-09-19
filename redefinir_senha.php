<?php
require 'conexao.php';

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['email']) || empty($dados['token']) || empty($dados['nova_senha'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe email, token e nova_senha']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM tokens_recuperacao 
                        WHERE email = :email AND token = :token AND usado = FALSE AND expira_em > NOW()
                        ORDER BY id DESC LIMIT 1");
$stmt->execute(['email' => $dados['email'], 'token' => $dados['token']]);
$registro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$registro) {
    http_response_code(400);
    echo json_encode(['erro' => 'Código inválido ou expirado']);
    exit;
}

$senha_hash = password_hash($dados['nova_senha'], PASSWORD_DEFAULT);

// Atualiza a senha, seja em empresas ou usuarios
$stmt = $pdo->prepare("UPDATE empresas SET senha = :senha WHERE email = :email");
$stmt->execute(['senha' => $senha_hash, 'email' => $dados['email']]);

$stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE email = :email");
$stmt->execute(['senha' => $senha_hash, 'email' => $dados['email']]);

// Marca o token como usado
$stmt = $pdo->prepare("UPDATE tokens_recuperacao SET usado = TRUE WHERE id = :id");
$stmt->execute(['id' => $registro['id']]);

echo json_encode(['sucesso' => true, 'mensagem' => 'Senha alterada com sucesso']);