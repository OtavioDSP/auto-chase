<?php
// 1. CORREÇÃO: Inicia o gerenciador de sessão.
// Isso é essencial para a página saber se o usuário está logado ou não.
require_once '../config/env/logout.php';
include_once '../php/classes/class-veiculo.php';
include_once '../php/classes/class-anuncio.php'; 
include_once '../config/db/connect.php'; 
include_once '../php/classes/class-usuario.php'; 
include_once '../php/classes/class-modelo.php'; 
include_once '../php/classes/class-marca.php';
include_once '../php/classes/class-cor.php';
include_once '../php/classes/class-chassi.php';
include_once '../php/classes/class-combustivel.php';
// essa porra de pagina n ta pouxando o login wtf e ainda quebra o css vai tomanocu
$modeloManager = new Modelo(
  null,
  null,
  null,
  null,
  $conexao
);
$marcaManager = new Marca(
  null,
  null,
  $conexao
);
$corManager = new Cor(
  null,
  null,
  $conexao
);
$chassiManager = new Chassi(
  null,
  null,
  $conexao
);
$combustivelManager = new Combustivel(
  null,
  null,
  $conexao
);

// Nome da variável corrigido para funcionar com filter-functions.php
$todosModelos = $modeloManager->listarModelo(); 
$marcas = $marcaManager->listarMarca();
$cores = $corManager->listarCor();
$chassis = $chassiManager->listarChassi();
$combustiveis = $combustivelManager->listarCombustivel();

// Inclui o gerenciador de sessão para verificar se o usuário já está logado
require_once '../config/env/logout.php';

// Se o usuário já estiver logado, redireciona para a página principal
if (estaLogado()) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Anúncio</title>
    <link rel="stylesheet" href="../css/anuncio.css">
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
                <!-- 2. CORREÇÃO: Caminho do link "Comprar" ajustado -->
                <a href="../../comprar.php">Comprar</a>
                <a href="anuncio.php">Anunciar</a>
            </nav>
        </div>
        <div class="header-right">
            <?php if (estaLogado()): ?>
                <!-- Mostra as opções do usuário logado -->
                <a href="../../chat.php" class="nav-link-icon">
                    <i class="fas fa-comment"></i> 
                </a>
                <!-- 3. CORREÇÃO: Caminho do link "Minha Conta" ajustado -->
                <a href="edits.php?usuario_id=<?= htmlspecialchars($_SESSION['user_id']) ?>" class="nav-link-icon">
                    Minha Conta
                </a>
                <form action="../php/global/global.php" method="post" style="display:inline; margin:0;">
                    <button type="submit" name="logout_usuario" class="btn-login" style="border:none;">
                        Sair
                    </button>
                </form>
            <?php else: ?>
                <!-- 4. CORREÇÃO: Caminho do botão "Login" ajustado -->
                <a href="../../login.php" class="btn-login">Login</a>
            <?php endif; ?>
        </div>
    </header>

    <h2>Criar novo anúncio</h2>

    <!-- CORREÇÃO: Adicionada a classe "form-anuncio" para que o CSS aplique o estilo de card apenas a este formulário. -->
    <form action="../php/global/global.php" method="POST" enctype="multipart/form-data" class="form-anuncio">
        <p>Imagem:</p>
        <input type="file" name="img[]" multiple>
        <br>
        <br>
        <br>
        
        <?php include '../php/functions/filter-functions.php'; ?>

        <label for="veiculo_ano">Ano:</label>
        <input type="text" id="veiculo_ano" name="veiculo_ano" pattern="\d{4}" maxlength="4" required placeholder="Ano">

        <label>Chassi:</label>
        <select name="fk_chassi_id">
            <?php foreach ($chassis as $chassi): ?>
            <option value="<?= $chassi['chassi_id'] ?>"><?= $chassi['chassi_desc'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label>Cor:</label>
        <select name="fk_cor_id">
            <?php foreach ($cores as $cor): ?>
            <option value="<?= $cor['cor_id'] ?>"><?= $cor['cor_desc'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label>Combustível:</label>
        <select name="fk_combustivel_id">
            <?php foreach ($combustiveis as $comb): ?>
            <option value="<?= $comb['comb_id'] ?>"><?= $comb['comb_desc'] ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label>Quilometragem:</label>
        <input type="number" name="veiculo_quilometragem" required><br>

        <label>Versão:</label>
        <input type="text" name="veiculo_versao" required><br>

        <label>Sobre Este Veiculo</label>
        <textarea name="anuncio_desc" rows="4"></textarea><br>

        <label>Preço:</label>
        <input type="number" name="anuncio_valor" step="0.01" required><br>

        <input type="submit" value="Publicar Anúncio" name="criar_anuncio">
    </form>

    <script src="../JS/js-functions.js"></script>
</body>
</html>