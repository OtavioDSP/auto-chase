<?php
require_once '../config/db/connect.php';
require_once '../php/classes/class-usuario.php';
require_once '../php/classes/class-chassi.php';
require_once '../php/classes/class-modelo.php';
require_once '../php/classes/class-marca.php';
require_once '../php/classes/class-cor.php';
require_once '../php/classes/class-chat.php';
require_once '../php/classes/class-combustivel.php';
require_once '../php/classes/class-anuncio.php';
require_once '../php/classes/class-veiculo.php';
require_once '../php/classes/class-imagem.php';
require_once '../php/functions/main-functions.php';
require_once '../php/functions/salvar-imagens.php';
require_once '../config/env/logout.php';


// Verifica se o usuário está logado
if (!estaLogado()) {
    header('Location: ../../login.php');
    exit;
}

$usuario_id = $_SESSION['user_id'];

// Instancia o manager de anúncios
$anuncioManager = new Anuncio(null, null, null, null, null, null, $conexao);

// Busca todos os anúncios do usuário logado (incluindo ativos, inativos e vendidos)
$meusAnuncios = $anuncioManager->listarAnunciosPorUsuario($usuario_id);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Anúncios</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/adminpanel.css">
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

<br><br><br><br>

<div class="ad-grid-container">
    <h2>Meus Anúncios</h2>
    <div class="ad-grid">
        <?php if (empty($meusAnuncios)): ?>
            <p>Você ainda não criou nenhum anúncio.</p>
        <?php else: ?>
            <?php foreach ($meusAnuncios as $anuncio): ?>
                <div class="ad-card">
                    <a href="card.php?anuncio_id=<?= $anuncio['anuncio_id'] ?>" class="ad-card-link">
                        <img src="../<?= htmlspecialchars($anuncio['imagem_url']) ?>" alt="Foto do veículo" class="ad-image">
                        <div class="ad-content">
                            <h3 class="ad-title"><?= htmlspecialchars($anuncio['marca_desc'] . ' ' . $anuncio['modelo_desc']) ?></h3>
                            <p class="ad-version"><?= htmlspecialchars($anuncio['veiculo_versao']) ?></p>
                            <p class="ad-price">R$ <?= number_format($anuncio['anuncio_valor'], 2, ',', '.') ?></p>
                            <p class="ad-details"><?= htmlspecialchars($anuncio['veiculo_ano']) ?> &bull; <?= htmlspecialchars($anuncio['veiculo_quilometragem']) ?> km</p>
                            <p class="ad-status">Status: <?= htmlspecialchars(ucfirst($anuncio['anuncio_status'])) ?></p>
                        </div>
                    </a>
                    <div class="ad-actions">
                        <a href="edits.php?anuncio_id=<?= $anuncio['anuncio_id'] ?>" class="action-edit">Editar</a>
                        <form method="post" action="../php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este anúncio?');" style="display:inline;">
                            <input type='hidden' name='anuncio_id' value='<?= $anuncio['anuncio_id'] ?>'>
                            <input type='submit' value='Deletar' name="deletar_anuncio" class="action-delete">
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
