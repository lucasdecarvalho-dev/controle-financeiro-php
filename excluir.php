<?php
include 'conexao.php';

$id = $_GET['id'];

$sql = "DELETE FROM movimentacoes WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);

header("Location: index.php?sucesso=excluida");
exit();
?>