<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/saque.css">
    <title>Caixa Eletrônico - Sacar</title>
</head>
<body>
    <div class="deposito-container">
        <h2>Sacar</h2>

        <?php if (isset($sErro)) echo "<p style='color:red;'>$sErro</p>"; ?>
        <?php if (isset($sMensagem)) echo "<p style='color:green;'>$sMensagem</p>"; ?>

        <form action="?acao=sacar" method="POST">
            <div class="valor-total">
                <label for="valorTotal">Valor do saque:</label>
                <input type="text" name="valorTotal" placeholder="R$" class="campo" onkeyup="onKeyUpValorTotal()" required>
            </div>
            <div class="notas-container">
                <div class="notas-grupo">
                    <div class="nota 1" onClick="onClickNota(1)">
                        <span>R$ 1,00</span>
                        <input type="text" name="quantidade-nota1" class="campo quantidade-nota" readonly>
                    </div>
                    <div class="nota 2" onClick="onClickNota(2)" >
                        <span>R$ 2,00</span>
                        <input type="text" name="quantidade-nota2" class="campo quantidade-nota" readonly>
                    </div>
                    <div class="nota 5" onClick="onClickNota(5)" >
                        <span>R$ 5,00</span>
                        <input type="text" name="quantidade-nota5" class="campo quantidade-nota" readonly>
                    </div>
                    <div class="nota 10" onClick="onClickNota(10)" >
                        <span>R$ 10,00</span>
                        <input type="text" name="quantidade-nota10" class="campo quantidade-nota" readonly>
                    </div>
                </div>
                <div class="notas-grupo">
                    <div class="nota 20" onClick="onClickNota(20)">
                        <span>R$ 20,00</span>
                        <input type="text" name="quantidade-nota20" class="campo quantidade-nota" readonly>
                    </div>
                    <div class="nota 50" onClick="onClickNota(50)">
                        <span>R$ 50,00</span>
                        <input type="text" name="quantidade-nota50" class="campo quantidade-nota" readonly>
                    </div>
                    <div class="nota 100" onClick="onClickNota(100)">
                        <span>R$ 100,00</span>
                        <input type="text" name="quantidade-nota100" class="campo quantidade-nota" readonly>
                    </div>
                    <div class="nota 200" onClick="onClickNota(200)">
                        <span>R$ 200,00</span>
                        <input type="text" name="quantidade-nota200" class="campo quantidade-nota" readonly>
                    </div>
                </div>
            </div>
            <div class="botoes-container">
                <button type="submit" class="botoes">Sacar</button>
                <button type="button" class="botao-limpar" onClick="limpaCampos()">Limpar</button>
            </div>
        </form>
        <form action="?acao=menu" method="POST">
                <button type="submit">Voltar</button>
        </form>
    </div>

    <script src="../public/js/saque.js"></script>
</body>
</html>