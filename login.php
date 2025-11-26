<?php
// Inclui o gerenciador de sessão para verificar se o usuário já está logado
require_once 'src/config/env/logout.php';

// Se o usuário já estiver logado, redireciona para a página principal
if (estaLogado()) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Head copiado do seu index.php para manter os estilos -->
    <link rel="stylesheet" href="src/css/login.css">
    <link rel="stylesheet" href="src/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" type="image/png" href="src/img/ac icon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login ou Cadastro | Autochase</title>

</head>
<body>

<!-- Header completo do seu index.php -->
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
            <!-- (Esta parte não deve aparecer aqui, mas mantendo a lógica do seu header) -->
            <a href="src/routes/edits.php?usuario_id=<?= htmlspecialchars($_SESSION['user_id']) ?>" class="nav-link-icon">
                Minha Conta
            </a>
            <form action="src/php/global/global.php" method="post" style="display:inline; margin:0;">
                <button type="submit" name="logout_usuario" class="btn-login" style="border:none;">
                    Sair
                </button>
            </form>
        <?php else: ?>
            <!-- O link de login agora aponta para esta própria página -->
            <a href="login.php" class="btn-login">Login</a>
        <?php endif; ?>
    </div>
</header>

<div class="login-page-wrapper">

    <!-- 
      ============================================
      FORMULÁRIO DE LOGIN (Estilizado)
      ============================================
    -->
    <form action="src/php/global/global.php" method="POST">
        <div class="login-container">
            <h5><img src="src/img/ac 911 white sc.png" alt="logo" class="logo"></h5>
            <h1>Acessar sua conta</h1>
            
            <?php if (isset($_GET['status']) && $_GET['status'] === 'loginfailed'): ?>
                
                <h3 id="resultado" style="color: red; text-align:center;">E-mail ou senha incorretos.</h3>
            <?php endif; ?>

            <div class="form">
                <input type="email" name="usuario_email" placeholder="Seu e-mail" required>
                <div class="senha-container">
                    <!-- ID único para a senha de login (caso precise do "olho" aqui também) -->
                    <input type="password" id="senha_login" name="usuario_senha" placeholder="Sua senha" required>
                    <button type="button" onclick="toggleSenha('senha_login')"><i class="fa fa-eye"></i></button>
                </div>
                
                <input type="submit" value="Entrar" name="login_usuario">
            </div>

            <p style="text-align: center; margin-top: 20px; color: #fff;">
                Ainda não tem uma conta? <a href="register.php" style="color: #ffffff; font-weight: bold;">Crie sua conta</a>
            </p>
        </div>
    </form>

</div><!-- Fim do .login-page-wrapper -->

<script src="src/JS/js-functions.js"></script>

<?php
include 'src/components/footer.php';
?>
</body>
</html>