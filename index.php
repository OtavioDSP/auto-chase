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
    
    <input type="text" id="documento" oninput="verificarDocumento()" name="doc_cpf_cnpj" placeholder="Digite CPF ou CNPJ" required>
    <p id="resultado">Digite um CPF ou CNPJ.</p>

    <br><br>
    <input type="submit" value="Enviar" name="criar_conta">
</form>






    
<?php

include('.\src\config\db\connect.php');
include(".\src\php\classes\class-usuario.php");
include(".\src\php\classes\class-veiculo.php");
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
    
       
    <tr>
        <td><?=$usuario['usuario_id']?></td>
        <td><?=$usuario['usuario_nome']?></td>
        <td><?=$usuario['usuario_email']?></td>
        <td><?=$usuario['usuario_doc_cpf_cnpj']?></td>
        <td><?=$usuario['usuario_senha']?></td>
        <td><?=$usuario['usuario_nivel_de_acesso']?></td>
        <td>
            <form method="post" action="./src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este usuário?');">
                <input type='hidden' name='usuario_id' value='<?=$usuario['usuario_id']?>'>
                <input type='submit' name='deletar_usuario' value='Deletar'>
            </form></td>
        <td>
        <a href="src/routes/edits.php?usuario_id=<?=$usuario['usuario_id'] ?>">Editar</a>
        </td>

    </tr>
    
    </table>


    <?php } ?>
    <br>
    <br>
    <br>
    <table>
    <tr>
        <th>ID do veiculo</th>
        <th>Descrição do veiculo</th>
        <th>Quilometragem</th>
        <th>Carroceria</th>
        <th>cor</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th colspan="2">Ações</th>            
    </tr>
    <?php
    
    $vcl = new Veiculo("", "", "", $conexao);

    $veiculosArray = $vcl->listarVeiculo(); 
    print_r ($veiculosArray[1]);
    foreach ($veiculosArray as $veiculo): 
    ?>
    





    <tr>
        <td><?=$veiculo['veiculo_id']?></td>
        <td><?=$veiculo['veiculo_desc']?></td>
        <td><?=$veiculo['veiculo_quilometragem']?></td>
        <td><?=$veiculo['chassi_desc']?></td>
        <td><?=$veiculo['cor_desc']?></td>
        <td><?=$veiculo['marca_desc']?></td>
        <td><?=$veiculo['comb_desc']?></td>
        <td><?=$veiculo['modelo_desc']?></td>
        
        
        <td>
            <form method="post" action="./src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este veículo?');">
                <input type='hidden' name='veiculo_id' value='<?= $veiculo['veiculo_id'] ?>'>
                <input type='submit' value='Deletar_veiculo'>
            </form>
        </td>

        <td>
            <a href="src/routes/edits.php?veiculo_id=<?=$veiculo['veiculo_id'] ?>">Editar</a>
        </td>
    </tr>
<?php endforeach;?>

    
    </table>
    
   
    

    





<script src="./src/JS/js-functions.js"></script>

</body>
</html>




            