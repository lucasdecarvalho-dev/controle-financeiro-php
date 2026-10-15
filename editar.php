<?php

include 'conexao.php';

if (!isset($_GET['id'])) {
    echo "ID não informado.";
    exit();
}

$id = $_GET['id'];

// Busca a movimentação pelo ID
$sql = "SELECT * FROM movimentacoes WHERE id = :id";

$statement = $pdo->prepare($sql);
$statement->bindParam(':id', $id);
$statement->execute();

$movimentacao = $statement->fetch(PDO::FETCH_ASSOC);

if (!$movimentacao) {
    echo "Movimentação não encontrada.";
    exit();
}

$sqlCategorias = "SELECT * FROM categorias";
$statementCategorias = $pdo->prepare($sqlCategorias);
$statementCategorias->execute();   
$categorias = $statementCategorias->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/editar.css">
    <title>Editar Movimentação</title>
</head>

<body>

    <form action="atualizar.php" method="POST">

        <input
            type="hidden"
            name="id"
            value="<?= $movimentacao['id'] ?>"
        >

        <input
            type="text"
            name="descricao"
            value="<?= htmlspecialchars($movimentacao['descricao']) ?>"
            required
        >

        <input
            type="number"
            name="valor"
            value="<?= $movimentacao['valor'] ?>"
            step="0.01"
            min="0.01"
            required
        >

        <select name="tipo" required>

            <option
                value="entrada"
                <?= $movimentacao['tipo'] === 'entrada' ? 'selected' : '' ?>
            >
                Entrada
            </option>

            <option
                value="saida"
                <?= $movimentacao['tipo'] === 'saida' ? 'selected' : '' ?>
            >
                Saída
            </option>

        </select>

        <select name="categoria_id" required>
            <?php foreach ($categorias as $categoria): ?>
                <option
                    value="<?= $categoria['id'] ?>"
                    <?= $movimentacao['categoria_id'] == $categoria['id'] ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars($categoria['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input
            type="date"
            name="data"
            value="<?= date('Y-m-d', strtotime($movimentacao['data'])) ?>"
            required
        >

        <button type="submit">Salvar</button>

    </form>

</body>

</html>