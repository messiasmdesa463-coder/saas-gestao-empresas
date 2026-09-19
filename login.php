<?php
require 'conexao.php';

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['email']) || empty($dados['senha'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe e-mail e senha']);
    exit;
}

$email = $dados['email'];
$senha = $dados['senha'];

// 1. Tenta como dono da empresa
$stmt = $pdo->prepare("SELECT * FROM empresas WHERE email = :email");
$stmt->execute(['email' => $email]);
$empresa = $stmt->fetch(PDO::FETCH_ASSOC);

if ($empresa && password_verify($senha, $empresa['senha'])) {
    if ($empresa['status_aprovacao'] !== 'aprovado') {
        http_response_code(403);
        echo json_encode([
            'erro' => 'Cadastro ainda não aprovado',
            'status_aprovacao' => $empresa['status_aprovacao']
        ]);
        exit;
    }

    unset($empresa['senha']);
    echo json_encode([
        'sucesso' => true,
        'papel' => 'dono',
        'empresa_id' => $empresa['id'],
        'usuario' => $empresa
    ]);
    exit;
}

// 2. Tenta como funcionário/gerente
$stmt = $pdo->prepare("SELECT u.*, e.status_aprovacao 
                        FROM usuarios u 
                        JOIN empresas e ON e.id = u.empresa_id 
                        WHERE u.email = :email");
$stmt->execute(['email' => $email]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($senha, $usuario['senha'])) {
    if (!$usuario['ativo']) {
        http_response_code(403);
        echo json_encode(['erro' => 'Usuário desativado']);
        exit;
    }

    if ($usuario['status_aprovacao'] !== 'aprovado') {
        http_response_code(403);
        echo json_encode([
            'erro' => 'Empresa ainda não aprovada',
            'status_aprovacao' => $usuario['status_aprovacao']
        ]);
        exit;
    }

    unset($usuario['senha']);
    echo json_encode([
        'sucesso' => true,
        'papel' => $usuario['papel'],
        'empresa_id' => $usuario['empresa_id'],
        'usuario' => $usuario
    ]);
    exit;
}

http_response_code(401);
echo json_encode(['erro' => 'E-mail ou senha inválidos']);