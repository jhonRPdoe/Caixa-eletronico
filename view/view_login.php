<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/login.css">
    <title>Caixa Eletrônico - Login</title>
</head>
<body>
    <div class="login-container">
        <h2>Caixa Eletrônico</h2>

        <?php if (isset($sErro)) echo "<p style='color:red;'>$sErro</p>"; ?>
        <?php if (isset($sMensagem)) echo "<p style='color:green;'>$sMensagem</p>"; ?>

        <form action="?acao=logar" method="POST">
            <label>CPF:</label>
            <input type="text" name="cpf" required><br>
            <label>Senha:</label>
            <input type="password" name="senha" required><br>
            <button type="submit">Entrar</button>
        </form>

        <h3>Ou cadastre-se</h3>
        <form action="?acao=cadastrar" method="POST">
            <label>Nome:</label>
            <input type="text" name="nome" required><br>
            <label>CPF:</label>
            <input type="text" name="cpf" required><br>
            <label>Senha:</label>
            <input type="password" name="senha" required><br>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>