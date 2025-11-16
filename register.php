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
    <link rel="stylesheet" href="src/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" type="image/png" href="src/img/ac icon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crie sua Conta - Autochase</title>

    <!-- Estilo extra para esta página -->
    <style>
        .register-page-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 0;
        }
    </style>
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
            <a href="comprar.php">Comprar</a>
            <a href="src/routes/anuncio.php">Anunciar</a>
        </nav>
    </div>
    <div class="header-right">
        <!-- Como o usuário não está logado, mostramos o botão de Login -->
        <a href="login.php" class="btn-login">Login</a>
    </div>
</header>

<div class="register-page-wrapper">

    <!-- 
      ============================================
      FORMULÁRIO DE CADASTRO
      ============================================
    -->
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

            <p style="text-align: center; margin-top: 20px; color: #fff;">
                Já tem uma conta? <a href="login.php" style="color: #ffffff; font-weight: bold;">Faça login</a>
            </p>
            <br>
        </div>
    </form>

</div><!-- Fim do .register-page-wrapper -->

<!-- Script necessário para as máscaras do formulário de cadastro -->
<script src="src/JS/js-functions.js"></script>

</body>
</html>