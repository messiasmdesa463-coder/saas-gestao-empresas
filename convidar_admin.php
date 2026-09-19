<?php
require 'verificar_admin.php';
require 'conexao.php';
require 'enviar_email.php';

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['email']) || empty($dados['nome'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe nome e email']);
    exit;
}

$email = $dados['email'];
$nome = $dados['nome'];

// Confere se já existe um admin com esse e-mail
$stmt = $pdo->prepare("SELECT id FROM admins WHERE email = :email");
$stmt->execute(['email' => $email]);
if ($stmt->fetch()) {
    http_response_code(400);
    echo json_encode(['erro' => 'Já existe um administrador com esse e-mail']);
    exit;
}

// Gera uma senha aleatória de 10 caracteres
$senhaGerada = substr(str_shuffle('ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789'), 0, 10);
$senhaHash = password_hash($senhaGerada, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO admins (nome, email, senha) VALUES (:nome, :email, :senha)");
    $stmt->execute(['nome' => $nome, 'email' => $email, 'senha' => $senhaHash]);

    $linkPainel = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/sistema/tela_login_admin.php';

    $corpo = "
        <h2>Você foi convidado para ser administrador</h2>
        <p>Olá, $nome! Você recebeu acesso ao painel administrativo do Sistema SaaS Gestão.</p>
        <p><b>E-mail de acesso:</b> $email</p>
        <p><b>Senha provisória:</b> $senhaGerada</p>
        <p>Acesse o painel pelo link abaixo e recomendamos trocar a senha após o primeiro login:</p>
        <p><a href='$linkPainel'>$linkPainel</a></p>
    ";

    $enviado = enviarEmail($email, 'Convite: Acesso ao Painel Administrativo', $corpo);

    echo json_encode([
        'sucesso' => true,
        'email_enviado' => $enviado,
        'mensagem' => $enviado ? 'Convite enviado por e-mail' : 'Admin criado, mas o e-mail falhou ao enviar'
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao criar administrador']);
}
