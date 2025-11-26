<?php
// Includes de conexão e de todas as classes
require_once '../config/env/logout.php';
require_once '../config/db/connect.php';
require_once '../php/classes/class-anuncio.php';

// Proteção: se não estiver logado, redireciona para o login
if (!estaLogado()) {
    header('Location: ../../login.php?status=unauthorized');
    exit();
}

$usuario_id = getUsuarioIdLogado();
$anuncioManager = new Anuncio(null, null, null, null, null, null, $conexao);
$meusAnuncios = $anuncioManager->listarAnunciosPorUsuario($usuario_id);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Anúncios | Autochase</title>
    <link rel="stylesheet" href="../css/index.css"> <!-- Estilo base e header -->
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/meus-anuncios.css"> <!-- Novo CSS para esta página -->
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

<div class="container-meus-anuncios">
    <header class="page-header">
        <h1>Meus Anúncios</h1>
        <p>Gerencie, edite ou remova seus anúncios publicados.</p>
    </header>

    <div class="grid-meus-anuncios">
        <?php if (empty($meusAnuncios)): ?>
            <div class="no-ads-message">
                <h3>Você ainda não tem nenhum anúncio.</h3>
                <p>Que tal anunciar seu veículo agora mesmo?</p>
                <a href="anuncio.php" class="btn-anunciar-agora">Anunciar Agora</a>
            </div>
        <?php else: ?>
            <?php foreach ($meusAnuncios as $anuncio): ?>
                <div class="card-meu-anuncio">
                    <a href="card.php?anuncio_id=<?= $anuncio['anuncio_id'] ?>" class="card-main-link"></a>
                    <img src="../<?= htmlspecialchars(ltrim($anuncio['imagem_url'], 'src/')) ?>" alt="Foto do veículo" class="ad-image">
                    <div class="card-content">
                        <span class="ad-status ad-status-<?= strtolower(htmlspecialchars($anuncio['anuncio_status'])) ?>"><?= htmlspecialchars($anuncio['anuncio_status']) ?></span>
                        <h3 class="ad-title"><?= htmlspecialchars($anuncio['marca_desc'] . ' ' . $anuncio['modelo_desc']) ?></h3>
                        <p class="ad-version"><?= htmlspecialchars($anuncio['veiculo_versao']) ?></p>
                        <p class="ad-price">R$ <?= number_format($anuncio['anuncio_valor'], 0, ',', '.') ?></p>
                        <div class="card-actions">
                            <form method="post" action="../php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este anúncio? A ação não pode ser desfeita.');" style="display: inline;">
                                <input type='hidden' name='anuncio_id' value='<?= $anuncio['anuncio_id'] ?>'>
                                <button type='submit' name='deletar_anuncio' class="action-btn delete-btn">Deletar</button>
                            </form>
                            <a href="edits.php?anuncio_id=<?= $anuncio['anuncio_id'] ?>" class="action-btn edit-btn">Editar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?php
include '../components/footer.php';
?>
</body>
</html>