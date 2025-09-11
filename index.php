<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuário</title>
    <style>
        #resultado {
            font-weight: bold;
            margin-top: 5px;
        }
        .senha-container {
            position: relative;
            display: inline-block;
        }
        .senha-container button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<form action="src/php/global/global.php" method="post">

    <h2>Operações de usuário</h2>
    <p>criar conta</p>
    <input type="text" name="usuario_nome" placeholder="Nome de usuário" required>

    <div class="senha-container">
        <input type="password" id="senha" name="usuario_senha" placeholder="Senha" required>
        <button type="button" onclick="toggleSenha()">👁</button>
    </div>

    <input type="email" name="usuario_email" placeholder="Email" required>
    <input type="text" name="usuario_telefone" placeholder="Telefone" required>
    <input type="text" name="usuario_endereco" placeholder="Endereço" required>
    
    <input type="text" id="documento" oninput="verificarDocumento()" placeholder="Digite CPF ou CNPJ" required>
    <p id="resultado">Digite um CPF ou CNPJ.</p>

    <br><br>
    <input type="submit" value="Enviar" name="criar_conta">
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
        <td>ID</td>
        <td>NOME</td>
        <td>EMAIL</td>
        <td>DOC</td>                    
    </tr>
<?php
$usu = new Usuario("", "", "", "", "", "", "", $conexao);
$usr = $usu->listarUsuario();         
                          
               
    foreach ($usr as $usuario) {?>
    <tr>
        <td><?=$usuario['usuario_id']?></td>
        <td>DESCONHECIDO</td>
        <td><?=$usuario['usuario_id']?></td>
        <td><?=$usuario['usuario_id']?></td>                    
    </tr>
              
            
    <?php } ?>

</table>

</form>

<script src="./src/JS/js-functions.js"></script>

</body>
</html>
