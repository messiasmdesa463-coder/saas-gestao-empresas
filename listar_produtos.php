<?php
require 'conexao.php';

$empresa_id = $_GET['empresa_id'] ?? null;

if (!$empresa_id) {
    http_response_code(400);
    echo json_encode(['erro' => 'Informe empresa_id']);
    exit;
}

$stmt = $pdo->prepare("SELECT *, (quantidade <= quantidade_minima) AS estoque_baixo 
                        FROM produtos WHERE empresa_id = :empresa_id");
$stmt->execute(['empresa_id' => $empresa_id]);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['sucesso' => true, 'produtos' => $produtos]);