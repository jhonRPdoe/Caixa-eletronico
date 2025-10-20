<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/menu.css">
    <title>Caixa Eletrônico - Menu</title>
</head>
<body>
    <div class="menu-container">
        <h2><?php echo "$sNomeUsuario"; ?>, Bem-vindo ao Caixa Eletrônico</h2>
        <h2>Seu saldo é de:</h2>
        <h2>R$ <?php echo "$iSaldoConta"; ?></h2>

        <?php if (isset($sMensagem)) echo "<p class='mensagem-sucesso'>$sMensagem</p>"; ?>
        <?php if (isset($sErro)) echo "<p class='mensagem-erro'>$sErro</p>"; ?>

        <div class="botoes-menu">
            <form action="?acao=saque" method="POST">
                <button type="submit">Sacar</button>
            </form>

            <form action="?acao=deposito" method="POST">
                <button type="submit">Depositar</button>
            </form>
        </div>

        <form action="?acao=logout" method="POST">
            <button type="submit" class="botao-logout">Sair</button>
        </form>
    </div>
</body>
</html>