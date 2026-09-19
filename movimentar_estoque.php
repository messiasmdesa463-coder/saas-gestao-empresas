<?php
require __DIR__ . '/conexao.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco. Verifique o MySQL no Laragon.']);
    exit;
}

$dados = json_decode(file_get_contents('php://input'), true);

if (empty($dados['produto_id']) || empty($dados['tipo']) || empty($dados['quantidade'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe produto_id, tipo (entrada/saida) e quantidade']);
    exit;
}

$tipo = $dados['tipo'];
$quantidade = (int) $dados['quantidade'];

if (!in_array($tipo, ['entrada', 'saida'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Tipo deve ser "entrada" ou "saida"']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Registra a movimentação
    $stmt = $pdo->prepare("INSERT INTO movimentacoes_estoque (produto_id, tipo, quantidade, observacao) 
                            VALUES (:produto_id, :tipo, :quantidade, :observacao)");
    $stmt->execute([
        'produto_id' => $dados['produto_id'],
        'tipo' => $tipo,
        'quantidade' => $quantidade,
        'observacao' => $dados['observacao'] ?? null
    ]);

    // Atualiza a quantidade do produto
    $operador = $tipo === 'entrada' ? '+' : '-';
    $stmt2 = $pdo->prepare("UPDATE produtos SET quantidade = quantidade $operador :quantidade WHERE id = :produto_id");
    $stmt2->execute([
        'quantidade' => $quantidade,
        'produto_id' => $dados['produto_id']
    ]);

    $pdo->commit();
    echo json_encode(['sucesso' => true]);
} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao registrar movimentação']);
}