<?php
// Inclui o gerenciador de sessão no início de tudo.
// Isso permite usar as funções de sessão como estaLogado() em toda a página.
require_once 'src/config/env/logout.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="src/css/index.css">
    <link rel="stylesheet" href="src/css/adminpanel.css">
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
            <a href="src/routes/compra.php">Comprar</a>
            <a href="src/routes/anuncio.php">Anunciar</a>
        </nav>
    </div>

    <div class="header-right">
        
        <?php if (estaLogado()): ?>
            
            <a href="chat.php" class="nav-link-icon">
                <i class="fas fa-comment"></i> 
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
        
            <!-- 
                MUDANÇA IMPORTANTE: 
                Corrigido o link para apontar para 'login.php' na raiz.
            -->
            <a href="login.php" class="btn-login">Login</a>

        <?php endif; ?>
        
    </div>
</header>

<!-- 
    O formulário de "Crie sua Conta" foi removido daqui 
    e movido para o novo 'login.php'.
-->

<br><br><br><br>

<!-- (O restante do seu conteúdo da index, como filtros e anúncios, viria aqui) -->

<!-- (O script JS pode ser necessário aqui se você tiver filtros na index) -->
<!-- <script src="src/JS/js-functions.js"></script> -->


    
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
    <div class="admin-panel">
        <div class="admin-card">
            <form action="src/php/global/global.php" method="POST">
                <div class="form-group"><label>Cor</label><input type="text" placeholder="Ex: Preto" name="cor_desc" required></div>
                <button type="submit" name="criar_cor">Adicionar Cor</button>
            </form>
        </div>

        <div class="admin-card">
            <form action="src/php/global/global.php" method="POST">
                <div class="form-group"><label>Marca</label><input type="text" placeholder="Ex: Volkswagen" name="marca_desc" required></div>
                <div class="form-group"><label>Modelo</label><input type="text" placeholder="Ex: Gol" name="modelo_desc" required></div>
                <div class="form-group"><label>Valor FIPE</label><input type="number" step="0.01" placeholder="Ex: 45000.00" name="modelo_valor_fipe" required></div>
                <button type="submit" name="criar_marca_modelo">Adicionar Marca/Modelo</button>
            </form>
        </div>

        <div class="admin-card">
            <form action="src/php/global/global.php" method="POST">
                <div class="form-group"><label>Chassi</label><input type="text" placeholder="Ex: Sedan" name="chassi_desc" required></div>
                <button type="submit" name="criar_chassi">Adicionar Chassi</button>
            </form>
        </div>

        <div class="admin-card">
            <form action="src/php/global/global.php" method="POST">
                <div class="form-group"><label>Combustível</label><input type="text" placeholder="Ex: Flex" name="comb_desc" required></div>
                <button type="submit" name="criar_combustivel">Adicionar Combustível</button>
            </form>
        </div>

    <hr>

    <h2>Gerenciamento de Usuários</h2>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>CPF/CNPJ</th>
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
                <td><?=$usuario['usuario_nivel_de_acesso']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este usuário?');">
                        <input type='hidden' name='usuario_id' value='<?=$usuario['usuario_id']?>'>
                        <input type='submit' name='deletar_usuario' value='Deletar' class="action-delete">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?usuario_id=<?=$usuario['usuario_id'] ?>" class="action-edit">Editar</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2>Gerenciamento de Veículos</h2>
    <table class="admin-table">
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
                        <input type='submit' value='Deletar' name="deletar_veiculo" class="action-delete">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?veiculo_id=<?=$veiculo['veiculo_id'] ?>" class="action-edit">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Gerenciamento de Modelos</h2>
    <table class="admin-table">
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
                        <input type='submit' value='Deletar' name="deletar_modelo" class="action-delete">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?modelo_id=<?=$modelo['modelo_id'] ?>" class="action-edit">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody> 
    </table>

    <h2>Gerenciamento de Marcas</h2>
    <table class="admin-table">
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
                        <input type='submit' value='Deletar' name="deletar_marca" class="action-delete">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?marca_id=<?=$marca['marca_id'] ?>" class="action-edit">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody> 
    </table>

    <h2>Gerenciamento de Cores</h2>
    <table class="admin-table">
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
                        <input type='submit' value='Deletar' name="deletar_cor" class="action-delete">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?cor_id=<?=$cor_item['cor_id']?>" class="action-edit">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody> 
    </table>
    
    <h2>Gerenciamento de Chassis</h2>
    <table class="admin-table">
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
                        <input type='submit' value='Deletar' name="deletar_chassi" class="action-delete">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?chassi_id=<?=$chassi_item['chassi_id'] ?>" class="action-edit">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody> 
    </table>

    <h2>Gerenciamento de Combustíveis</h2>
    <table class="admin-table">
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
                        <input type='submit' value='Deletar' name="deletar_combustivel" class="action-delete">
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?comb_id=<?=$comb_item['comb_id'] ?>" class="action-edit">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody> 
    </table>

    <h2>Gerenciamento de Anúncios</h2>
    <table class="admin-table">
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
                            <input type='submit' value='Deletar' name="deletar_anuncio" class="action-delete">
                        </form>
                    </td>
                    <td>
                        <a href="src/routes/edits.php?anuncio_id=<?=$anuncio['anuncio_id'] ?>" class="action-edit">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php 
    $img = new Foto(null, null, null, $conexao);
    $imgArray = $img->listarImagem();
    ?>
    <h2>Galeria de Imagens</h2>
    <div class="admin-card">
        <div style="display: flex; flex-wrap: wrap; gap: 10px;">
            <?php foreach($imgArray as $foto):?>
                <img src="<?= htmlspecialchars($foto['imagem_url']) ?>" alt="imagem" style="max-width: 150px; height: auto; border-radius: 4px;">
            <?php endforeach;?>
        </div>
    </div>

<?php endif; // Fim do conteúdo de admin ?>


<div class="search-filter-panel">
    <h2>Encontre seu próximo veículo</h2>
    <form action="index.php" method="GET">
        <?php
        // Pega os valores do filtro do URL para manter a seleção
        $filtro_marca = $_GET['fk_marca_id'] ?? null;
        $filtro_modelo = $_GET['fk_modelo_id'] ?? null;
        $filtro_cor = $_GET['fk_cor_id'] ?? null;
        $filtro_chassi = $_GET['fk_chassi_id'] ?? null;
        $filtro_comb = $_GET['fk_comb_id'] ?? null;
        $filtro_ano_min = $_GET['ano_min'] ?? '';
        $filtro_ano_max = $_GET['ano_max'] ?? '';
        $filtro_preco_min = $_GET['preco_min'] ?? '';
        $filtro_preco_max = $_GET['preco_max'] ?? '';
        
        // CORREÇÃO: Define a variável $todosModelos antes de incluir o filtro.
        $todosModelos = $modeloManager->listarModelo();

        // Inclui os selects de Marca/Modelo e define $modelosAgrupados
        include 'src/php/functions/filter-functions.php'; 
        ?>

        <div class="filter-group">
            <label for="corSelect">Cor</label>
            <select name="fk_cor_id" id="corSelect">
                <option value="">Qualquer Cor</option>
                <?php foreach ($cor->listarCor() as $cor_item): ?>
                    <option value="<?= $cor_item['cor_id'] ?>" <?= ($cor_item['cor_id'] == $filtro_cor) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cor_item['cor_desc']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-group filter-group--wide">
            <label>Ano</label>
            <div style="display: flex; gap: 5px;">
                <input type="number" name="ano_min" placeholder="De" value="<?= htmlspecialchars($filtro_ano_min) ?>">
                <input type="number" name="ano_max" placeholder="Até" value="<?= htmlspecialchars($filtro_ano_max) ?>">
            </div>
        </div>

        <div class="filter-group filter-group--wide">
            <label>Preço</label>
            <div style="display: flex; gap: 5px;">
                <input type="number" name="preco_min" placeholder="Mínimo" value="<?= htmlspecialchars($filtro_preco_min) ?>">
                <input type="number" name="preco_max" placeholder="Máximo" value="<?= htmlspecialchars($filtro_preco_max) ?>">
            </div>
        </div>

        <div class="filter-buttons">
            <button type="submit">Buscar</button>
            <a href="index.php">Limpar</a>
        </div>
    </form>
</div>

<div class="ad-grid-container">
    <h2>Anúncios Recentes</h2>
    <div class="ad-grid">
        <?php
        // Monta o array de filtros com base nos parâmetros GET
        $filtros = [
            'marca' => $filtro_marca, 'modelo' => $filtro_modelo, 'cor' => $filtro_cor,
            'chassi' => $filtro_chassi, 'comb' => $filtro_comb, 'ano_min' => $filtro_ano_min,
            'ano_max' => $filtro_ano_max, 'preco_min' => $filtro_preco_min, 'preco_max' => $filtro_preco_max,
        ];

        $anuncioManager = new Anuncio(null, null, null, null, null, null, $conexao);
        $anuncioArray = $anuncioManager->listarAnuncios($filtros);

        // --- Lógica para destacar o anúncio ID 25 ---
        $anuncioDestaque = null;
        $indiceDestaque = -1;
        // Encontra o anúncio 25 e sua posição no array
        foreach ($anuncioArray as $key => $anuncio) {
            if ($anuncio['anuncio_id'] == 25) {
                $anuncioDestaque = $anuncio;
                $indiceDestaque = $key;
                break;
            }
        }
        // Se encontrou, remove da posição original e coloca no início
        if ($anuncioDestaque) {
            array_splice($anuncioArray, $indiceDestaque, 1);
            array_unshift($anuncioArray, $anuncioDestaque);
        }

        foreach ($anuncioArray as $anuncio): ?>
            <a href="src/routes/card.php?anuncio_id=<?= $anuncio['anuncio_id'] ?>" class="ad-card-link">
                <div class="ad-card">
                    <img src="<?= htmlspecialchars($anuncio['imagem_url']) ?>" alt="Foto do veículo" class="ad-image">
                    <div class="ad-content">
                        <h3 class="ad-title"><?= htmlspecialchars($anuncio['marca_desc'] . ' ' . $anuncio['modelo_desc']) ?></h3>
                        <p class="ad-version"><?= htmlspecialchars($anuncio['veiculo_versao']) ?></p>
                        <p class="ad-price">R$ <?= number_format($anuncio['anuncio_valor'], 2, ',', '.') ?></p>
                        <p class="ad-details"><?= htmlspecialchars($anuncio['veiculo_ano']) ?> &bull; <?= htmlspecialchars($anuncio['veiculo_quilometragem']) ?> km</p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

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

<script src="src/JS/js-functions.js"></script>

</body>
</html>