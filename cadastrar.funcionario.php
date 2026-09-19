<?php
require __DIR__ . '/conexao.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco. Verifique o MySQL no Laragon.']);
    exit;
}

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

$email = trim((string)$dados['email']);

try {
    $check = $pdo->prepare("SELECT id FROM usuarios WHERE LOWER(email) = LOWER(:email) LIMIT 1");
    $check->execute(['email' => $email]);

    if ($check->fetch()) {
        http_response_code(409);
        echo json_encode(['erro' => 'Este e-mail já está em uso por outro colaborador.']);
        exit;
    }

    $senha_hash = password_hash($dados['senha'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO usuarios (empresa_id, nome, email, senha, papel) 
                            VALUES (:empresa_id, :nome, :email, :senha, :papel)");
    $stmt->execute([
        'empresa_id' => $dados['empresa_id'],
        'nome' => $dados['nome'],
        'email' => $email,
        'senha' => $senha_hash,
        'papel' => $papel
    ]);

    echo json_encode(['sucesso' => true, 'id' => $pdo->lastInsertId()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao cadastrar funcionário. Verifique os dados e tente novamente.']);
}