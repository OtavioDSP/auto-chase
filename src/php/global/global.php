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
    
    $usu = new Usuario($usuario_id, $usuario_nome, $usuario_email, $usuario_senha, $usuario_telefone, $usuario_endereco, $usuario_doc_cpf_cnpj, $usuario_nivel_de_acesso, $conexao);

    
    $usu->editarUsuario();
}if(isset($_POST['enviar_informacoes'])){
    $cor_desc = $_POST['cor_desc'];
    $marca_desc = $_POST['marca_desc'];
    $modelo_desc = $_POST['modelo_desc'];
    $modelo_ano = $_POST['modelo_ano'];
    $modelo_fipe = $_POST['modelo_fipe'];
    $chassi_desc = $_POST['chassi_desc'];
    $comb_desc = $_POST['comb_desc'];


    ECHO "ANO: $modelo_ano";

    $marca = new Marca("", $marca_desc, $conexao);
    $marcaGerada = $marca->insereMarca();
    $marcaGerada = $conexao->insert_id;

    echo "MARCA GERADA:$marcaGerada";

    

    $cor = new Cor("", $cor_desc, $conexao);
    
    $modelo = new Modelo("", $modelo_desc,$modelo_ano, $modelo_fipe, $marcaGerada, $conexao);
    $chassi = new Chassi("", $chassi_desc, $conexao);
    $combustivel = new Combustivel("", $comb_desc, $conexao);
   
    

    $cor->insereCor();
    $modelo->insereModelo();
    $chassi->insereChassi();
    $combustivel->insereCombustivel();
   

    
}else{
    echo "Nenhum formulário foi enviado.";
}
?> 
