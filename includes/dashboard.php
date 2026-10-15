  <div class="controle-financeiro">

            <h1>Controle Financeiro</h1>

            <div class="cards-financeiro">

                <div class="card-financeiro card-entrada">
                    <div class="titulo">
                        ENTRADAS
                    </div>

                    <div class="valor">
                        R$ <?= number_format($totalEntradas, 2, ',', '.') ?>
                    </div>
                </div>

                <div class="card-financeiro card-despesa">
                    <div class="titulo">
                        DESPESAS
                    </div>

                    <div class="valor">
                        R$ <?= number_format($totalDespesas, 2, ',', '.') ?>
                    </div>
                </div>

                <div class="card-financeiro card-saldo">
                    <div class="titulo">
                        SALDO
                    </div>

                    <div class="valor <?= $classeSaldo ?>">
                        R$ <?= number_format($saldo, 2, ',', '.') ?>
                    </div>
                </div>

            </div>

        </div>