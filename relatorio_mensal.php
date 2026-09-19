<?php
require 'conexao.php';

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['email']) || empty($dados['senha'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe e-mail e senha']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM empresas WHERE email = :email");
$stmt->execute(['email' => $dados['email']]);
$empresa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$empresa || !password_verify($dados['senha'], $empresa['senha'])) {
    http_response_code(401);
    echo json_encode(['erro' => 'E-mail ou senha inválidos']);
    exit;
}

if ($empresa['status_aprovacao'] !== 'aprovado') {
    http_response_code(403);
    echo json_encode([
        'erro' => 'Cadastro ainda não aprovado',
        'status_aprovacao' => $empresa['status_aprovacao']
    ]);
    exit;
}

unset($empresa['senha']);
echo json_encode(['sucesso' => true, 'empresa' => $empresa]);