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
include_once '../php/classes/class-veiculo.php';
include_once '../php/classes/class-modelo.php';

if (isset($_GET['usuario_id'])) {
    
    $usuario_id = intval($_GET['usuario_id']);
    
    
    $usu = new Usuario("", "", "", "", "", "", "", "", $conexao);

    
    $usuario = $usu->buscarUsuarioPorId($usuario_id);

    if ($usuario) {
        ?>
        <h1>Editar Usuário</h1>
        <form action="../php/global/global.php" method="POST">
            <input type="hidden" name="usuario_id" value="<?= $usuario['usuario_id'] ?>">

            <label for="usuario_nome">Nome:</label>
            <input type="text" id="usuario_nome" name="usuario_nome" value="<?= $usuario['usuario_nome'] ?>" required>
            
            <label for="usuario_email">Email:</label>
            <input type="email" id="usuario_email" name="usuario_email" value="<?= $usuario['usuario_email'] ?>" required>

            <label for="usuario_endereco">Endereço:</label>
            <input type="text" id="usuario_endereco" name="usuario_endereco" value="<?= $usuario['usuario_endereco'] ?>">

            <label for="usuario_telefone">Telefone:</label>
            <input type="text" id="usuario_telefone" name="usuario_telefone" value="<?= $usuario['usuario_telefone'] ?>">

            <label for="usuario_doc_cpf_cnpj">CPF ou CNPJ:</label>
            <input type="text" id="usuario_doc_cpf_cnpj" name="usuario_doc_cpf_cnpj" value="<?= $usuario['usuario_doc_cpf_cnpj'] ?>">

            <label for="usuario_senha">Nova Senha:</label>
            <input type="password" id="usuario_senha" name="usuario_senha" placeholder="Deixe em branco para não alterar">
            
            <label for="usuario_nivel_de_acesso">Nível de Acesso:</label>
            <input type="text" id="usuario_nivel_de_acesso" name="usuario_nivel_de_acesso" value="<?= $usuario['usuario_nivel_de_acesso'] ?>">

            <br>
            <button type="submit" name="editar_usuario">Salvar Alterações</button>
        </form>
        <?php
    } else {
        echo "<p>Usuário não encontrado.</p>";
    }

} elseif (isset($_GET['veiculo_id'])) {?>

    <form action="../php/global/global.php" method="post">


    </form>


<?php }elseif(isset($_GET['modelo_id'])) {
    $modelo_id = intval($_GET['modelo_id']);
    $vec = new Modelo("", "", "", "", "", $conexao);
    $modelo = $vec->buscarModeloPorId($modelo_id);
    print_r($modelo);
    if ($modelo) {
        ?>
        <h1>Editar Modelo</h1>
        <form action="../php/global/global.php" method="POST">
            <input type="hidden" name="modelo_id" value="<?= $modelo['modelo_id'] ?>">

            <label for="modelo_nome">Nome do Modelo:</label>
            <input type="text" id="modelo_nome" name="modelo_desc" value="<?= $modelo['modelo_desc'] ?>" required>
        
            <label for="modelo_ano">Ano do Modelo:</label>
            <input type="text" id="modelo_ano" name="modelo_ano" value="<?= $modelo['modelo_ano'] ?>" required>
            <br>
            <label for="modelo_valor_fipe">Valor Fipe:</label>
            <input type="text" id="modelo_valor_fipe" name="modelo_valor_fipe" value="<?= $modelo['modelo_valor_fipe'] ?>" required>
            
            <br>
            <button type="submit" name="editar">Salvar Alterações</button>
        </form>
        <?php
    } else {
        echo "<p>Modelo não encontrado.</p>";
    }

}
?>
</body>
</html>
