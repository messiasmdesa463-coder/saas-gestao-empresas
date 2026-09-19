<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'saas_gestao';
$usuario = 'root';
$senha = ''; // coloque aqui a senha do seu MySQL/AMPPS

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha na conexão com o banco']);
    exit;
}
