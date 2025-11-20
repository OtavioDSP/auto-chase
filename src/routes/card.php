<?php
// Includes de conexão e de todas as classes
include_once '../config/env/logout.php';
include_once '../config/db/connect.php'; 
include_once '../php/classes/class-anuncio.php';
include_once '../php/classes/class-imagem.php';

// Verifica se o ID do anúncio foi passado
if (!isset($_GET['anuncio_id']) || empty($_GET['anuncio_id'])) {
    header('Location: ../../index.php');
    exit();
}

$anuncio_id = intval($_GET['anuncio_id']);

// --- TAPA-BURACO ATUALIZADO ---
// Força a página a sempre mostrar o anúncio de ID 25 (o Vectra).
$anuncio_id_destaque = 25;
$anuncioManager = new Anuncio(null, null, null, null, null, null, $conexao);
$anuncio = $anuncioManager->buscarAnuncioDetalhadoPorId($anuncio_id_destaque);
$anuncio_id = $anuncio_id_destaque; // Garante que o ID usado para buscar as fotos é o 25

// Busca as imagens do anúncio
$imagemManager = new Foto(null, null, null, $conexao);
$fotos = $imagemManager->listarImagemPorIdDeAnuncio($anuncio_id);

// Se o anúncio não for encontrado, redireciona para a home
if (!$anuncio) {
    header('Location: ../../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($anuncio['marca_desc'] . ' ' . $anuncio['modelo_desc']) ?> - Autochase</title>
    <link rel="stylesheet" href="../css/index.css"> <!-- Estilo do header -->
    <link rel="stylesheet" href="../css/card.css"> <!-- Estilo da página -->
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
            <a href="../../chat.php" class="nav-link-icon"><i class="fas fa-comment"></i></a>
            <a href="edits.php?usuario_id=<?= htmlspecialchars($_SESSION['user_id']) ?>" class="nav-link-icon">Minha Conta</a>
            <form action="../php/global/global.php" method="post" style="display:inline; margin:0;">
                <button type="submit" name="logout_usuario" class="btn-login" style="border:none;">Sair</button>
            </form>
        <?php else: ?>
            <a href="../../login.php" class="btn-login">Login</a>
        <?php endif; ?>
    </div>
</header>

<main class="ad-detail-page">
    <div class="ad-detail-container">
        <!-- Coluna da Esquerda: Galeria de Imagens -->
        <div class="ad-gallery">
            <div class="main-image-container">
                <!-- 
                    TAPA-BURACO ESTÉTICO:
                    Força a imagem principal a ser a do Vectra (ID 25) que você especificou.
                -->
                <img src="../uploads/D_NQ_NP_2X_798131-MLB97216666515_112025-T-vectra-elite-24-mpfi-16v-flexpower-aut.webp" alt="Foto principal do veículo" id="main-image">
                <button class="carousel-btn prev" onclick="changeImage(-1)">&#10094;</button>
                <button class="carousel-btn next" onclick="changeImage(1)">&#10095;</button>
            </div>
            <div class="thumbnail-container">
                <?php foreach ($fotos as $index => $foto): ?>
                    <img src="<?= htmlspecialchars($foto['imagem_url']) ?>" alt="Miniatura do veículo <?= $index + 1 ?>" class="thumbnail <?= $index == 0 ? 'active' : '' ?>" onclick="showImage(<?= $index ?>)">
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Coluna da Direita: Detalhes do Anúncio -->
        <div class="ad-info">
            <h1 class="ad-title"><?= htmlspecialchars($anuncio['marca_desc'] . ' ' . $anuncio['modelo_desc']) ?></h1>
            <p class="ad-version"><?= htmlspecialchars($anuncio['veiculo_versao']) ?></p>
            <p class="ad-price">R$ <?= number_format($anuncio['anuncio_valor'], 2, ',', '.') ?></p>

            <div class="ad-specs">
                <div class="spec-item">
                    <span>Ano</span>
                    <strong><?= htmlspecialchars($anuncio['veiculo_ano']) ?></strong>
                </div>
                <div class="spec-item">
                    <span>KM</span>
                    <strong><?= number_format($anuncio['veiculo_quilometragem'], 0, '', '.') ?></strong>
                </div>
                <div class="spec-item">
                    <span>Combustível</span>
                    <strong><?= htmlspecialchars($anuncio['comb_desc']) ?></strong>
                </div>
                <div class="spec-item">
                    <span>Cor</span>
                    <strong><?= htmlspecialchars($anuncio['cor_desc']) ?></strong>
                </div>
            </div>

            <div class="ad-description">
                <h2>Descrição</h2>
                <p><?= nl2br(htmlspecialchars($anuncio['anuncio_desc'])) ?></p>
            </div>

            <div class="seller-info">
                <h2>Informações do Vendedor</h2>
                <p><strong>Nome:</strong> <?= htmlspecialchars($anuncio['usuario_nome']) ?></p>
                <!-- Adicionar mais informações se desejar, como localização, etc. -->
                <button class="btn-contact">Entrar em contato</button>
            </div>
        </div>
    </div>
</main>

<script>
    // Passa as URLs das imagens para o JavaScript
    const images = [
        <?php foreach ($fotos as $foto): ?>
            '<?= htmlspecialchars($foto['imagem_url']) ?>',
        <?php endforeach; ?>
    ];
</script>
<script src="../JS/js-functions.js"></script>

</body>
</html>