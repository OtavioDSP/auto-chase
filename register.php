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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crie sua Conta - Autochase</title>
    
    <!-- CSS da página de registro e ícones -->
    <link rel="stylesheet" href="src/css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" type="image/png" href="src/img/ac icon.png">
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
        <!-- Como o usuário não está logado, só o botão de Login aparece -->
        <a href="login.php" class="btn-login">Login</a>
    </div>
</header>

<div class="register-page-wrapper">

    <!-- 
      ============================================
      FORMULÁRIO DE CADASTRO
      ============================================
    -->
    <form action="src/php/global/global.php" method="POST">
        <div class="register-container">
            <h5><img src="src/img/ac 911 white sc.png" alt="logo" class="logo"></h5>
            <h1>Crie sua conta</h1>
            
            <?php if (isset($_GET['status']) && $_GET['status'] === 'userexists'): ?>
                <h3 style="color: red; text-align:center;">Este e-mail ou documento já está cadastrado.</h3>
            <?php endif; ?>

            <div class="form">
                <div class="form-row">
                    <div class="form-field">
                        <input type="text" name="usuario_nome" placeholder="Nome completo" required>
                    </div>
                    <div class="form-field">
                        <input type="email" name="usuario_email" placeholder="Seu melhor e-mail" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-field">
                        <input type="text" name="usuario_telefone" placeholder="Telefone (Opcional)" oninput="maskTelefone(this)">
                    </div>
                    <div class="form-field">
                        <input type="text" name="usuario_endereco" placeholder="Endereço (Opcional)">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-field senha-container">
                        <input type="password" id="senha" name="usuario_senha" placeholder="Crie uma senha" required minlength="8" maxlength="255">
                        <button type="button" onclick="toggleSenha('senha')"><i class="fa fa-eye"></i></button>
                    </div>
                    <div class="form-field doc-container">
                        <input type="text" name="usuario_doc_cpf_cnpj" placeholder="CPF ou CNPJ" required oninput="maskAndVerifyDocumento(this)">
                    </div>
                </div>
                
                <input type="submit" value="Criar Conta" name="criar_usuario" class="submit">
            </div>

            <p style="text-align: center; margin-top: 20px; color: #fff;">
                Já tem uma conta? <a href="login.php" style="color: #ffffff; font-weight: bold;">Faça login</a>
            </p>
        </div>
    </form>

    <!-- JANELA DE FEEDBACK DO DOCUMENTO -->
    <div id="doc-feedback-popup" class="feedback-popup">
        <p id="feedback-text">Digite seu CPF ou CNPJ para validação.</p>
    </div>

</div><!-- Fim do .register-page-wrapper -->

<!-- Scripts JS para máscaras e validações -->
<script src="src/JS/js-functions.js"></script>

</body>
</html>