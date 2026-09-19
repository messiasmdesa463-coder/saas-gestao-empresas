<?php
require 'conexao.php';

$stmt = $pdo->query("SELECT id, nome_empresa, nome_responsavel, email, cidade, estado, criado_em 
                      FROM empresas WHERE status_aprovacao = 'pendente'");
$pendentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['sucesso' => true, 'pendentes' => $pendentes]);