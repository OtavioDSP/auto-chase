<?php
// Includes de conexão e de todas as classes
require_once '../config/env/logout.php';
include_once '../config/db/connect.php';
include_once '../php/classes/class-usuario.php';
include_once '../php/classes/class-veiculo.php';
include_once '../php/classes/class-modelo.php';
include_once '../php/classes/class-marca.php';
include_once '../php/classes/class-cor.php';
include_once '../php/classes/class-chassi.php';
include_once '../php/classes/class-combustivel.php';
include_once '../php/classes/class-anuncio.php';
include_once '../php/classes/class-imagem.php';

// Instancia os managers para os filtros
$marcaManager = new Marca(null, null, $conexao);
$marcas = $marcaManager->listarMarca();
$modeloManager = new Modelo(null, null, null, null, $conexao);
$todosModelos = $modeloManager->listarModelo();
$cor = new Cor("", "", $conexao);
$chassi = new Chassi("", "", $conexao);
$comb = new Combustivel("", "", $conexao);

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
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar Veículos - Autochase</title>
    <link rel="stylesheet" href="../css/index.css"> <!-- Estilo base e do header -->
    <link rel="stylesheet" href="../css/compra.css"> <!-- Estilo da página -->
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" type="image/png" href="../img/ac icon.png">
</head>
<body>

<header>
    <div class="header-left">
        <a href="../../index.php">
            <img src="../img/ac wb 911 white sc.png" alt="Logo" class="logo">
        </a>
    </div>
    <div class="header-center">
        <nav class="nav-links">
            <a href="compra.php">Comprar</a>
            <a href="anuncio.php">Anunciar</a>
        </nav>
    </div>
    <div class="header-right">
        <?php if (estaLogado()): ?>
            <a href="meus-anuncios.php" class="nav-link-icon">Meus Anúncios</a>
            <a href="edits.php?usuario_id=<?= htmlspecialchars($_SESSION['user_id']) ?>" class="nav-link-icon">Minha Conta</a>
            <form action="../php/global/global.php" method="post" style="display:inline; margin:0;">
                <button type="submit" name="logout_usuario" class="btn-login" style="border:none;">Sair</button>
            </form>
        <?php else: ?>
            <a href="../../login.php" class="btn-login">Login</a>
        <?php endif; ?>
    </div>
</header>

<div class="comprar-page-container">
    <!-- Barra Lateral de Filtros -->
    <aside class="filters-sidebar">
        <h3>Filtros</h3>
        <form action="compra.php" method="GET">
            <?php include '../php/functions/filter-functions.php'; ?>

            <div class="filter-group">
                <label for="corSelect">Cor</label>
                <div class="custom-select-wrapper">
                    <select name="fk_cor_id" id="corSelect">
                        <option value="">Qualquer Cor</option>
                        <?php foreach ($cor->listarCor() as $cor_item): ?>
                            <option value="<?= $cor_item['cor_id'] ?>" <?= ($cor_item['cor_id'] == $filtro_cor) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cor_item['cor_desc']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="filter-group filter-group-range">
                <label>Ano</label>
                <div class="dual-input">
                    <input type="number" name="ano_min" placeholder="De" value="<?= htmlspecialchars($filtro_ano_min) ?>">
                    <input type="number" name="ano_max" placeholder="Até" value="<?= htmlspecialchars($filtro_ano_max) ?>">
                </div>
            </div>

            <div class="filter-group filter-group-range">
                <label>Preço</label>
                <div class="dual-input">
                    <input type="number" name="preco_min" placeholder="Mínimo" value="<?= htmlspecialchars($filtro_preco_min) ?>">
                    <input type="number" name="preco_max" placeholder="Máximo" value="<?= htmlspecialchars($filtro_preco_max) ?>">
                </div>
            </div>

            <div class="filter-buttons">
                <button type="submit">Filtrar</button>
                <a href="compra.php">Limpar</a>
            </div>
        </form>
    </aside>

    <!-- Área Principal com os Anúncios -->
    <main class="results-grid">
        <div class="ad-grid">
            <?php
            // Monta o array de filtros com base nos parâmetros GET
            $filtros = [
                'marca' => $filtro_marca, 'modelo' => $filtro_modelo, 'cor' => $filtro_cor,
                'chassi' => $filtro_chassi, 'comb' => $filtro_comb, 'ano_min' => $filtro_ano_min,
                'ano_max' => $filtro_ano_max, 'preco_min' => $filtro_preco_min, 'preco_max' => $filtro_preco_max, 
                'status' => 'ativo'
            ];

            $anuncioManager = new Anuncio(null, null, null, null, null, null, $conexao);
            $anuncioArray = $anuncioManager->listarAnuncios($filtros);

            if (empty($anuncioArray)) {
                echo "<p>Nenhum anúncio encontrado com os filtros selecionados.</p>";
            } else {
                foreach ($anuncioArray as $anuncio): ?>
                    <a href="card.php?anuncio_id=<?= $anuncio['anuncio_id'] ?>" class="ad-card-link">
                        <div class="ad-card">
                            <img src="../<?= htmlspecialchars(ltrim($anuncio['imagem_url'], 'src/')) ?>" alt="Foto do veículo" class="ad-image">
                            <div class="ad-content">
                                <h3 class="ad-title"><?= htmlspecialchars($anuncio['marca_desc'] . ' ' . $anuncio['modelo_desc']) ?></h3>
                                <p class="ad-version"><?= htmlspecialchars($anuncio['veiculo_versao']) ?></p>
                                <p class="ad-price">R$ <?= number_format($anuncio['anuncio_valor'], 0, ',', '.') ?></p>
                                <p class="ad-details"><?= htmlspecialchars($anuncio['veiculo_ano']) ?> &bull; <?= number_format($anuncio['veiculo_quilometragem'], 0, ',', '.') ?> km</p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; 
            }
            ?>
        </div>
    </main>
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
<script src="../JS/js-functions.js"></script>

<?php
include '../components/footer.php';
?>
</body>
</html>