<?php

include_once '../../../src/config/env/imports.php';



$criar_conta = $_POST['criar_conta'];
$criar_modelo = $_POST['criar_modelo'];

if(isset($criar_conta)){
    $usuario_nome = $_POST['usuario_nome'];
    $usuario_senha = $_POST['usuario_senha'];
    $usuario_email = $_POST['usuario_email'];
    $usuario_telefone = $_POST['usuario_telefone'];
    $usuario_endereco = $_POST['usuario_endereco'];
    $doc_cpf_cnpj = $_POST['doc_cpf_cnpj'];
    
    $valida_documento();

    $usuario = new Usuario("", $usuario_nome, $usuario_senha, $usuario_email, $usuario_telefone, $usuario_endereco, $doc_cpf_cnpj, $conexao);
    $usuario->insereUsuario();

    echo "Conta criada com sucesso!";
}if(isset($criar_modelo)){

    $modelo_desc = $_POST['modelo_desc'];


    $modelo = new Modelo("", $modelo_desc, $conexao);









}



?>