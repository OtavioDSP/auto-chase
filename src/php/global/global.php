<?php

include_once '../../config/db/connect.php';
include_once './../classes/class-usuario.php';

$criar_conta = $_POST['criar_conta'];

if(isset($criar_conta)){
    $usuario_nome = $_POST['usuario_nome'];
    $usuario_senha = $_POST['usuario_senha'];
    $usuario_email = $_POST['usuario_email'];
    $usuario_telefone = $_POST['usuario_telefone'];
    $usuario_endereco = $_POST['usuario_endereco'];
    $doc_cpf_cnpj = $_POST['doc_cpf_cnpj'];


    $usuario = new Usuario("", $usuario_nome, $usuario_senha, $usuario_email, $usuario_telefone, $usuario_endereco, $doc_cpf_cnpj, $conexao);
    $usuario->insereUsuario();

    echo "Conta criada com sucesso!";
}



?>