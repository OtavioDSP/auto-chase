<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuário</title>
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
        <input type="text" id="documento" oninput="verificarDocumento()" name="doc_cpf_cnpj" placeholder="Digite CPF ou CNPJ" required >
        <p id="resultado">Digite um CPF ou CNPJ.</p>
       
        <input type="submit" value="Enviar" name="criar_conta">
         <br><br>
    </form>

<form action="../php/global/global.php" method="POST">
        
        <h1>Cor - Adicionar Cor</h1>
        <input type="text" placeholder="Cor" name="cor_desc">

        <h1>Marca - Adicionar Marca</h1>
        <input type="text" placeholder="Marca" name="marca_desc">
        
        <h1>Modelo - Adicionar Modelo</h1>
        <input type="text" placeholder="Modelo" name="modelo_desc">
        <input type="text" id="modelo_ano" name="modelo_ano" pattern="\d{4}" maxlength="4" required placeholder="Ano">
        <input type="text" placeholder="FIPE" name="modelo_fipe">
        
        <h1>Chassi - Adicionar Chassi</h1>
        <input type="text" placeholder="Chassi" name="chassi_desc">

        <h1>Combustivel - Adicionar Combustivel</h1>
        <input type="text" placeholder="Combustivel" name="comb_desc">
      

        <input type="submit" value="Enviar" name="enviar_informacoes">
        
    </form>

    <br>
    <br>







    <?php
    include('.\src\config\db\connect.php');
    include(".\src\php\classes\class-usuario.php");
    include(".\src\php\classes\class-veiculo.php");
    include(".\src\php\classes\class-modelo.php");
    include(".\src\php\classes\class-marca.php");
    include(".\src\php\classes\class-cor.php");
    include(".\src\php\classes\class-chassi.php");
    include(".\src\php\classes\class-combustivel.php");
    include(".\src\php\classes\class-anuncio.php");
    ?>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>CPF/CNPJ</th>
                <th>Senha (Hash)</th>
                <th>Nível de Acesso</th>
                <th>Ações</th>            
            </tr>
        </thead>
        <tbody>
            <?php
            $usu = new Usuario("", "", "", "", "", "", "", "", $conexao);
            $usr = $usu->listarUsuario();         
            foreach ($usr as $usuario) { ?>
            <tr>
                <td><?=$usuario['usuario_id']?></td>
                <td><?=$usuario['usuario_nome']?></td>
                <td><?=$usuario['usuario_email']?></td>
                <td><?=$usuario['usuario_doc_cpf_cnpj']?></td>
                <td><?=$usuario['usuario_senha']?></td>
                <td><?=$usuario['usuario_nivel_de_acesso']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este usuário?');">
                        <input type='hidden' name='usuario_id' value='<?=$usuario['usuario_id']?>'>
                        <input type='submit' name='deletar_usuario' value='Deletar'>
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?usuario_id=<?=$usuario['usuario_id'] ?>">Editar</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <br><br><br>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID do Veículo</th>
                <th>Quilometragem</th>
                <th>Modelo</th>
                <th>Versão</th>
                <th>Marca</th>
                <th>Carroceria</th>
                <th>Cor</th>
                
                <th>Combustivel</th>
                
                <th>Ano</th>
                <th colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $vcl = new Veiculo("", "", "", $conexao);
            $veiculosArray = $vcl->listarVeiculo(); 
            foreach ($veiculosArray as $veiculo): ?>
            <tr>
                <td><?=$veiculo['veiculo_id']?></td>
                <td><?=$veiculo['veiculo_quilometragem']?></td>
                <td><?=$veiculo['modelo_desc']?></td>
                <td><?=$veiculo['veiculo_versao']?></td>
                <td><?=$veiculo['marca_desc']?></td>
                <td><?=$veiculo['veiculo_versao']?></td>
                <td><?=$veiculo['chassi_desc']?></td>
                <td><?=$veiculo['cor_desc']?></td>
                <td><?=$veiculo['comb_desc']?></td>
                <td><?=$veiculo['modelo_ano']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este veículo?');">
                        <input type='hidden' name='veiculo_id' value='<?= $veiculo['veiculo_id'] ?>'>
                        <input type='submit' value='Deletar Veículo'>
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?veiculo_id=<?=$veiculo['veiculo_id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br><br>
      <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID do modelo</th>
                <th>Nome do modelo</th>
                <th>Modelo Fipe</th>
                <th>Marca do modelo</th>
                <th>Ano do modelo</th>
                <th colspan="2">Ações</th>
            <?php
            $modelo = new Modelo("", "", "","", "", $conexao);
            $modelosArray = $modelo->listarModelo();
            foreach ($modelosArray as $modelo): 
            $valor_formatado = number_format($modelo['modelo_valor_fipe'], 2, ',', '.');?>
            <tr>
                 
                <td><?=$modelo['modelo_id']?></td>
                <td><?=$modelo['modelo_desc']?></td>
                <td>R$: <?=$valor_formatado?></td>
                <td><?=$modelo['marca_desc']?></td>
                <td><?=$modelo['modelo_ano']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este modelo?');">
                        <input type='hidden' name='modelo_id' value='<?= $modelo['modelo_id'] ?>'>
                        <input type='submit' value='Deletar Modelo'>
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?modelo_id=<?=$modelo['modelo_id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>

    </table>



<br><br>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID da marca</th>
                <th>Nome da marca</th>
                <th colspan="2">Ações</th>
            <?php
            $marca = new Marca("","", $conexao);
            $marcaArray = $marca->listarMarcas();
            foreach ($marcaArray as $marca): ?>
            <tr>
                <td><?=$marca['marca_id']?></td>
                <td><?=$marca['marca_desc']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este modelo?');">
                        <input type='hidden' name='marca_id' value='<?= $marca['marca_id'] ?>'>
                        <input type='submit' value='Deletar Marca'>
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?marca_id=<?=$marca['marca_id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>

    </table>
<br>
<br>
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID da cor</th>
                <th>Nome da cor</th>
                <th colspan="2">Ações</th>
            <?php
            $cor = new Cor("","", $conexao);
            $corArray = $cor->listarCores();
            foreach ($corArray as $cor): ?>
            <tr>
                <td><?=$cor['cor_id']?></td>
                <td><?=$cor['cor_desc']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este cor?');">
                        <input type='hidden' name='cor_id' value='<?= $cor['cor'] ?>'>
                        <input type='submit' value='Deletar cor'>
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?cor_id=<?=$cor['cor_id']?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
    </table>

    <br><br>
    
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID da carroceria</th>
                <th>Nome da carroceria</th>
                <th colspan="2">Ações</th>
            <?php
            $carroceria = new Chassi("","", $conexao);
            $carroceriaArray = $carroceria->listarChassis();
            foreach ($carroceriaArray as $chassi): ?>
            <tr>
                <td><?=$chassi['chassi_id']?></td>
                <td><?=$chassi['chassi_desc']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este modelo?');">
                        <input type='hidden' name='chassi_id' value='<?= $chassi['chassi_id'] ?>'>
                        <input type='submit' value='Deletar carroceria'>
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?marca_id=<?=$chassi['chassi_id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>

    </table>
    <br><br>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID do combustivel</th>
                <th>Nome do combustivel</th>
                <th colspan="2">Ações</th>
            <?php
            $comb = new Combustivel("","", $conexao);
            $combArray = $comb->listarCombustivel();
            foreach ($combArray as $comb): ?>
            <tr>
                <td><?=$comb['comb_id']?></td>
                <td><?=$comb['comb_desc']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este modelo?');">
                        <input type='hidden' name='comb_id' value='<?= $comb['comb_id'] ?>'>
                        <input type='submit' value='Deletar combustivel'>
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?comb_id=<?=$comb['comb_id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>

    </table>

    <br>
    <br>
 <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
    <thead>
        <tr>
            <!-- do anuncio -->
            <th>ID do Anúncio</th>
            <th>Descrição do Anúncio</th>
            <th>Data de Criação</th>
            <th>Valor</th>

            <!-- do carro -->
            <th>Nome do Veículo</th>
            <th>Modelo</th>
            <th>Versão</th>
            <th>Ano</th>
            <th>Marca</th>
            <th>Chassi</th>
            <th>Combustível</th>

            <!-- Ações -->
            <th colspan="2">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Crie uma instância da classe Anuncio e busque os anúncios
        $anuncio = new Anuncio("", "", "", "", "", $conexao);
        $anuncioArray = $anuncio->listarAnuncios();

        // Itera sobre os anúncios e exibe os dados
        foreach ($anuncioArray as $anuncio): ?>
            <tr>
                <td><?=$anuncio['anuncio_id']?></td>
                <td><?=$anuncio['anuncio_desc']?></td>
                <td><?=$anuncio['anuncio_data_de_criacao']?></td>
                <td><?=number_format($anuncio['anuncio_valor'], 2, ',', '.')?></td> <!-- Valor formatado -->
                
                <!-- Informações do carro -->
                <td><?=$anuncio['modelo_desc']?></td>
                <td><?=$anuncio['modelo_ano']?></td>
                <td><?=$anuncio['veiculo_versao']?></td>
                <td><?=$anuncio['marca_desc']?></td>
                <td><?=$anuncio['chassi_desc']?></td>
                <td><?=$anuncio['comb_desc']?></td>

                <!-- Ações -->
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este anúncio?');">
                        <input type='hidden' name='anuncio_id' value='<?= $anuncio['anuncio_id'] ?>'>
                        <input type='submit' value='Deletar Anúncio'>
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?anuncio_id=<?=$anuncio['anuncio_id'] ?>">Editar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br><br>


    





    <script src="./src/JS/js-functions.js"></script>
</body>
</html>
