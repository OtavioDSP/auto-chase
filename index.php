<?php
// Inclui o gerenciador de sessão no início de tudo.
// Isso permite usar as funções de sessão como estaLogado() em toda a página.
require_once 'src/config/env/logout.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="src/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" type="image/png" href="src/img/ac icon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autochase | Compre e venda veículos novos e usados com segurança</title>
</head>
<body>
<header>
    <div class="header-left">
        <a href="index.php">
            <img src="src/img/ac wb 911 white sc.png" alt="Logo" class="logo">
        </a>
    </div>
    <div class="header-center">
        <nav class="nav-links">
            <a href="comprar.php">Comprar</a>
            <a href="src/routes/anuncio.php">Anunciar</a>
        </nav>
    </div>

    <div class="header-right">
        
        <?php if (estaLogado()): ?>
            
            <a href="salvos.php" class="nav-link-icon">
                <i class="fas fa-bookmark"></i> 
                <span>Salvos</span>
            </a>

            <a href="src/routes/edits.php?usuario_id=<?= htmlspecialchars($_SESSION['user_id']) ?>" class="nav-link-icon">
                Minha Conta
            </a>
            
            <form action="src/php/global/global.php" method="post" style="display:inline; margin:0;">
                <button type="submit" name="logout_usuario" class="btn-login" style="border:none;">
                    Sair
                </button>
            </form>

        <?php else: ?>
        
            <a href="src/routes/login.php" class="btn-login">Login</a>

        <?php endif; ?>
        
    </div>
</header>

    <form action="src/php/global/global.php" method="post">
        <div class="login-container">
            <h5><img src="src/img/ac 911 white sc.png" alt="logo" class="logo"></h5>
            <h1>Crie sua Conta</h1>

            <div class="form">
                <input type="text" name="usuario_nome" placeholder="Nome de usuário" required>
                <div class="senha-container">
                    <input type="password" id="senha" name="usuario_senha" placeholder="Senha" required>
                    <button type="button" onclick="toggleSenha()">👁</button>
                </div>
                <input type="email" name="usuario_email" placeholder="E-mail" required>
                <input type="text" name="usuario_telefone" placeholder="Telefone (xx) Xxxxx-xxxx" required oninput="maskTelefone(this)" maxlength="15" inputmode="numeric">
                <input type="text" name="usuario_endereco" placeholder="Endereço" required>
                <br>
                <h3 id="resultado">Seu número de cadastro:</h3>
                <input type="text" id="documento" oninput="maskAndVerifyDocumento(this)" name="doc_cpf_cnpj" placeholder="Digite CPF ou CNPJ" required maxlength="18" inputmode="numeric">
                <input type="submit" placeholder="Criar conta" class="submit" value="Criar conta"  name="criar_conta">
            </div>
            <br><br>
        </div>
    </form>
<br><br><br><br>

    <hr>
    
    <?php
    // Includes das classes movidos para cima,
    // para que eAdmin() e os filtros públicos funcionem.
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
    
    // Instancia os managers para os filtros PÚBLICOS
    $marcaManager = new Marca(null, null, $conexao);
    $marcas = $marcaManager->listarMarca();
    $modeloManager = new Modelo(null, null, null, null, $conexao);
    $cor = new Cor("", "", $conexao);
    $chassi = new Chassi("", "", $conexao);
    $comb = new Combustivel("", "", $conexao);
    ?>

    <?php if (eAdmin()): // Conteúdo exclusivo para administradores (lógica do DEVELOP) ?>
    
    <form action="src/php/global/global.php" method="POST">
        <h1>Cor - Adicionar</h1>
        <input type="text" placeholder="Cor" name="cor_desc" required>
        <button type="submit" name="criar_cor">Adicionar Cor</button>
    </form>
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
    <br><br>

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
            $usu = new Usuario(null, null, null, null, null, null, null, null, $conexao);
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
            $vcl = new Veiculo(null, null, null, null, null, null, null, null, $conexao);
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
            </tr> 
        </thead>
        <tbody>
            <?php
            // $modeloManager já foi instanciado lá em cima
            $modelosArray = $modeloManager->listarModelo();
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
        </tbody> 
    </table>
    <br><br>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID da marca</th>
                <th>Nome da marca</th>
                <th colspan="2">Ações</th>
            </tr> 
        </thead>
        <tbody>
            <?php
            // $marcaManager já foi instanciado
            $marcaArray = $marcaManager->listarMarca();
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
        </tbody> 
    </table>
    <br><br>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID da cor</th>
                <th>Nome da cor</th>
                <th colspan="2">Ações</th>
            </tr> 
        </thead>
        <tbody>
            <?php
            // $cor já foi instanciado
            $corArray = $cor->listarCor();
            foreach ($corArray as $cor_item): ?>
            <tr>
                <td><?=$cor_item['cor_id']?></td>
                <td><?=$cor_item['cor_desc']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este cor?');">
                        <input type='hidden' name='cor_id' value='<?= $cor_item['cor_id'] ?>'>
                        <input type='submit' value='Deletar cor' name="deletar_cor">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?cor_id=<?=$cor_item['cor_id']?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody> 
    </table>
    <br><br>
    
    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID da carroceria</th>
                <th>Nome da carroceria</th>
                <th colspan="2">Ações</th>
            </tr> 
        </thead>
        <tbody>
            <?php
            // $chassi já foi instanciado
            $carroceriaArray = $chassi->listarChassi();
            foreach ($carroceriaArray as $chassi_item): ?>
            <tr>
                <td><?=$chassi_item['chassi_id']?></td>
                <td><?=$chassi_item['chassi_desc']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este modelo?');">
                        <input type='hidden' name='chassi_id' value='<?= $chassi_item['chassi_id'] ?>'>
                        <input type='submit' value='Deletar carroceria' name="deletar_chassi">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?chassi_id=<?=$chassi_item['chassi_id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody> 
    </table>
    <br><br>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID do combustivel</th>
                <th>Nome do combustivel</th>
                <th colspan="2">Ações</th>
            </tr> 
        </thead>
        <tbody>
            <?php
            // $comb já foi instanciado
            $combArray = $comb->listarCombustivel();
            foreach ($combArray as $comb_item): ?>
            <tr>
                <td><?=$comb_item['comb_id']?></td>
                <td><?=$comb_item['comb_desc']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este modelo?');">
                        <input type='hidden' name='comb_id' value='<?= $comb_item['comb_id'] ?>'>
                        <input type='submit' value='Deletar combustivel' name="deletar_combustivel">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?comb_id=<?=$comb_item['comb_id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody> 
    </table>
    <br><br>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID do Anúncio</th>
                <th>Descrição</th>
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
            $anuncioManagerAdmin = new Anuncio(null, null, null, null, null, null, $conexao);
            $anuncioArrayAdmin = $anuncioManagerAdmin->listarAnuncios(); // Lista TODOS para o admin

            foreach ($anuncioArrayAdmin as $anuncio): ?>
                <tr>
                    <td><?=$anuncio['anuncio_id']?></td>
                    <td><?=$anuncio['anuncio_desc']?></td>
                    <td><?=$anuncio['anuncio_data_de_criacao']?></td>
                    <td><?=number_format($anuncio['anuncio_valor'], 2, ',', '.')?></td>
                    <td><?=$anuncio['modelo_desc']?></td>
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
    <br><br>

    <?php 
    $img = new Foto(null, null, null, $conexao);
    $imgArray = $img->listarImagem();
        foreach($imgArray as $foto):?>
            
        <img src="<?= htmlspecialchars($foto['imagem_url']) ?>" alt="imagem" style="max-width: 150px; height: auto; margin: 5px;">

    <?php endforeach;?>

<?php endif; // Fim do conteúdo de admin ?>


    <hr style="margin: 40px 0;">
    <h2>Encontre seu próximo veículo</h2>

<form action="index.php" method="GET" style="border: 1px solid #ccc; padding: 20px; margin-bottom: 20px;">
    <?php
    // $todosModelos, $corArray, $chassiArray, $combArray já foram definidos
    $todosModelos = $modeloManager->listarModelo();
    $corArray = $cor->listarCor();
    $chassiArray = $chassi->listarChassi();
    $combArray = $comb->listarCombustivel();
    
    // 1. Isto imprime os selects de Marca/Modelo E define a variável PHP $modelosAgrupados
    include 'src/php/functions/filter-functions.php'; 

    // 2. Pega os valores do filtro do URL
    $filtro_marca = $_GET['fk_marca_id'] ?? null;
    $filtro_modelo = $_GET['fk_modelo_id'] ?? null;
    $filtro_cor = $_GET['fk_cor_id'] ?? null;
    $filtro_chassi = $_GET['fk_chassi_id'] ?? null;
    $filtro_comb = $_GET['fk_comb_id'] ?? null;
    $filtro_ano_min = $_GET['ano_min'] ?? '';
    $filtro_ano_max = $_GET['ano_max'] ?? '';
    $filtro_preco_min = $_GET['preco_min'] ?? '';
    $filtro_preco_max = $_GET['preco_max'] ?? '';
    ?>
    
        <select name="fk_cor_id">
        <option value="">Qualquer Cor</option> <?php foreach ($corArray as $cor_item): ?>
            <option value="<?= $cor_item['cor_id'] ?>" <?= ($cor_item['cor_id'] == $filtro_cor) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cor_item['cor_desc']) ?>
            </option>
        <?php endforeach; ?>
        </select>
        <select name="fk_chassi_id">
        <option value="">Qualquer Chassi</option> <?php foreach ($chassiArray as $chassi_item): ?>
            <option value="<?= $chassi_item['chassi_id'] ?>" <?= ($chassi_item['chassi_id'] == $filtro_chassi) ? 'selected' : '' ?>>
                <?= htmlspecialchars($chassi_item['chassi_desc']) ?>
            </option>
        <?php endforeach; ?>
        </select>
        <select name="fk_comb_id">
        <option value="">Qualquer Combustivel</option> <?php foreach ($combArray as $comb_item): ?>
            <option value="<?= $comb_item['comb_id'] ?>" <?= ($comb_item['comb_id'] == $filtro_comb) ? 'selected' : '' ?>>
                <?= htmlspecialchars($comb_item['comb_desc']) ?>
            </option>
        <?php endforeach; ?>
        </select>
        <div style="flex: 1;">
        <label>Ano:</label>
        <div style="display: flex; gap: 5px;">
            <input type="number" name="ano_min" placeholder="De" min="1900" max="<?= date('Y') + 1 ?>" value="<?= htmlspecialchars($filtro_ano_min) ?>" style="width: 100%;">
            <input type="number" name="ano_max" placeholder="Até" min="1900" max="<?= date('Y') + 1 ?>" value="<?= htmlspecialchars($filtro_ano_max) ?>" style="width: 100%;">
        </div>
    </div>
         
        <div style="flex: 1;">
        <label>Preço:</label>
        <div style="display: flex; gap: 5px;">
            <input type="number" name="preco_min" placeholder="Mínimo" step="1000" value="<?= htmlspecialchars($filtro_preco_min) ?>" style="width: 100%;">
            <input type="number" name="preco_max" placeholder="Máximo" step="1000" value="<?= htmlspecialchars($filtro_preco_max) ?>" style="width: 100%;">
        </div>
    </div>

    <button type="submit" style="margin-top: 15px;">Buscar</button>
    <a href="index.php" style="margin-left: 10px;">Limpar Filtros</a>


    <script>
        // Define a variável JS para o filtro dinâmico
        const modelosPorMarca = <?= json_encode($modelosAgrupados) ?>;
    </script>

    <script>
        // Lógica para manter os filtros selecionados após o submit
        document.addEventListener('DOMContentLoaded', function() {
            const marcaFiltrada = <?= json_encode($filtro_marca) ?>;
            const modeloFiltrado = <?= json_encode($filtro_modelo) ?>;

            if (marcaFiltrada) {
                const marcaSelect = document.getElementById('marcaSelect');
                if (marcaSelect) {
                    marcaSelect.value = marcaFiltrada;
                    marcaSelect.dispatchEvent(new Event('change')); 
                }
            }

            setTimeout(function() {
                if (modeloFiltrado) {
                    const modeloSelect = document.getElementById('modeloSelect');
                    if (modeloSelect) {
                        modeloSelect.value = modeloFiltrado;
                    }
                }
            }, 150); 
        });
    </script>
</form>


    <hr style="margin: 40px 0;">
    <h2>Anúncios Recentes</h2>

 <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
    <thead>
        <tr>
            <th>Foto</th>
            <th>Anúncio</th>
            <th>Valor</th>
            <th>Proprietário</th>
            <th>Cor</th>
            <th>Chassi</th>
            <th>Marca</th>
            <th>Quilometragem</th>
            <th>Ano</th>
            <th>Combustível</th>
            <?php if(estaLogado()): ?>
                <th colspan="2">Ações</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php
        // Monta o array de filtros com base nos parâmetros GET
        $filtros = [
            'marca' => $filtro_marca,
            'modelo' => $filtro_modelo,
            'cor' => $filtro_cor,
            'chassi' => $filtro_chassi,
            'comb' => $filtro_comb,
            'ano_min' => $filtro_ano_min,
            'ano_max' => $filtro_ano_max,
            'preco_min' => $filtro_preco_min,
            'preco_max' => $filtro_preco_max,
        ];

        $anuncioManager = new Anuncio(null, null, null, null, null, null, $conexao);
        $anuncioArray = $anuncioManager->listarAnuncios($filtros);

        foreach ($anuncioArray as $anuncio): ?>
            <tr>
                <td>
                    <img src="<?= htmlspecialchars($anuncio['imagem_url']) ?>" alt="Foto do veículo" style="max-width: 100px; max-height: 60px;">
                </td>
                <td> 
                    <b><?= htmlspecialchars($anuncio['marca_desc'] . ' ' . $anuncio['modelo_desc']) ?></b><br>
                    <small><?= htmlspecialchars($anuncio['veiculo_versao']) ?></small>
                </td>
                <td>R$ <?=number_format($anuncio['anuncio_valor'], 2, ',', '.')?></td>
                <td><?=htmlspecialchars($anuncio['usuario_nome'])?></td>
                <td><?=htmlspecialchars($anuncio['cor_desc'])?></td>
                <td><?=htmlspecialchars($anuncio['chassi_desc'])?></td>
                <td><?=htmlspecialchars($anuncio['marca_desc'])?></td>
                <td><?=htmlspecialchars($anuncio['veiculo_quilometragem'])?></td>
                <td><?=htmlspecialchars($anuncio['veiculo_ano'])?></td>
                <td><?=htmlspecialchars($anuncio['comb_desc'])?></td>

                <?php
                // Ações só aparecem para usuários logados
                if (estaLogado()):
                    $id_usuario_logado = getUsuarioIdLogado();
                    if (eAdmin() || $id_usuario_logado == $anuncio['fk_usuario_id']):
                ?>
                        <td>
                            <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este anúncio?');">
                                <input type='hidden' name='anuncio_id' value='<?= $anuncio['anuncio_id'] ?>'>
                                <input type='submit' value='Deletar' name="deletar_anuncio">
                            </form>
                        </td>
                        <td>
                            <a href="src/routes/edits.php?anuncio_id=<?=$anuncio['anuncio_id'] ?>">Editar</a>
                        </td>
                <?php else: // Se não tem permissão, exibe colunas vazias ?>
                        <td colspan="2"></td>
                <?php endif; endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script src="src/JS/js-functions.js"></script>
</body>
</html>