<?php
require __DIR__ . '/conexao.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco. Verifique o MySQL no Laragon.']);
    exit;
}

$raw = file_get_contents('php://input');
$dados = [];

if ($raw !== '') {
    $json = json_decode($raw, true);
    if (is_array($json)) {
        $dados = $json;
    } else {
        parse_str($raw, $dados);
    }
}

if (empty($dados) && !empty($_POST)) {
    $dados = $_POST;
}

if (!is_array($dados)) {
    http_response_code(400);
    echo json_encode(['erro' => 'Dados de cadastro inválidos']);
    exit;
}

$nomeEmpresa = trim((string)($dados['nome_empresa'] ?? ''));
$nomeResponsavel = trim((string)($dados['nome_responsavel'] ?? ''));
$email = trim((string)($dados['email'] ?? ''));
$senha = trim((string)($dados['senha'] ?? ''));
$cnpj = preg_replace('/\D+/', '', (string)($dados['cnpj'] ?? ''));
$cep = trim((string)($dados['cep'] ?? ''));
$cidade = trim((string)($dados['cidade'] ?? ''));
$estado = trim((string)($dados['estado'] ?? ''));

if ($nomeEmpresa === '' || $nomeResponsavel === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($senha) < 8 || strlen($cnpj) !== 14) {
    http_response_code(400);
    echo json_encode(['erro' => 'Preencha nome da empresa, responsável, e-mail válido, senha com pelo menos 8 caracteres e CNPJ válidos']);
    exit;
}

try {
    $check = $pdo->prepare("SELECT id FROM empresas WHERE LOWER(email) = LOWER(:email) OR cnpj = :cnpj LIMIT 1");
    $check->execute([
        'email' => $email,
        'cnpj' => $cnpj
    ]);

    if ($check->fetch()) {
        http_response_code(409);
        echo json_encode(['erro' => 'E-mail ou CNPJ já cadastrado. Faça login ou use outro cadastro.']);
        exit;
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO empresas (nome_empresa, nome_responsavel, email, cnpj, senha, cep, cidade, estado) 
                            VALUES (:nome_empresa, :nome_responsavel, :email, :cnpj, :senha, :cep, :cidade, :estado)");
    $stmt->execute([
        'nome_empresa' => $nomeEmpresa,
        'nome_responsavel' => $nomeResponsavel,
        'email' => $email,
        'cnpj' => $cnpj,
        'senha' => $senhaHash,
        'cep' => $cep !== '' ? $cep : null,
        'cidade' => $cidade !== '' ? $cidade : null,
        'estado' => $estado !== '' ? $estado : null
    ]);

    echo json_encode(['sucesso' => true, 'id' => $pdo->lastInsertId()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao cadastrar. Verifique e-mail e CNPJ e tente novamente.']);
}