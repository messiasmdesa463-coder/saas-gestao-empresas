<?php
// Inclua este arquivo no topo de qualquer endpoint que só o admin pode acessar
session_start();

if (empty($_SESSION['admin_id'])) {
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['erro' => 'Acesso restrito ao admin. Faça login primeiro.']);
    exit;
}
