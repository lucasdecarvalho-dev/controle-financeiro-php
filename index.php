<?php

include 'conexao.php';

$tipoFiltro = $_GET['tipo'] ?? '';

$dataInicial = $_GET['data_inicial'] ?? '';
$dataFinal = $_GET['data_final'] ?? '';

$sql = "SELECT movimentacoes.*, categorias.nome AS categoria_nome
FROM movimentacoes
JOIN categorias ON movimentacoes.categoria_id = categorias.id";

$condicoes = [];

if ($tipoFiltro === 'entrada' || $tipoFiltro === 'saida' ) {
    $condicoes[] = "tipo = :tipo";
}

if ($dataInicial && $dataFinal) {
    $condicoes[] = "data >= :data_inicial AND data < DATE_ADD(:data_final, INTERVAL 1 DAY)";
} else if ($dataInicial) {
    $condicoes[] = "data >= :data_inicial";
} else if ($dataFinal) {
    $condicoes[] = "data < DATE_ADD(:data_final, INTERVAL 1 DAY)";
}

if(!empty($condicoes)) {
    $sql .= " WHERE " . implode(" AND ", $condicoes);
}
$sql .= " ORDER BY data DESC";

$statement = $pdo->prepare($sql);

if ($tipoFiltro === 'entrada' || $tipoFiltro === 'saida') {
    $statement->bindValue(':tipo', $tipoFiltro);
}

if ($dataInicial && $dataFinal) {
    $statement->bindValue(':data_inicial', $dataInicial);
    $statement->bindValue(':data_final', $dataFinal);
} else if ($dataInicial) {
    $statement->bindValue(':data_inicial', $dataInicial);
} else if ($dataFinal) {
    $statement->bindValue(':data_final', $dataFinal);
}

$statement->execute();

$dados = $statement->fetchAll(PDO::FETCH_ASSOC);

$sqlTotais = "SELECT SUM(CASE WHEN tipo = 'entrada' THEN valor ELSE 0 END) AS entradas,
    SUM(CASE WHEN tipo = 'saida' THEN valor ELSE 0 END) AS despesas FROM movimentacoes";
if(!empty($condicoes)) {
    $sqlTotais .= " WHERE " . implode(" AND ", $condicoes);
}
$statementSemFiltro = $pdo->prepare($sqlTotais);

if ($tipoFiltro === 'entrada' || $tipoFiltro === 'saida') {
    $statementSemFiltro->bindValue(':tipo', $tipoFiltro);
}

if ($dataInicial && $dataFinal) {
    $statementSemFiltro->bindValue(':data_inicial', $dataInicial);
    $statementSemFiltro->bindValue(':data_final', $dataFinal);
} else if ($dataInicial) {
    $statementSemFiltro->bindValue(':data_inicial', $dataInicial);
} else if ($dataFinal) {
    $statementSemFiltro->bindValue(':data_final', $dataFinal);
}

$statementSemFiltro->execute();

$dadosSemFiltro = $statementSemFiltro->fetch(PDO::FETCH_ASSOC);

$totalEntradas = $dadosSemFiltro['entradas'];
$totalDespesas = $dadosSemFiltro['despesas'];

$saldo = $totalEntradas - $totalDespesas;

if ($saldo > 0) {
    $classeSaldo = 'saldo-positivo';
} elseif ($saldo < 0) {
    $classeSaldo = 'saldo-negativo';
} else {
    $classeSaldo = 'saldo-zero';
}

$sqlCategorias = "SELECT * FROM categorias";
$statementCategorias = $pdo->prepare($sqlCategorias);
$statementCategorias->execute();   
$categorias = $statementCategorias->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Financeiro</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <?php if (isset($_GET['sucesso'])): ?>
            <div class="mensagem-sucesso">
                <?php if ($_GET['sucesso'] === '1'): ?>
                    Movimentação cadastrada com sucesso!
                <?php elseif ($_GET['sucesso'] === 'editada'): ?>
                    Movimentação editada com sucesso!
                <?php elseif ($_GET['sucesso'] === 'excluida'): ?>
                    Movimentação excluída com sucesso!
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php include 'includes/dashboard.php'; ?>
        <?php include 'includes/filtros.php'; ?>
        <?php include 'includes/tabela-movimentacoes.php'; ?>
    </div>
</body>
</html>