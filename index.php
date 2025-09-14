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
<a href="src/routes/anuncio.php">Adicionar Anúncio</a>
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
