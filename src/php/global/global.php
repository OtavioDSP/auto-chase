<?php


include_once '../../config/env/imports.php';

if(isset($_POST['criar_conta'])){
    $usuario_nome = $_POST['usuario_nome'];
    $usuario_senha = $_POST['usuario_senha'];
    $usuario_email = $_POST['usuario_email'];
    $usuario_telefone = $_POST['usuario_telefone'];
    $usuario_endereco = $_POST['usuario_endereco'];
    $doc_cpf_cnpj = $_POST['doc_cpf_cnpj'];
    
    $doc_formatado = formatarDocumento($doc_cpf_cnpj);
    
    $usuario = new Usuario("", $usuario_nome, $usuario_senha, $usuario_email, $usuario_telefone, $usuario_endereco, $doc_formatado, $conexao);
    $usuario->insereUsuario();

    
}

if(isset($_POST['listar_usuarios'])){
    $usuario = new Usuario("", "", "", "", "", "", "", $conexao);
    $usuarios = $usuario->listarUsuario();
    
            foreach ($usuarios as $usuario) {
                echo "ID: " . $usuario['usuario_id'] . " - ";
                echo "Nome: " . $usuario['usuario_nome'] . " - ";
                echo "Email: " . $usuario['usuario_email'] . "<br>";
                echo "doc: " . $usuario['usuario_doc_cpf_cnpj'] . "<br>";
        }
}



?>
