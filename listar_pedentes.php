<?php
require __DIR__ . '/conexao.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco. Verifique o MySQL no Laragon.']);
    exit;
}

$stmt = $pdo->query("SELECT id, nome_empresa, nome_responsavel, email, cidade, estado, criado_em 
                      FROM empresas WHERE status_aprovacao = 'pendente'");
$pendentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['sucesso' => true, 'pendentes' => $pendentes]);