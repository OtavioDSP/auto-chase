<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="src/css/index.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuário</title>
</head>
<!-- inicio das anotacoes do que fazer:
 futuramente vamos separar essa index da parte de login pra um botao no HEADER,
 onde vai levar pra uma nova pagina que é somente do login e provavelmente,
 vamos localizar isso no /src/routes, criar um arquivo ''login.php'' e lá vamo deixar essa parte,
 depois vamos separando tudo, tudo em 'rotas' diferentes pra ficar bem organizado e nao bagunçar tudo. -->
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
    <!-- inicio do LOGIN -->
    <form action="src/php/global/global.php" method="post">
        <div class="login-container">
            <h5><img src="src/img/autochase logo 911 branco auto preto chase branco sc.png" alt="logo" class="logo"></h5>
            <h1>Crie sua Conta</h1>

            <div class="form">
                <input type="text" name="usuario_nome" placeholder="Nome de usuário" required>
                <div class="senha-container">
                    <input type="password" id="senha" name="usuario_senha" placeholder="Senha" required>
                    <button type="button" onclick="toggleSenha()">👁</button>
                </div>
                <input type="email" name="usuario_email" placeholder="E-mail" required>
                <input type="text" name="usuario_telefone" placeholder="Telefone" required>
                <input type="text" name="usuario_endereco" placeholder="Endereço" required>
                <br>
                <!-- troquei tbm o P id resultado pra h3 resultado -->
                <h3 id="resultado">Seu número de cadastro:</h3>
                <input type="text" id="documento" oninput="verificarDocumento()" name="doc_cpf_cnpj" placeholder="Digite CPF ou CNPJ" required >
                <!-- vou trocar o nome do value="Enviar" para Criar conta, caso de bug volte pro nome anterior -->
                <input type="submit" placeholder="Criar conta" class="submit" value="Criar conta"  name="criar_conta">
            </div>
            <br><br>
        </div>
    </form>
<!-- fim do LOGIN -->
 <a href="src/routes/anuncio.php">Adicionar Anúncio</a>
    <form action="src/php/global/global.php" method="POST">
        <h1>Cor - Adicionar</h1>
        <input type="text" placeholder="Cor" name="cor_desc" required>
        <button type="submit" name="criar_cor">Adicionar Cor</button>
    </form>

    <hr>

    <hr>

    <form action="src/php/global/global.php" method="POST">
        <h1>Marca - Adicionar</h1>
        <input type="text" placeholder="Marca" name="marca_desc" required>
        <button type="submit" name="criar_marca">Adicionar Marca</button>
        <h1>Modelo - Adicionar</h1>
        <input type="text" placeholder="Modelo" name="modelo_desc" required>
        <input type="number" step="0.01" placeholder="Valor FIPE" name="modelo_valor_fipe" required>
        <button type="submit" name="criar_marca_modelo">Adicionar</button>
    </form>

    <hr>

    <form action="src/php/global/global.php" method="POST">
        <h1>Chassi - Adicionar</h1>
        <input type="text" placeholder="Chassi" name="chassi_desc" required>
        <button type="submit" name="criar_chassi">Adicionar Chassi</button>
    </form>

    <hr>

    <form action="src/php/global/global.php" method="POST">
        <h1>Combustível - Adicionar</h1>
        <input type="text" placeholder="Combustível" name="comb_desc" required>
        <button type="submit" name="criar_combustivel">Adicionar Combustível</button>
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
    include(".\src\php\classes\class-imagem.php");
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
                <th colspan="2">Ações</th> </tr>
        </thead>
        <tbody>
            <?php
            $usu = new Usuario(
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $conexao
            );
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
            $vcl = new Veiculo(
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $conexao
            );
            $veiculosArray = $vcl->listarVeiculo();
            foreach ($veiculosArray as $veiculo): ?>
            <tr>
                <td><?=$veiculo['veiculo_id']?></td>
                <td><?=$veiculo['veiculo_quilometragem']?></td>
                <td><?=$veiculo['modelo_desc']?></td>
                <td><?=$veiculo['veiculo_versao']?></td>
                <td><?=$veiculo['marca_desc']?></td>
                <td><?=$veiculo['chassi_desc']?></td>
                <td><?=$veiculo['cor_desc']?></td>
                <td><?=$veiculo['comb_desc']?></td>
                <td><?=$veiculo['veiculo_ano']?></td>

                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este veículo?');">
                        <input type='hidden' name='veiculo_id' value='<?= $veiculo['veiculo_id'] ?>'>
                        <input type='submit' value='Deletar Veículo' name="deletar_veiculo">
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
                <th colspan="2">Ações</th>
            </tr> </thead>
        <tbody>
            <?php
            $modelo = new Modelo(
                null,
                null,
                null,
                null,
                $conexao
            );
            $modelosArray = $modelo->listarModelo();
            foreach ($modelosArray as $modelo): 
            $valor_formatado = number_format($modelo['modelo_valor_fipe'], 2, ',', '.');?>
            <tr>
                
                <td><?=$modelo['modelo_id']?></td>
                <td><?=$modelo['modelo_desc']?></td>
                <td>R$: <?=$valor_formatado?></td>
                <td><?=$modelo['marca_desc']?></td>
                <td> <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este modelo?');">
                        <input type='hidden' name='modelo_id' value='<?= $modelo['modelo_id'] ?>'>
                        <input type='submit' value='Deletar Modelo' name="deletar_modelo">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?modelo_id=<?=$modelo['modelo_id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody> </table>



    <br><br>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID da marca</th>
                <th>Nome da marca</th>
                <th colspan="2">Ações</th>
            </tr> </thead>
        <tbody>
            <?php
            $marca = new Marca(
                null,
                null,
                $conexao
            );
            $marcaArray = $marca->listarMarca();
            foreach ($marcaArray as $marca): ?>
            <tr>
                <td><?=$marca['marca_id']?></td>
                <td><?=$marca['marca_desc']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este modelo?');">
                        <input type='hidden' name='marca_id' value='<?= $marca['marca_id'] ?>'>
                        <input type='submit' value='Deletar Marca' name="deletar_marca">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?marca_id=<?=$marca['marca_id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody> </table>
    <br>
    <br>
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID da cor</th>
                <th>Nome da cor</th>
                <th colspan="2">Ações</th>
            </tr> </thead>
        <tbody>
            <?php
            $cor = new Cor("","", $conexao);
            $corArray = $cor->listarCor();
            foreach ($corArray as $cor): ?>
            <tr>
                <td><?=$cor['cor_id']?></td>
                <td><?=$cor['cor_desc']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este cor?');">
                        <input type='hidden' name='cor_id' value='<?= $cor['cor_id'] ?>'>
                        <input type='submit' value='Deletar cor' name="deletar_cor">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?cor_id=<?=$cor['cor_id']?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody> </table>

    <br><br>
    
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID da carroceria</th>
                <th>Nome da carroceria</th>
                <th colspan="2">Ações</th>
            </tr> </thead>
        <tbody>
            <?php
            $carroceria = new Chassi(
                null,
                null,
                $conexao
            );
            $carroceriaArray = $carroceria->listarChassi();
            foreach ($carroceriaArray as $chassi): ?>
            <tr>
                <td><?=$chassi['chassi_id']?></td>
                <td><?=$chassi['chassi_desc']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este modelo?');">
                        <input type='hidden' name='chassi_id' value='<?= $chassi['chassi_id'] ?>'>
                        <input type='submit' value='Deletar carroceria' name="deletar_chassi">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?chassi_id=<?=$chassi['chassi_id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody> </table>
    <br><br>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID do combustivel</th>
                <th>Nome do combustivel</th>
                <th colspan="2">Ações</th>
            </tr> </thead>
        <tbody>
            <?php
            $comb = new Combustivel(
                null,
                null,
                $conexao
            );
            $combArray = $comb->listarCombustivel();
            foreach ($combArray as $comb): ?>
            <tr>
                <td><?=$comb['comb_id']?></td>
                <td><?=$comb['comb_desc']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este modelo?');">
                        <input type='hidden' name='comb_id' value='<?= $comb['comb_id'] ?>'>
                        <input type='submit' value='Deletar combustivel' name="deletar_combustivel">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?comb_id=<?=$comb['comb_id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody> </table>

    <br>
    <br>
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID do Anúncio</th>
                <th>Descrição do Anúncio</th>
                <th>Data de Criação</th>
                <th>Valor</th>

                <th>Modelo</th> <th>Versão</th>
                
                <th>Marca</th>
                <th>Chassi</th>
                <th>Combustível</th>

                <th colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Crie uma instância da classe Anuncio e busque os anúncios
            $anuncio = new Anuncio(
                null,
                null,
                null,
                null,
                null,
                $conexao
            );
            $anuncioArray = $anuncio->listarAnuncios();

            // Itera sobre os anúncios e exibe os dados
            foreach ($anuncioArray as $anuncio): ?>
                <tr>
                    <td><?=$anuncio['anuncio_id']?></td>
                    <td><?=$anuncio['anuncio_desc']?></td>
                    <td><?=$anuncio['anuncio_data_de_criacao']?></td>
                    <td><?=number_format($anuncio['anuncio_valor'], 2, ',', '.')?></td> <td><?=$anuncio['modelo_desc']?></td>
                    <td><?=$anuncio['veiculo_versao']?></td>
                    <td><?=$anuncio['marca_desc']?></td>
                    <td><?=$anuncio['chassi_desc']?></td>
                    <td><?=$anuncio['comb_desc']?></td>

                    <td>
                        <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este anúncio?');">
                            <input type='hidden' name='anuncio_id' value='<?= $anuncio['anuncio_id'] ?>'>
                            <input type='submit' value='Deletar Anúncio' name="deletar_anuncio">
                        </form>
                    </td>
                    <td>
                        <a href="src/routes/edits.php?anuncio_id=<?=$anuncio['anuncio_id'] ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php 
    $img = new Foto(
        null,
        null,
        null,
        $conexao

    );
    $imgArray = $img->listarImagem();
        foreach($imgArray as $foto):?>
            
        <img src="<?php $fotos['imagem_url']?>" alt="imagem">

    <?php endforeach;?>
        
    <script src="/src/JS/js-functions.js"></script>
</body>
</html>