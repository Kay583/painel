<?php
session_start();
include_once('config.php');

if (!isset($_SESSION['email'])) {
    header('Location: ../login/login.html');
    exit();
}

$sql = "SELECT nome_produto, vendas FROM produtos_vendas ORDER BY vendas DESC LIMIT 10";
$result = $conn->query($sql);

$produtos = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $produtos[] = $row;
    }
}

// Retorna somente JSON e encerra o script
header('Content-Type: application/json');
echo json_encode($produtos);
exit();
?>