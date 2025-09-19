<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuário</title>
</head>
<body>
    <a href="src/routes/anuncio.php">Adicionar Anúncio</a>
    <form action="src/php/global/global.php" method="post">
        <h2>Operações de usuário</h2>
        <p>criar conta</p>
        <input type="text" name="usuario_nome" placeholder="Nome de usuário" required>
        <div class="senha-container">
            <input type="password" id="senha" name="usuario_senha" placeholder="Senha" required>
            <button type="button" onclick="toggleSenha()">👁</button>
        </div>
        <input type="email" name="usuario_email" placeholder="Email" required>
        <input type="text" name="usuario_telefone" placeholder="Telefone" required>
        <input type="text" name="usuario_endereco" placeholder="Endereço" required>
        <input type="text" id="documento" oninput="verificarDocumento()" name="doc_cpf_cnpj" placeholder="Digite CPF ou CNPJ" required>
        <p id="resultado">Digite um CPF ou CNPJ.</p>
        <br><br>
        <input type="submit" value="Enviar" name="criar_conta">
    </form>

    <?php
    include('.\src\config\db\connect.php');
    include(".\src\php\classes\class-usuario.php");
    include(".\src\php\classes\class-veiculo.php");
    ?>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>CPF/CNPJ</th>
                <th>Senha (Hash)</th>
                <th>Nível de Acesso</th>
                <th>Ações</th>            
            </tr>
        </thead>
        <tbody>
            <?php
            $usu = new Usuario("", "", "", "", "", "", "", "", $conexao);
            $usr = $usu->listarUsuario();         
            foreach ($usr as $usuario) { ?>
            <tr>
                <td><?=$usuario['usuario_id']?></td>
                <td><?=$usuario['usuario_nome']?></td>
                <td><?=$usuario['usuario_email']?></td>
                <td><?=$usuario['usuario_doc_cpf_cnpj']?></td>
                <td><?=$usuario['usuario_senha']?></td>
                <td><?=$usuario['usuario_nivel_de_acesso']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este usuário?');">
                        <input type='hidden' name='usuario_id' value='<?=$usuario['usuario_id']?>'>
                        <input type='submit' name='deletar_usuario' value='Deletar'>
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?usuario_id=<?=$usuario['usuario_id'] ?>">Editar</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <br><br><br>

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left;">
        <thead>
            <tr>
                <th>ID do Veículo</th>
                <th>Descrição do Veículo</th>
                <th>Quilometragem</th>
                <th>Carroceria</th>
                <th>Cor</th>
                <th>Marca</th>
                <th>Combustivel</th>
                <th>Modelo</th>
                <th>Ano</th>
                <th colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $vcl = new Veiculo("", "", "", $conexao);
            $veiculosArray = $vcl->listarVeiculo(); 
            foreach ($veiculosArray as $veiculo): ?>
            <tr>
                <td><?=$veiculo['veiculo_id']?></td>
                <td><?=$veiculo['veiculo_desc']?></td>
                <td><?=$veiculo['veiculo_quilometragem']?></td>
                <td><?=$veiculo['chassi_desc']?></td>
                <td><?=$veiculo['cor_desc']?></td>
                <td><?=$veiculo['marca_desc']?></td>
                <td><?=$veiculo['comb_desc']?></td>
                <td><?=$veiculo['modelo_desc']?></td>
                <td><?=$veiculo['modelo_ano']?></td>
                <td>
                    <form method="post" action="src/php/global/global.php" onsubmit="return confirm('Tem certeza que deseja deletar este veículo?');">
                        <input type='hidden' name='veiculo_id' value='<?= $veiculo['veiculo_id'] ?>'>
                        <input type='submit' value='Deletar Veículo'>
                    </form>
                </td>
                <td>
                    <a href="src/routes/edits.php?veiculo_id=<?=$veiculo['veiculo_id'] ?>">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="./src/JS/js-functions.js"></script>
</body>
</html>
