<?php
include_once '../../config/env/logout.php';
include_once '../../config/db/connect.php';
include_once '../../php/classes/class-usuario.php';

if (!estaLogado()) {
    header('Location: ../../../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario_id'])) {
    $id_logado = getUsuarioIdLogado();
    $id_alvo = intval($_POST['usuario_id']);

    // Admin can delete any user, a regular user can only delete themselves.
    if (!eAdmin() && $id_logado !== $id_alvo) {
        echo "<h1>Acesso Negado</h1><p>Você não tem permissão para excluir este usuário.</p>";
        exit();
    }

    $manager = new Usuario(null, null, null, null, null, null, null, null, $conexao);
    
    if ($manager->deletarUsuario($id_alvo)) {
        // If the user deleted themselves, log them out and redirect.
        if ($id_logado === $id_alvo) {
            // This will destroy the session and log the user out.
            header('Location: ../../config/env/logout.php?logout=true');
        } else {
            // If an admin deleted another user, redirect back.
            header('Location: ../../routes/admin_panel.php'); 
        }
        exit();
    } else {
        echo "<h1>Erro ao Excluir</h1><p>Não foi possível excluir o usuário. Tente novamente.</p>";
    }
} else {
    header('Location: ../../../index.php');
    exit();
}
?>