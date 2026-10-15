<?php
include 'conexao.php';
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

    <title>Cadastrar Movimentação</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .formulario {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;
            text-align: center;
        }

        .campo {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            box-sizing: border-box;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #222;
        }

        .btn-cadastrar {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #222;
            color: white;
            font-size: 15px;
            cursor: pointer;
        }

        .btn-cadastrar:hover {
            background-color: #444;
        }

        .voltar {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #222;
            text-decoration: none;
        }

        .voltar:hover {
            text-decoration: underline;
        }

    </style>

</head>

<body>

    <div class="container">

        <div class="formulario">

            <h1>Cadastrar Movimentação</h1>

            <form action="processar_formulario.php" method="POST">

                <div class="campo">

                    <label for="descricao">
                        Descrição:
                    </label>

                    <input
                        type="text"
                        id="descricao"
                        name="descricao"
                        required
                    >

                </div>

                <div class="campo">

                    <label for="valor">
                        Valor:
                    </label>

                    <input
                        type="number"
                        id="valor"
                        name="valor"
                        step="0.01"
                        min="0.01"
                        required
                    >

                </div>

                <div class="campo">

                    <label for="tipo">
                        Tipo:
                    </label>

                    <select id="tipo" name="tipo" required>

                        <option value="">
                            Selecione
                        </option>

                        <option value="entrada">
                            Entrada
                        </option>

                        <option value="saida">
                            Saída
                        </option>

                    </select>

                </div>

                <div class="campo">

                    <label for="categoria">
                        Categoria:
                    </label>

                    <select id="categoria" name="categoria_id" required>

                        <option value="">
                            Selecione
                        </option>

                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= $categoria['id'] ?>">
                                <?= htmlspecialchars($categoria['nome']) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="campo">

                    <label for="data">
                        Data:
                    </label>

                    <input
                        type="date"
                        id="data"
                        name="data"
                        required
                    >

                </div>

                <button type="submit" class="btn-cadastrar">
                    Cadastrar
                </button>

            </form>

            <a href="index.php" class="voltar">
                Voltar para a lista de movimentações
            </a>

        </div>

    </div>

</body>

</html>