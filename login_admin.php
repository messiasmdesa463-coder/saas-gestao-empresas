<?php
session_start();
require 'conexao.php';

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['email']) || empty($dados['senha'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe e-mail e senha']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM admins WHERE email = :email");
$stmt->execute(['email' => $dados['email']]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin && password_verify($dados['senha'], $admin['senha'])) {
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_nome'] = $admin['nome'];
    echo json_encode(['sucesso' => true, 'nome' => $admin['nome']]);
} else {
    http_response_code(401);
    echo json_encode(['erro' => 'E-mail ou senha inválidos']);
}
