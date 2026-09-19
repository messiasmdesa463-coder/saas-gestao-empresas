<?php
require __DIR__ . '/conexao.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco. Verifique o MySQL no Laragon.']);
    exit;
}

$stmt = $pdo->query("SELECT d.*, e.nome_empresa, e.email 
                     FROM documentos_empresas d
                     JOIN empresas e ON e.id = d.empresa_id
                     ORDER BY d.criado_em DESC");
$documentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['sucesso' => true, 'documentos' => $documentos]);
