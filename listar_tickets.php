<?php
require __DIR__ . '/conexao.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco. Verifique o MySQL no Laragon.']);
    exit;
}

$empresa_id = $_GET['empresa_id'] ?? null;

if ($empresa_id) {
    $stmt = $pdo->prepare("SELECT t.*, e.nome_empresa FROM tickets t JOIN empresas e ON e.id = t.empresa_id 
                            WHERE t.empresa_id = :empresa_id ORDER BY t.criado_em DESC");
    $stmt->execute(['empresa_id' => $empresa_id]);
} else {
    // sem empresa_id: retorna todos (uso do admin)
    $stmt = $pdo->query("SELECT t.*, e.nome_empresa FROM tickets t JOIN empresas e ON e.id = t.empresa_id ORDER BY t.criado_em DESC");
}

$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(['sucesso' => true, 'tickets' => $tickets]);
