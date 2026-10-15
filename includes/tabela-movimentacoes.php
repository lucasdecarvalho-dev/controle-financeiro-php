<div class="tabela-container">
<table>

<thead>

    <tr>
        <th>ID</th>
        <th>Descrição</th>
        <th style="text-align: right;">Valor</th>
        <th>Tipo</th>
        <th>Categoria</th>
        <th>Data</th>
        <th class="coluna-acoes">Ações</th>
    </tr>

</thead>

<tbody>
    <?php if (empty($dados)): ?>

        <tr>
            <td colspan="7">
                Nenhuma movimentação encontrada.
            </td>
        </tr>

    <?php else: ?>

        <?php foreach ($dados as $linha): ?>

        <tr>

            <td>
                <?= htmlspecialchars($linha['id']) ?>
            </td>

            <td>
                <?= htmlspecialchars($linha['descricao']) ?>
            </td>

            <td class="valor">
                R$ <?= number_format($linha['valor'], 2, ',', '.') ?>
            </td>

            <td>

                <?php if ($linha['tipo'] === 'entrada'): ?>

                    <span class="entrada">
                        Entrada
                    </span>

                <?php else: ?>

                    <span class="saida">
                        Despesa
                    </span>

                <?php endif; ?>

            </td>

            <td>
                <?php
                $categoria = $linha['categoria_nome'] ?? 'Categoria não encontrada';
                echo htmlspecialchars($categoria);
                ?>

            </td>

            <td>
                <?= date('d/m/Y', strtotime($linha['data'])) ?>
            </td>

            <td>
                <div class="acoes">
                    <a href="editar.php?id=<?= $linha['id'] ?>" class="btn-editar">
                        Editar
                    </a>

                    <a href="excluir.php?id=<?= $linha['id'] ?>"
                    class="btn-excluir"
                    onclick="return confirm('Tem certeza que deseja excluir esta movimentação?');">
                        Excluir
                    </a>
                </div>
            </td>
            </tr>

    <?php endforeach; ?>

    <?php endif; ?>

</tbody>

</table>

</div>