<?php
require __DIR__ . '/conexao.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco. Verifique o MySQL no Laragon.']);
    exit;
}

$empresaId = $_GET['empresa_id'] ?? null;
if (empty($empresaId)) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe empresa_id']);
    exit;
}

$sql = "
    SELECT
        (SELECT COUNT(*) FROM produtos WHERE empresa_id = :empresa_id) AS total_produtos,
        (SELECT COUNT(*) FROM produtos WHERE empresa_id = :empresa_id AND quantidade <= quantidade_minima) AS produtos_estoque_baixo,
        (SELECT COALESCE(SUM(CASE WHEN tipo = 'entrada' THEN quantidade ELSE 0 END), 0)
         FROM movimentacoes_estoque me
         JOIN produtos p ON p.id = me.produto_id
         WHERE p.empresa_id = :empresa_id
           AND MONTH(me.criado_em) = MONTH(CURRENT_DATE())
           AND YEAR(me.criado_em) = YEAR(CURRENT_DATE())) AS entradas_estoque,
        (SELECT COALESCE(SUM(CASE WHEN tipo = 'saida' THEN quantidade ELSE 0 END), 0)
         FROM movimentacoes_estoque me
         JOIN produtos p ON p.id = me.produto_id
         WHERE p.empresa_id = :empresa_id
           AND MONTH(me.criado_em) = MONTH(CURRENT_DATE())
           AND YEAR(me.criado_em) = YEAR(CURRENT_DATE())) AS saidas_estoque,
        (SELECT COUNT(*) FROM usuarios WHERE empresa_id = :empresa_id) AS total_usuarios,
        (SELECT COUNT(*) FROM usuarios WHERE empresa_id = :empresa_id AND ativo = 1) AS usuarios_ativos,
        (SELECT COUNT(*) FROM tickets WHERE empresa_id = :empresa_id) AS tickets_total,
        (SELECT COUNT(*) FROM tickets WHERE empresa_id = :empresa_id AND status IN ('aberto', 'em_andamento')) AS tickets_abertos,
        (SELECT COUNT(*) FROM documentos_empresas WHERE empresa_id = :empresa_id AND status = 'pendente') AS documentos_pendentes,
        (SELECT COUNT(*) FROM documentos_empresas WHERE empresa_id = :empresa_id AND status = 'aprovado') AS documentos_aprovados,
        (SELECT COALESCE(SUM(preco * quantidade), 0) FROM produtos WHERE empresa_id = :empresa_id) AS valor_estoque
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['empresa_id' => $empresaId]);
$resumo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$resumo) {
    echo json_encode(['sucesso' => true, 'total_produtos' => 0, 'produtos_estoque_baixo' => 0, 'entradas_estoque' => 0, 'saidas_estoque' => 0, 'total_usuarios' => 0, 'usuarios_ativos' => 0, 'tickets_total' => 0, 'tickets_abertos' => 0, 'documentos_pendentes' => 0, 'documentos_aprovados' => 0, 'valor_estoque' => 0]);
    exit;
}

foreach ($resumo as $chave => $valor) {
    if ($valor === null) {
        $resumo[$chave] = 0;
    }
}

echo json_encode(['sucesso' => true, 'empresa_id' => (int)$empresaId] + $resumo);