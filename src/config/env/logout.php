<?php
/**
 * Ponto central de autenticação e gerenciamento de sessão.
 * * Inclua este arquivo no TOPO de TODAS as páginas protegidas
 * ou que precisem de informações do usuário.
 */

// 1. Inicia a sessão (ou continua uma existente) em qualquer página que incluir este arquivo.
// session_status() evita erros se a sessão já foi iniciada.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verifica se o usuário está logado.
 *
 * @return bool Verdadeiro se estiver logado, Falso se não.
 */
function estaLogado(): bool {
    return isset($_SESSION['user_id']);
}

/**
 * Verifica se o usuário logado é um administrador.
 * Assume que o nível de acesso de admin é 1.
 *
 * @return bool Verdadeiro se for admin, Falso se não.
 */
function eAdmin(): bool {
    return isset($_SESSION['user_level']) && $_SESSION['user_level'] === 'ADMIN';
}

/**
 * Obtém o ID do usuário logado.
 *
 * @return int|null O ID do usuário, ou null se não estiver logado.
 */
function getUsuarioIdLogado(): ?int {
    if (estaLogado()) {
        return (int)$_SESSION['user_id'];
    }
    return null;
}

/**
 * Força o "login" de um usuário (para testes).
 *
 * @param int $id O ID do usuário que você quer "logar".
 * @param string $nome (Opcional) O nome do usuário.
 */
function loginFalso(int $id, string $nome = 'Usuário Teste'): void {
    // Limpa qualquer sessão antiga antes de logar
    session_unset();
    session_destroy();
    
    // Inicia uma nova sessão
    session_start();

    $_SESSION['user_id'] = $id;
    $_SESSION['user_name'] = $nome; // Bônus: guardar o nome
    
    // Regenera o ID da sessão para segurança (boa prática)
    session_regenerate_id(true);
}

/**
 * Inicia a sessão para um usuário autenticado.
 *
 * @param array $usuario Array com os dados do usuário vindo do banco (ex: id, nome, email).
 */
function login(array $usuario): void {
    // Limpa qualquer sessão antiga antes de logar
    if (session_status() == PHP_SESSION_ACTIVE) {
        session_unset();
        session_destroy();
    }
    
    session_start();
    // Garante que a sessão está ativa
    if (session_status() == PHP_SESSION_NONE) session_start();
    // Limpa todos os dados da sessão anterior
    session_unset();
    $_SESSION['user_id'] = (int)$usuario['usuario_id'];
    $_SESSION['user_name'] = $usuario['usuario_nome'];
    $_SESSION['user_level'] = $usuario['usuario_nivel_de_acesso'];
    // Regenera o ID da sessão para segurança
    session_regenerate_id(true);
}

/**
 * Destrói a sessão (faz o logout).
 */
function logout(): void {
    session_unset();
    session_destroy();
}

/**
 * Protege uma página. Se o usuário não estiver logado,
 * ele é redirecionado para a página de login.
 *
 * @param string $pagina_redirecionamento A página para onde enviar o usuário (ex: 'login.php')
 */
function protegerPagina(string $pagina_redirecionamento = 'login.php'): void {
    if (!estaLogado()) {
        header("Location: $pagina_redirecionamento");
        exit; // Garante que o script pare de ser executado
    }
}

?>