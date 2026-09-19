<?php
require __DIR__ . '/conexao.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco. Verifique o MySQL no Laragon.']);
    exit;
}

require __DIR__ . '/enviar_email.php';

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['email'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe o e-mail']);
    exit;
}

$email = $dados['email'];

// Confirma que o e-mail existe (em empresas OU usuarios)
$stmt = $pdo->prepare("SELECT id FROM empresas WHERE email = :email 
                        UNION SELECT id FROM usuarios WHERE email = :email");
$stmt->execute(['email' => $email]);

if (!$stmt->fetch()) {
    // Por segurança, não revela se o e-mail existe ou não
    echo json_encode(['sucesso' => true, 'mensagem' => 'Se o e-mail existir, um código foi enviado']);
    exit;
}

$token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
$expira = date('Y-m-d H:i:s', strtotime('+15 minutes'));

$stmt = $pdo->prepare("INSERT INTO tokens_recuperacao (email, token, expira_em) VALUES (:email, :token, :expira)");
$stmt->execute(['email' => $email, 'token' => $token, 'expira' => $expira]);

$enviado = enviarEmail($email, 'Recuperação de senha', "Seu código de recuperação é: <b>$token</b><br>Ele expira em 15 minutos.");

if ($enviado) {
    echo json_encode(['sucesso' => true, 'mensagem' => 'Código enviado por e-mail']);
} else {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha ao enviar o e-mail']);
}