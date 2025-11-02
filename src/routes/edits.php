<?php
// Includes de conexão e de todas as classes
include_once '../config/db/connect.php'; 
include_once '../php/classes/class-usuario.php';
include_once '../php/classes/class-veiculo.php';
include_once '../php/classes/class-modelo.php';
include_once '../php/classes/class-marca.php';
include_once '../php/classes/class-cor.php';
include_once '../php/classes/class-chassi.php';
include_once '../php/classes/class-combustivel.php';
include_once '../php/classes/class-anuncio.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Item</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: auto; padding: 20px; }
        form div { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background-color: #007bff; color: white; border: none; cursor: pointer; }
    </style>
    <script>
        // Função para formatar valor em reais
        function formatarMoeda(input) {
            let valor = input.value.replace(/\D/g, '');
            valor = (valor/100).toFixed(2) + '';
            valor = valor.replace('.', ',');
            valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            input.value = valor;
            // Assumindo que o campo hidden sempre terá o ID 'valorBanco' no contexto do form
            input.parentNode.querySelector('#valorBanco').value = input.value.replace(/\./g,'').replace(',','.');
        }
    </script>
</head>
<body>

<?php

// --- ROTA DE EDIÇÃO PARA USUÁRIO ---
if (isset($_GET['usuario_id'])) {
    $id = intval($_GET['usuario_id']);
    $manager = new Usuario(
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        $conexao
    );
    $item = $manager->buscarUsuarioPorId(
        $id
    );
    if ($item) { ?>
        <h1>Editar Usuário</h1>
        <form action="../php/global/global.php" method="POST">
            <input type="hidden" name="usuario_id" value="<?= $item['usuario_id'] ?>">
            <div><label>Nome:</label><input type="text" name="usuario_nome" value="<?= htmlspecialchars($item['usuario_nome']) ?>" required></div>
            <div><label>Email:</label><input type="email" name="usuario_email" value="<?= htmlspecialchars($item['usuario_email']) ?>" required></div>
            <div><label>Endereço:</label><input type="text" name="usuario_endereco" value="<?= htmlspecialchars($item['usuario_endereco']) ?>"></div>
            <div><label>Telefone:</label><input type="text" name="usuario_telefone" value="<?= htmlspecialchars($item['usuario_telefone']) ?>"></div>
            <div><label>CPF/CNPJ:</label><input type="text" name="usuario_doc_cpf_cnpj" value="<?= htmlspecialchars($item['usuario_doc_cpf_cnpj']) ?>"></div>
            <div><label>Nova Senha:</label><input type="password" name="usuario_senha" placeholder="Deixe em branco para não alterar"></div>
            <div>
                <label>Nível de Acesso:</label>
                <select name="usuario_nivel_de_acesso">
                    <option value="USUARIO" <?= ($item['usuario_nivel_de_acesso'] == 'USUARIO') ? 'selected' : '' ?>>Usuário</option>
                    <option value="ADMIN" <?= ($item['usuario_nivel_de_acesso'] == 'ADMIN') ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <button type="submit" name="editar_usuario">Salvar Alterações</button>
        </form>
    <?php } else { echo "<p>Usuário não encontrado.</p>"; }

// --- ROTA DE EDIÇÃO PARA MARCA ---
} elseif (isset($_GET['marca_id'])) {
    $id = intval($_GET['marca_id']);
    $manager = new Marca(
        null,
        null,
        $conexao
);
    $item = $manager->buscarMarcaPorId(
        $id
    );
    if ($item) { ?>
        <h1>Editar Marca</h1>
        <form action="../php/global/global.php" method="POST">
            <input type="hidden" name="marca_id" value="<?= $item['marca_id'] ?>">
            <div><label>Descrição da Marca:</label><input type="text" name="marca_desc" value="<?= htmlspecialchars($item['marca_desc']) ?>" required></div>
            <button type="submit" name="editar_marca">Salvar Alterações</button>
        </form>
    <?php } else { echo "<p>Marca não encontrada.</p>"; }

// --- ROTA DE EDIÇÃO PARA COR ---
} elseif (isset($_GET['cor_id'])) {
    $id = intval($_GET['cor_id']);
    $manager = new Cor(
        null,
        null,
        $conexao
);
    $item = $manager->buscarCorPorId(
        $id
    );
    if ($item) { ?>
        <h1>Editar Cor</h1>
        <form action="../php/global/global.php" method="POST">
            <input type="hidden" name="cor_id" value="<?= $item['cor_id'] ?>">
            <div><label>Descrição da Cor:</label><input type="text" name="cor_desc" value="<?= htmlspecialchars($item['cor_desc']) ?>" required></div>
            <button type="submit" name="editar_cor">Salvar Alterações</button>
        </form>
    <?php } else { echo "<p>Cor não encontrada.</p>"; }

// --- ROTA DE EDIÇÃO PARA COMBUSTÍVEL ---
} elseif (isset($_GET['comb_id'])) {
    $comb_id = intval($_GET['comb_id']);
    $manager = new Combustivel(
        $comb_id,
        null,
        $conexao
    );
    $item = $manager->buscarCombustivelPorId(
        $comb_id
    );
    if ($item) { ?>
        <h1>Editar Combustível</h1>
        <form action="../php/global/global.php" method="POST">
            <input type="hidden" name="comb_id" value="<?= $item['comb_id'] ?>">
            <div><label>Descrição do Combustível:</label><input type="text" name="comb_desc" value="<?= htmlspecialchars($item['comb_desc']) ?>" required></div>
            <button type="submit" name="editar_combustivel">Salvar Alterações</button>
        </form>
    <?php } else { echo "<p>Combustível não encontrado.</p>"; }

// --- ROTA DE EDIÇÃO PARA CHASSI ---
} elseif (isset($_GET['chassi_id'])) {
    $id = intval($_GET['chassi_id']);
    $manager = new Chassi(
        null,
        null,
        $conexao
    );

    $item = $manager->buscarChassiPorId(
        $id
    );
    if ($item) { ?>
        <h1>Editar Chassi</h1>
        <form action="../php/global/global.php" method="POST">
            <input type="hidden" name="chassi_id" value="<?= $item['chassi_id'] ?>">
            <div><label>Descrição do Chassi:</label><input type="text" name="chassi_desc" value="<?= htmlspecialchars($item['chassi_desc']) ?>" required></div>
            <button type="submit" name="editar_chassi">Salvar Alterações</button>
        </form>
    <?php } else { echo "<p>Chassi não encontrado.</p>"; }

// --- ROTA DE EDIÇÃO PARA MODELO ---
} elseif (isset($_GET['modelo_id'])) {

       
    $id = intval($_GET['modelo_id']);
    $modeloManager = new Modelo(
        null,
        null,
        null,
        null, 
        $conexao
    );
    $item = $modeloManager->buscarModeloPorId(
        $id
    );
    if ($item) {
        $marcaManager = new Marca(
            null,
            null,
            $conexao
        );
        $marcas = $marcaManager->listarMarca();

    ?>
        <h1>Editar Modelo</h1>
        <form action="../php/global/global.php" method="POST">
            <input type="hidden" name="modelo_id" value="<?= $item['modelo_id'] ?>">
            <div><label>Descrição do Modelo:</label><input type="text" name="modelo_desc" value="<?= htmlspecialchars($item['modelo_desc']) ?>" required></div>
            <div><label>Valor FIPE:</label>
                <input type="text" oninput="formatarMoeda(this)" value="<?= number_format($item['modelo_valor_fipe'], 2, ',', '.') ?>" required>
                <input type="hidden" name="modelo_valor_fipe" id="valorBanco" value="<?= $item['modelo_valor_fipe'] ?>">
            </div>
            <div>
                <label>Marca:</label>
                <select name="fk_Marca_id" required>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?= $marca['marca_id'] ?>" <?= ($marca['marca_id'] == $item['fk_marca_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($marca['marca_desc']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="editar_modelo">Salvar Alterações</button>
        </form>
    <?php } else { echo "<p>Modelo não encontrado.</p>"; }

// --- ROTA DE EDIÇÃO PARA VEÍCULO (NOVO BLOCO) ---
    }elseif (isset($_GET['anuncio_id'])) {

       
    $id = intval($_GET['anuncio_id']);
    $modeloManager = new Modelo(
        null,
        null,
        null,
        null, 
        $conexao
    );
    $item = $modeloManager->buscarModeloPorId(
        $id
    );
    if ($item) {
        $marcaManager = new Marca(
            null,
            null,
            $conexao
        );
        $marcas = $marcaManager->listarMarca();

    ?>
        <h1>Editar ANUNCIO</h1>
        <form action="../php/global/global.php" method="POST">
            <input type="hidden" name="modelo_id" value="<?= $item['modelo_id'] ?>">
            <div><label>Descrição do Modelo:</label><input type="text" name="modelo_desc" value="<?= htmlspecialchars($item['modelo_desc']) ?>" required></div>
            <div><label>Valor FIPE:</label>
                <input type="text" oninput="formatarMoeda(this)" value="<?= number_format($item['modelo_valor_fipe'], 2, ',', '.') ?>" required>
                <input type="hidden" name="modelo_valor_fipe" id="valorBanco" value="<?= $item['modelo_valor_fipe'] ?>">
            </div>
            <div>
                <label>Marca:</label>
                <select name="fk_Marca_id" required>
                    <?php foreach ($marcas as $marca): ?>
                        <option value="<?= $marca['marca_id'] ?>" <?= ($marca['marca_id'] == $item['fk_marca_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($marca['marca_desc']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="editar_modelo">Salvar Alterações</button>
        </form>
    <?php } else { echo "<p>Anúncio não encontrado.</p>"; }


// --- CASO NENHUM ITEM SEJA SELECIONADO ---
} else {
    echo "<h1>Nenhum item selecionado</h1><p>Por favor, selecione um item para editar.</p>";
}
?>
</body>
</html>