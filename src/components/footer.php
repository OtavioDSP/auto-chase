<?php

$_SERVER['SERVER_NAME']== "localhost" ? $URL= "/tcc/auto-chase/" : $URL= "/autochase/";


?>

<footer class="site-footer">
    <div class="footer-container">
        <!-- Seção Sobre -->
        <div class="footer-section footer-about">
            <img src="../img/ac 911 white sc.png" alt="Autochase Logo" class="footer-logo">
            <p>Compre e venda com segurança e confiança<br> Persiga seus sonhos.</p>
        </div>

        <!-- Seção de Links Rápidos -->
        <div class="footer-section footer-links">
            <h4>Navegação</h4>
            <ul>
                <li><a href="<?= $URL ?>index.php">Início</a></li>
                <li><a href="<?= $URL ?>src/routes/compra.php">Comprar</a></li>
                <li><a href="<?= $URL ?>src/routes/anuncio.php">Anunciar</a></li>
                <li><a href="https://github.com/OtavioDSP/auto-chase/tree/main">Sobre Nós</a></li>
            </ul>
        </div>

        <!-- Seção de Contato e Redes Sociais -->
        <div class="footer-section footer-social">
            <h4>Contato</h4>
            <p>Email: contato@autochase.com.br</p>
            <div class="social-icons">
                <a href="https://www.facebook.com" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="https://www.x.com" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="https://www.youtube.com" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <!-- Barra inferior do rodapé -->
    <div class="footer-bottom">
        <p>&copy; <?= date("Y") ?> Autochase. Todos os direitos reservados.</p>
    </div>
</footer>

<!-- Adiciona o script de funções JS no final para otimizar o carregamento -->
<script src="/andrei/auto-chase/src/JS/js-functions.js"></script>