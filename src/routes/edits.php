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

if (isset($_GET['usuario_id'])) {
    // Converte o ID para inteiro
    $usuario_id = intval($_GET['usuario_id']);
    $veiculo_id = intval($_GET['veiculo_id']);
    $modelo_id = intval($_GET['modelo_id']);
    $usu = new Usuario("", "", "", "", "", "", "", "", $conexao);
    $vec = new Veiculo("","","",$conexao); 
    
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
            <button type="submit" name="editar">Salvar Alterações</button>
        </form>
        <?php
    } else {
        echo "<p>Usuário não encontrado.</p>";
    }

} elseif (isset($_GET['veiculo_id'])) {?>

    <form action="../php/global/global.php" method="post">


    </form>


<?php }elseif($modelo_id) {

    $vec = new Veiculo("","","","","",$conexao);
    $modelo = $vec->buscarModeloPorId($modelo_id);
    if ($modelo) {
        ?>
        <h1>Editar Modelo</h1>
        <form action="../php/global/global.php" method="POST">
            <input type="hidden" name="modelo_id" value="<?= $modelo['modelo_id'] ?>">

            <label for="modelo_nome">Nome do Modelo:</label>
            <input type="text" id="modelo_nome" name="modelo_nome" value="<?= $modelo['modelo_nome'] ?>" required>
            
            <label for="marca_id">Marca:</label>
            <input type="text" id="marca_id" name="marca_id" value="<?= $modelo['marca_id'] ?>" required>

            <br>
            <button type="submit" name="editar_modelo">Salvar Alterações</button>
        </form>
        <?php
    } else {
        echo "<p>Modelo não encontrado.</p>";
    }

}
?>
</body>
</html>
