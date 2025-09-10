<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>
<body>

<form action="src/php/global/global.php" method="post">

    <h2>Operações de usuário</h2>
    <p>criar conta</p>
    <input type="text" name="usuario_nome" placeholder="Nome de usuário">

    <div style="position:relative; display:inline-block;">
        <input type="password" id="senha" name="usuario_senha" style="padding-right:30px;" placeholder="Senha">
        <button type="button" onclick="toggleSenha()" 
                style="position:absolute; right:5px; top:50%; transform:translateY(-50%); border:none; background:none; cursor:pointer;">👁</button>
    </div>
    <input type="text" name="usuario_email" placeholder="Nome de usuário">
    <input type="text" name="usuario_telefone" placeholder="telefone">
    <input type="text" name="usuario_endereco" placeholder="endereço">
    <input type="text" name="doc_cpf_cnpj" placeholder="documento">
    <br><br>
    <input type="submit" value="Enviar" name="criar_conta">





    
</form>
<form action="src/php/global/global.php" method="post">

    <input type="text" name="modelo_desc">

    <input type="submit" value="Enviar modelo" name="criar_modelo">




</form>

<script src="/src/JS/js-functions.js"></script>
</body>
</html>
