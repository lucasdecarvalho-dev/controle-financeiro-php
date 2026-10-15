<div class="cabecalho">
    <div class="titulo-movimentacoes">
        <h1>Movimentações</h1>

        <form method="GET">
            <select name="tipo" onchange="this.form.submit()">
                <option value="">Todos</option>

                <option value="entrada" <?= $tipoFiltro === 'entrada' ? 'selected' : '' ?>>
                    Entradas
                </option>

                <option value="saida" <?= $tipoFiltro === 'saida' ? 'selected' : '' ?>>
                    Despesas
                </option>
            </select>

            <input type="date" name="data_inicial" value="<?= $dataInicial ?>" />
            <input type="date" name="data_final" value="<?= $dataFinal ?>" />
            <button type="submit">Filtrar</button>
        </form>
    </div>

    <a href="formulario.php" class="btn-cadastrar">
        Nova movimentação
    </a>
</div>