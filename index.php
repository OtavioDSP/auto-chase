<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="src/css/index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuário</title>
</head>
<body>
    <header>
        <div class="header-left">
            <img src="src/img/autochase logo 911 branco auto preto chase branco sc.png" alt="Logo" class="logo">
            
        </div>
        <div class="header-center">
            <nav class="nav-links">
            </nav>
        </div>
        <div class="header-right">
        </div>
    </header>
<form action="src/php/global/global.php" method="post">
<div class="login-container">
    <h5><img src="src/img/autochase logo 911 branco auto preto chase branco sc.png" alt="logo" class="logo"></h5>
    <h1>Criar sua Conta</h1>
    <!-- <p>Criar sua conta</p> -->
    <div class="form">
        <input type="text" name="usuario_nome" placeholder="Nome de usuário" required>

        <div class="senha-container">
            <input type="password" id="senha" name="usuario_senha" placeholder="Senha" required>
            <button type="button" onclick="toggleSenha()">👁</button>
        </div>

        <input type="email" name="usuario_email" placeholder="E-mail" required>
        <input type="text" name="usuario_telefone" placeholder="Telefone" required>
        <input type="text" name="usuario_endereco" placeholder="Endereço" required>
    
        <input type="text" id="documento" oninput="verificarDocumento()" placeholder="Digite CPF ou CNPJ" required>
        <p id="resultado">Digite um CPF ou CNPJ.</p>
    </div>
    <br><br>
    <input type="submit" value="Enviar" name="criar_conta">
</div>
</form>



</form> 

<form action="src/php/global/global.php" method="post"> 
    
<?php
echo __FILE__;
include('.\src\config\db\connect.php');
include(".\src\php\classes\class-usuario.php");
?>
<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>CPF/CNPJ</th>
        <th>Senha (Hash)</th>
        <th>Nível de Acesso</th>
        <th colspan="2">Ações</th>            
    </tr>
<?php
$usu = new Usuario("", "", "", "", "", "", "", "",$conexao);

$usr = $usu->listarUsuario();         
                          
               
    foreach ($usr as $usuario) {?>
    <form action="src/php/global/global.php" method="post">
       
       <tr>
            <td><?=$usuario['usuario_id']?></td>
            <td><?=$usuario['usuario_nome']?></td>
            <td><?=$usuario['usuario_email']?></td>
            <td><?=$usuario['usuario_doc_cpf_cnpj']?></td>
            <td><?=$usuario['usuario_senha']?></td>
            <td><?=$usuario['usuario_nivel_de_acesso']?></td>
            <td>
                <form method="post" action="caminho_para_deletar.php" onsubmit="return confirm('Tem certeza que deseja deletar este usuário?');">
                    <input type='hidden' name='usuario_id' value='<?= $usuario['usuario_id']?>'>
                    <input type='submit' name='deletar_usuario' value='Deletar'>
                </form>
            </td>
            <td>
                <a href="src/routes/edits.php?usuario_id=<?= $usuario['usuario_id'] ?>">Editar</a>
            </td>
        </tr>
    </form>
    


    <?php } ?>

    

</table>

</form>

<script src="./src/JS/js-functions.js"></script>

</body>
</html>
