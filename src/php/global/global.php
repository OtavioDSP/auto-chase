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
    
    $usuario = new Usuario("", $usuario_nome, $usuario_senha, $usuario_email, $usuario_telefone, $usuario_endereco, $doc_formatado, "", $conexao);
    $usuario->insereUsuario();

    
}if(isset($_POST['deletar_usuario'])){

    $usu = new Usuario($_POST['usuario_id'],"","","","","","","",$conexao);
    $usu->deletarUsuario();

}if(isset($_POST['editar'])){
    $usuario_id = $_POST['usuario_id'];
    $usuario_nome = $_POST['usuario_nome'];
    $usuario_email = $_POST['usuario_email'];
    $usuario_telefone = $_POST['usuario_telefone'];
    $usuario_senha = $_POST['usuario_senha'];
    $usuario_endereco = $_POST['usuario_endereco']; 
    $usuario_doc_cpf_cnpj = $_POST['usuario_doc_cpf_cnpj'];
    $usuario_nivel_de_acesso = $_POST['usuario_nivel_de_acesso'];
    echo $usuario_senha;
if($usuario_senha !="" and $usuario_doc_cpf_cnpj !=""){
    $usu = new Usuario($usuario_id, $usuario_nome, $usuario_email, $usuario_senha, $usuario_telefone, $usuario_endereco, $usuario_doc_cpf_cnpj, $usuario_nivel_de_acesso, $conexao);
}else{
    echo "sem senha";
    $usu = new Usuario($usuario_id, $usuario_nome, $usuario_email, "", $usuario_telefone, $usuario_endereco,"", $usuario_nivel_de_acesso, $conexao);
}
    
    $usu->editarUsuario();
}
?>
