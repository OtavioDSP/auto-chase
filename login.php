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
    <title>Login - Autochase</title>
    <!-- Adapte o caminho para seu CSS, se necessário -->
    <link rel="stylesheet" href="src/css/style.css"> 
</head>
<body>
    <h1>Acessar sua conta</h1>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'loginfailed'): ?>
        <p style="color: red;">E-mail ou senha incorretos. Tente novamente.</p>
    <?php endif; ?>

    <form action="src/php/global/global.php" method="POST">
        <input type="email" name="usuario_email" placeholder="Seu e-mail" required>
        <input type="password" name="usuario_senha" placeholder="Sua senha" required>
        <button type="submit" name="login_usuario">Entrar</button>
    </form>
    <p>Não tem uma conta? <a href="register.php">Cadastre-se</a></p>
</body>
</html>