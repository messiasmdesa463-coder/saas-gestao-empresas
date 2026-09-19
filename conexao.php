<?php
header('Content-Type: application/json');

$host = '127.0.0.1';
$dbname = 'saas_gestao';

$credenciais = [
    ['root', 'Messias'],
    ['root', ''],
    ['root', 'root'],
    ['root', '123456'],
    ['root', 'mysql'],
    ['root', 'admin'],
    ['root', 'pass'],
    ['root', 'senha'],
    ['laragon', 'laragon']
];

$pdo = null;

foreach ($credenciais as [$usuario, $senha]) {
    try {
        $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $usuario, $senha, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);

        $bancos = $pdo->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);

        if (!in_array($dbname, $bancos, true)) {
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        }

        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $usuario, $senha, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);

        break;
    } catch (PDOException $e) {
        $pdo = null;
    }
}

if (!$pdo) {
    http_response_code(500);
    echo json_encode([
        'erro' => 'Falha na conexão com o banco. Inicie o MySQL no Laragon e confirme usuário/senha do banco.'
    ]);
    exit;
}

$pdo->exec("CREATE TABLE IF NOT EXISTS planos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    limite_produtos INT DEFAULT NULL,
    limite_usuarios INT DEFAULT NULL,
    descricao TEXT,
    ativo BOOLEAN DEFAULT TRUE,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_empresa VARCHAR(150) NOT NULL,
    nome_responsavel VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    cnpj VARCHAR(18) NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    site VARCHAR(150),
    foto_url VARCHAR(255),
    cep VARCHAR(9),
    endereco VARCHAR(255),
    cidade VARCHAR(100),
    estado CHAR(2),
    plano_id INT,
    status_aprovacao ENUM('pendente', 'aprovado', 'reprovado') DEFAULT 'pendente',
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (plano_id) REFERENCES planos(id)
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS documentos_empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    tipo VARCHAR(80) NOT NULL,
    nome_documento VARCHAR(150) NOT NULL,
    caminho_arquivo VARCHAR(255),
    status ENUM('pendente', 'aprovado', 'reprovado') DEFAULT 'pendente',
    observacao TEXT,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2),
    quantidade INT DEFAULT 0,
    quantidade_minima INT DEFAULT 5,
    foto LONGTEXT NULL,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
)");

$fotoExiste = $pdo->query("SHOW COLUMNS FROM produtos LIKE 'foto'")->fetch();
if (!$fotoExiste) {
    $pdo->exec("ALTER TABLE produtos ADD COLUMN foto LONGTEXT NULL");
}

$pdo->exec("CREATE TABLE IF NOT EXISTS movimentacoes_estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    tipo ENUM('entrada', 'saida') NOT NULL,
    quantidade INT NOT NULL,
    observacao VARCHAR(255),
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    assunto VARCHAR(200) NOT NULL,
    descricao TEXT,
    status ENUM('aberto', 'em_andamento', 'resolvido', 'fechado') DEFAULT 'aberto',
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empresa_id INT NOT NULL,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    papel ENUM('dono', 'gerente', 'funcionario', 'admin') DEFAULT 'funcionario',
    ativo BOOLEAN DEFAULT TRUE,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id)
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS tokens_recuperacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    expires_at DATETIME NOT NULL,
    usado BOOLEAN DEFAULT FALSE,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS configuracoes_sistema (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chave VARCHAR(80) NOT NULL UNIQUE,
    valor TEXT,
    tipo ENUM('string', 'json', 'bool') DEFAULT 'string',
    atualizado_em DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

$pdo->exec("ALTER TABLE usuarios MODIFY papel ENUM('dono', 'gerente', 'funcionario', 'admin') NOT NULL DEFAULT 'funcionario'");

$empresaAdmin = $pdo->query("SELECT id FROM empresas WHERE email = 'admin@saasgestao.local' LIMIT 1")->fetch();
if (!$empresaAdmin) {
    $empresaAdminId = $pdo->prepare("INSERT INTO empresas (nome_empresa, nome_responsavel, email, cnpj, senha, status_aprovacao, cidade, estado) VALUES (:nome_empresa, :nome_responsavel, :email, :cnpj, :senha, 'aprovado', 'São Paulo', 'SP')");
    $empresaAdminId->execute([
        'nome_empresa' => 'Admin SaaS',
        'nome_responsavel' => 'Administrador',
        'email' => 'admin@saasgestao.local',
        'cnpj' => '00000000000000',
        'senha' => password_hash('admin123', PASSWORD_DEFAULT)
    ]);
    $empresaAdminIdValue = $pdo->lastInsertId();
} else {
    $empresaAdminIdValue = $empresaAdmin['id'];
}

$adminExiste = $pdo->query("SELECT id FROM usuarios WHERE email = 'admin@saasgestao.local' LIMIT 1")->fetch();
if (!$adminExiste) {
    $stmtAdmin = $pdo->prepare("INSERT INTO usuarios (empresa_id, nome, email, senha, papel, ativo) VALUES (:empresa_id, :nome, :email, :senha, 'admin', 1)");
    $stmtAdmin->execute([
        'empresa_id' => $empresaAdminIdValue,
        'nome' => 'Administrador Master',
        'email' => 'admin@saasgestao.local',
        'senha' => password_hash('admin123', PASSWORD_DEFAULT)
    ]);
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
