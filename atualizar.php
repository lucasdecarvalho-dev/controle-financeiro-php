<?php

include 'conexao.php';

if (!isset($_POST['id']) ||
    !isset($_POST['descricao']) ||
    !isset($_POST['valor']) ||
    !isset($_POST['tipo']) ||
    !isset($_POST['categoria_id']) ||
    !isset($_POST['data'])
) {
    echo "Dados incompletos.";
    exit();
}

$id = $_POST['id'];
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$tipo = $_POST['tipo'];
$categoria_id = $_POST['categoria_id'];
$data = $_POST['data'];

// Validação básica dos dados

if (empty($id) || empty($descricao) || empty($valor) || empty($tipo) || empty($categoria_id) || empty($data)) {
    echo "Todos os campos são obrigatórios.";
    exit();
}

if (!is_numeric($valor) || $valor <= 0) {
    echo "O valor deve ser maior que zero.";
    exit();
}

if (!in_array($tipo, ['entrada', 'saida'])) {
    echo "Tipo inválido.";
    exit();
}

// Atualiza os dados no banco

$sql = "UPDATE movimentacoes SET descricao = ?, valor = ?, tipo = ?, data = ?, categoria_id = ? WHERE id = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $descricao,
    $valor,
    $tipo,
    $data,
    $categoria_id,
    $id
]);

header("Location: index.php?sucesso=editada");
exit();