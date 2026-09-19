<?php
require __DIR__ . '/conexao.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco. Verifique o MySQL no Laragon.']);
    exit;
}

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['documento_id']) || empty($dados['status'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe documento_id e status']);
    exit;
}

$status = $dados['status'];
if (!in_array($status, ['aprovado', 'reprovado'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Status deve ser aprovado ou reprovado']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE documentos_empresas SET status = :status, observacao = :observacao WHERE id = :id");
    $stmt->execute([
        'status' => $status,
        'observacao' => $dados['observacao'] ?? null,
        'id' => $dados['documento_id']
    ]);

    echo json_encode(['sucesso' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao atualizar documento']);
}
