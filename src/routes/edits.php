<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    
</head>
<body>
<?php
include_once '../config/db/connect.php'; 



include_once '../php/classes/class-usuario.php';

if (!isset($_GET['usuario_id'])) {
    echo "ID do usuário não fornecido.";
    exit;
}else if($_GET['usuario_id']){
     <h1>Editar Usuário</h1>
    <form action="../php/global/global.php" method="POST">
         <input type="hidden" name="usuario_id" value="<?=$usuario['usuario_id']?>">

        <label for="usuario_nome">Nome:</label>
        <input type="text" id="usuario_nome" name="usuario_nome" value="<?=$usuario['usuario_nome']?>" required>
        
        <label for="usuario_email">Email:</label>
        <input type="email" id="usuario_email" name="usuario_email" value="<?= $usuario['usuario_email']?>" required>

        <label for="usuario_endereco">Endereço:</label>
        <input type="text" id="usuario_endereco" name="usuario_endereco" value="<?=$usuario['usuario_endereco']?>">

        <label for="usuario_telefone">Telefone:</label>
        <input type="text" id="usuario_telefone" name="usuario_telefone" value="<?=$usuario['usuario_telefone']?>">

        <label for="usuario_doc_cpf_cnpj">CPF ou CNPJ:</label>
        <input type="text" id="usuario_doc_cpf_cnpj" name="usuario_doc_cpf_cnpj" value="<?=$usuario['usuario_doc_cpf_cnpj']?>">

        <label for="usuario_senha">Nova Senha:</label>
        <input type="password" id="usuario_senha" name="usuario_senha" placeholder="Deixe em branco para não alterar">
        
        <label for="usuario_nivel_de_acesso">Nível de Acesso:</label>
        <input type="text" id="usuario_nivel_de_acesso" name="usuario_nivel_de_acesso" value="<?=$usuario['usuario_nivel_de_acesso']?>">

        <br>
        <button type="submit" name="editar">Salvar Alterações</button>
    </form>


}

$usuario_id = intval($_GET['usuario_id']);


$usu = new Usuario("","", "","", "", "", "", "", $conexao);


$usuario = $usu->buscarUsuarioPorId($usuario_id);


if (!$usuario) {
    echo "Usuário não encontrado!";
    exit;
}



   

</body>
</html>
