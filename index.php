<?php
// Inclui o gerenciador de sessão no início de tudo.
// Isso permite usar as funções de sessão como estaLogado() em toda a página.
require_once 'src/config/env/logout.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autochase - Seu Marketplace de Veículos</title>
</head>
<body>
    <header>
        <nav>
            <?php if (estaLogado()): ?>
                <p>Olá, <?= htmlspecialchars($_SESSION['user_name']) ?>!</p>
                <form action="src/php/global/global.php" method="post" style="display:inline;">
                    <button type="submit" name="logout_usuario">Sair</button>
                </form>
                <!-- Link para o usuário editar a própria conta -->
                <a href="src/routes/edits.php?usuario_id=<?= htmlspecialchars($_SESSION['user_id']) ?>">Minha Conta</a>
            <?php else: ?>
                <a href="login.php">Acessar sua conta</a>
            <?php endif; ?>
        </nav>
    </header>
    <hr>
    <a href="src/routes/anuncio.php">Adicionar Anúncio</a>

    <?php if (eAdmin()): // Conteúdo exclusivo para administradores ?>
    
    <form action="src/php/global/global.php" method="post" style="background-color: #f0f0f0; padding: 15px; margin-top: 15px;">
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

<!-- FORM COR -->
<form action="src/php/global/global.php" method="POST">
    <h1>Cor - Adicionar</h1>
    <input type="text" placeholder="Cor" name="cor_desc" required>
    <button type="submit" name="criar_cor">Adicionar Cor</button>
</form>

<hr>



<hr>

<!-- FORM MODELO -->
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

<!-- FORM CHASSI -->
<form action="src/php/global/global.php" method="POST">
    <h1>Chassi - Adicionar</h1>
    <input type="text" placeholder="Chassi" name="chassi_desc" required>
    <button type="submit" name="criar_chassi">Adicionar Chassi</button>
</form>

<hr>

<!-- FORM COMBUSTÍVEL -->
<form action="src/php/global/global.php" method="POST">
    <h1>Combustível - Adicionar</h1>
    <input type="text" placeholder="Combustível" name="comb_desc" required>
    <button type="submit" name="criar_combustivel">Adicionar Combustível</button>
</form>


    <br>
    <br>

    <?php endif; // Fim do conteúdo de admin
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
    
    // Apenas administradores podem ver as tabelas de gerenciamento
    if (eAdmin()): ?>

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
                
          <img src="<?= htmlspecialchars($foto['imagem_url']) ?>" alt="imagem" style="max-width: 150px; height: auto; margin: 5px;">


        <?php endforeach;?>
    <?php endif; // Fim do conteúdo de admin
    
    // Instancia os managers uma vez para usar nos filtros e na listagem
    $marcaManager = new Marca(null, null, $conexao);
    $marcas = $marcaManager->listarMarca();

    
    ?>

<?php
    // Prepara o array de modelos para o JavaScript
    $modeloManager = new Modelo(
        null,
        null,
        null,
        null,
        $conexao
    );
    $cor = new Cor(
        "",
        "",
        $conexao
    );
    $chassi = new Chassi(
        "",
        "",
        $conexao
    );
    $comb = new Combustivel(
        "",
        "",
        $conexao
    );
    
    

?>

 <hr style="margin: 40px 0;">
 <h2>Encontre seu próximo veículo</h2>

<form action="index.php" method="GET" style="border: 1px solid #ccc; padding: 20px; margin-bottom: 20px;">
    <?php
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
        <option value="">Qualquer Cor</option> <?php foreach ($corArray as $cor): ?>
            <option value="<?= $cor['cor_id'] ?>" <?= ($cor['cor_id'] == $filtro_cor) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cor['cor_desc']) ?>
            </option>
        <?php endforeach; ?>
        </select>
        <select name="fk_chassi_id">
        <option value="">Qualquer Chassi</option> <?php foreach ($chassiArray as $chassi): ?>
            <option value="<?= $chassi['chassi_id'] ?>" <?= ($chassi['chassi_id'] == $filtro_chassi) ? 'selected' : '' ?>    <?= ($chassi['chassi_id'] == $filtro_chassi) ? 'selected' : '' ?>>
                <?= htmlspecialchars($chassi['chassi_desc']) ?>
            </option>
        <?php endforeach; ?>
        </select>
        <select name="fk_comb_id">
        <option value="">Qualquer Combustivel</option> <?php foreach ($combArray as $comb): ?>
            <option value="<?= $comb['comb_id'] ?>" <?= ($comb['comb_id'] == $filtro_comb) ? 'selected' : '' ?>    <?= ($comb['comb_id'] == $filtro_comb) ? 'selected' : '' ?>>
                <?= htmlspecialchars($comb['comb_desc']) ?>
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
        const modelosPorMarca = <?= json_encode($modelosAgrupados) ?>;
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pega os valores do filtro do PHP
            const marcaFiltrada = <?= json_encode($filtro_marca) ?>;
            const modeloFiltrado = <?= json_encode($filtro_modelo) ?>;

            if (marcaFiltrada) {
                const marcaSelect = document.getElementById('marcaSelect');
                if (marcaSelect) {
                    marcaSelect.value = marcaFiltrada;
                    // Força o 'js-functions.js' a carregar os modelos
                    marcaSelect.dispatchEvent(new Event('change')); 
                }
            }

            // Adiciona um pequeno delay para dar tempo do 'js-functions.js'
            // preencher os modelos ANTES de tentar selecionar um
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

        // Itera sobre os anúncios e exibe os dados
        foreach ($anuncioArray as $anuncio): ?>
            <tr>
                <td>
                    <img src="<?= htmlspecialchars($anuncio['imagem_url']) ?>" alt="Foto do veículo" style="max-width: 100px; max-height: 60px;">
                </td>
                </td>
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
                    // Verifica se o usuário logado é o dono do anúncio ou um admin
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
                <?php else: // Se não tem permissão, exibe colunas vazias para manter o layout ?>
                        <td colspan="2"></td>
                <?php endif; endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<script src="src/JS/js-functions.js"></script>
</body>
</html>