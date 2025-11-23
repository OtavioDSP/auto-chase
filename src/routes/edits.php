<?php
// Includes de conexão e de todas as classes
include_once '../config/env/logout.php'; // Inclui para usar eAdmin() e getUsuarioIdLogado()
include_once '../config/db/connect.php'; 
include_once '../php/classes/class-usuario.php';
include_once '../php/classes/class-veiculo.php';
include_once '../php/classes/class-modelo.php';
include_once '../php/classes/class-marca.php';
include_once '../php/classes/class-cor.php';
include_once '../php/classes/class-chassi.php';
include_once '../php/classes/class-combustivel.php';
include_once '../php/classes/class-anuncio.php';
include_once '../php/classes/class-imagem.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/edits.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Painel de Edição</title>

    <link rel="icon" type="image/png" href="../img/ac icon.png">
    <script>
        function confirmDelete(userId) {
            if (confirm("Tem certeza que deseja excluir sua conta? Esta ação é irreversível.")) {
                document.getElementById('delete-form-' + userId).submit();
            }
        }
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

<header>
    <div class="header-left">
        <a href="../../index.php">
            <img src="../img/ac wb 911 white sc.png" alt="Logo" class="logo">
        </a>
    </div>
    <div class="header-center">
        <nav class="nav-links">
            <a href="compra.php">Comprar</a>
            <a href="anuncio.php">Anunciar</a>
        </nav>
    </div>

    <div class="header-right">
        
        <?php if (estaLogado()): ?>

            <a href="meus-anuncios.php" class="nav-link-icon">
                Meus Anúncios
            </a>

            <a href="edits.php?usuario_id=<?= htmlspecialchars($_SESSION['user_id']) ?>" class="nav-link-icon">
                Minha Conta
            </a>
            
            <form action="../php/global/global.php" method="post" style="display:inline; margin:0;">
                <button type="submit" name="logout_usuario" class="btn-login" style="border:none;">
                    Sair
                </button>
            </form>

        <?php else: ?>
            <a href="../../login.php" class="btn-login">Login</a>
        <?php endif; ?>
    </div>
</header>

<div class="container">
    <header class="main-header">
        <h1>Painel de Edição</h1>
        <p>Altere os dados necessários e salve as modificações.</p>
    </header>
<?php

// --- ROTA DE EDIÇÃO PARA USUÁRIO ---
if (isset($_GET['usuario_id'])) {
    // Proteção: usuário só pode editar a si mesmo, a menos que seja admin.
    $id_logado = getUsuarioIdLogado();
    $id_alvo = intval($_GET['usuario_id']);
    if (!eAdmin() && $id_logado !== $id_alvo) {
        echo "<h1>Acesso Negado</h1><p>Você não tem permissão para editar este usuário.</p>";
        exit();
    }

    $id = intval($_GET['usuario_id']);
    $manager = new Usuario(null, null, null, null, null, null, null, null, $conexao);
    $item = $manager->buscarUsuarioPorId($id);
    if ($item) { ?>
        <div class="card">
            <div class="card-header"><h2>Editar Usuário</h2></div>
            <div class="card-body">
                <form action="../php/global/global.php" method="POST" class="edit-form">
                    <input type="hidden" name="usuario_id" value="<?= $item['usuario_id'] ?>">
                    <div class="form-group"><label>Nome:</label><input type="text" name="usuario_nome" value="<?= htmlspecialchars($item['usuario_nome']) ?>" required></div>
                    <div class="form-group"><label>Email:</label><input type="email" name="usuario_email" value="<?= htmlspecialchars($item['usuario_email']) ?>" required></div>
                    <div class="form-group"><label>Endereço:</label><input type="text" name="usuario_endereco" value="<?= htmlspecialchars($item['usuario_endereco']) ?>"></div>
                    <div class="form-group"><label>Telefone:</label><input type="text" name="usuario_telefone" value="<?= htmlspecialchars($item['usuario_telefone']) ?>"></div>
                    <div class="form-group"><label>CPF/CNPJ:</label><input type="text" name="usuario_doc_cpf_cnpj" value="<?= htmlspecialchars($item['usuario_doc_cpf_cnpj']) ?>"></div>
                    <div class="form-group">
                        <label>Nova Senha:</label>
                        <div class="senha-container">
                            <input type="password" id="nova_senha" name="usuario_senha" placeholder="Deixe em branco para não alterar">
                            <button type="button" onclick="toggleSenha('nova_senha')"><i class="fa fa-eye"></i></button>
                        </div>
                    </div>
                    <?php if (eAdmin()): // Apenas admins podem ver e alterar o nível de acesso ?>
                        <div class="form-group">
                            <label>Nível de Acesso:</label>
                            <select name="usuario_nivel_de_acesso">
                                <option value="USUARIO" <?= ($item['usuario_nivel_de_acesso'] == 'USUARIO') ? 'selected' : '' ?>>Usuário</option>
                                <option value="ADMIN" <?= ($item['usuario_nivel_de_acesso'] == 'ADMIN') ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="form-actions">
                        <button type="button" onclick="confirmDelete(<?= $item['usuario_id'] ?>)" class="btn btn-danger">Excluir Conta</button>
                        <a href="javascript:history.back()" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" name="editar_usuario" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>

                <form id="delete-form-<?= $item['usuario_id'] ?>" action="../php/global/delete_account.php" method="POST" style="display: none;">
                    <input type="hidden" name="usuario_id" value="<?= $item['usuario_id'] ?>">
                </form>
            </div>
        </div>
    <?php } else { echo "<p>Usuário não encontrado.</p>"; }

// --- ROTA DE EDIÇÃO PARA MARCA ---
} elseif (isset($_GET['marca_id'])) {
    $id = intval($_GET['marca_id']);
    $manager = new Marca(null, null, $conexao);
    $item = $manager->buscarMarcaPorId($id);
    if ($item) { ?>
        <div class="card">
            <div class="card-header"><h2>Editar Marca</h2></div>
            <div class="card-body">
                <form action="../php/global/global.php" method="POST" class="edit-form">
                    <input type="hidden" name="marca_id" value="<?= $item['marca_id'] ?>">
                    <div class="form-group"><label>Descrição da Marca:</label><input type="text" name="marca_desc" value="<?= htmlspecialchars($item['marca_desc']) ?>" required></div>
                    <div class="form-actions">
                        <a href="javascript:history.back()" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" name="editar_marca" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    <?php } else { echo "<p>Marca não encontrada.</p>"; }

// --- ROTA DE EDIÇÃO PARA COR ---
} elseif (isset($_GET['cor_id'])) {
    $id = intval($_GET['cor_id']);
    $manager = new Cor(null, null, $conexao);
    $item = $manager->buscarCorPorId($id);
    if ($item) { ?>
        <div class="card">
            <div class="card-header"><h2>Editar Cor</h2></div>
            <div class="card-body">
                <form action="../php/global/global.php" method="POST" class="edit-form">
                    <input type="hidden" name="cor_id" value="<?= $item['cor_id'] ?>">
                    <div class="form-group"><label>Descrição da Cor:</label><input type="text" name="cor_desc" value="<?= htmlspecialchars($item['cor_desc']) ?>" required></div>
                    <div class="form-actions">
                        <a href="javascript:history.back()" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" name="editar_cor" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    <?php } else { echo "<p>Cor não encontrada.</p>"; }

// --- ROTA DE EDIÇÃO PARA COMBUSTÍVEL ---
} elseif (isset($_GET['comb_id'])) {
    $comb_id = intval($_GET['comb_id']);
    $manager = new Combustivel($comb_id, null, $conexao);
    $item = $manager->buscarCombustivelPorId($comb_id);
    if ($item) { ?>
        <div class="card">
            <div class="card-header"><h2>Editar Combustível</h2></div>
            <div class="card-body">
                <form action="../php/global/global.php" method="POST" class="edit-form">
                    <input type="hidden" name="comb_id" value="<?= $item['comb_id'] ?>">
                    <div class="form-group"><label>Descrição do Combustível:</label><input type="text" name="comb_desc" value="<?= htmlspecialchars($item['comb_desc']) ?>" required></div>
                    <div class="form-actions">
                        <a href="javascript:history.back()" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" name="editar_combustivel" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    <?php } else { echo "<p>Combustível não encontrado.</p>"; }

// --- ROTA DE EDIÇÃO PARA CHASSI ---
} elseif (isset($_GET['chassi_id'])) {
    $id = intval($_GET['chassi_id']);
    $manager = new Chassi(null, null, $conexao);
    $item = $manager->buscarChassiPorId($id);
    if ($item) { ?>
        <div class="card">
            <div class="card-header"><h2>Editar Chassi</h2></div>
            <div class="card-body">
                <form action="../php/global/global.php" method="POST" class="edit-form">
                    <input type="hidden" name="chassi_id" value="<?= $item['chassi_id'] ?>">
                    <div class="form-group"><label>Descrição do Chassi:</label><input type="text" name="chassi_desc" value="<?= htmlspecialchars($item['chassi_desc']) ?>" required></div>
                    <div class="form-actions">
                        <a href="javascript:history.back()" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" name="editar_chassi" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    <?php } else { echo "<p>Chassi não encontrado.</p>"; }

// --- ROTA DE EDIÇÃO PARA MODELO ---
} elseif (isset($_GET['modelo_id'])) {
       
    $id = intval($_GET['modelo_id']);
    $modeloManager = new Modelo(null, null, null, null, $conexao);
    $item = $modeloManager->buscarModeloPorId($id);
    if ($item) {
        $marcaManager = new Marca(null, null, $conexao);
        $marcas = $marcaManager->listarMarca();

    ?>
        <div class="card">
            <div class="card-header"><h2>Editar Modelo</h2></div>
            <div class="card-body">
                <form action="../php/global/global.php" method="POST" class="edit-form">
                    <input type="hidden" name="modelo_id" value="<?= $item['modelo_id'] ?>">
                    <div class="form-group"><label>Descrição do Modelo:</label><input type="text" name="modelo_desc" value="<?= htmlspecialchars($item['modelo_desc']) ?>" required></div>
                    <div class="form-group"><label>Valor FIPE:</label>
                        <!-- CORREÇÃO: O campo visível (para o usuário) não tem 'name' -->
                        <input type="text" oninput="formatarMoeda(this)" value="<?= number_format($item['modelo_valor_fipe'], 2, ',', '.') ?>" required>
                        <!-- O valor real para o banco é enviado por este campo escondido -->
                        <input type="hidden" name="modelo_valor_fipe" id="valorBanco" value="<?= $item['modelo_valor_fipe'] ?>">
                    </div>
                    <div class="form-group">
                        <label>Marca:</label>
                        <select name="fk_Marca_id" required>
                            <?php foreach ($marcas as $marca): ?>
                                <option value="<?= $marca['marca_id'] ?>" <?= ($marca['marca_id'] == $item['fk_marca_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($marca['marca_desc']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-actions">
                        <a href="javascript:history.back()" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" name="editar_modelo" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    <?php } else { echo "<p>Modelo não encontrado.</p>"; }

// --- ROTA DE EDIÇÃO PARA ANÚNCIO ---
    } elseif (isset($_GET['anuncio_id'])) {
       
    $id = intval($_GET['anuncio_id']);
    $anuncioManager = new Anuncio(null, null, null, null, null, null, $conexao);
    $item = $anuncioManager->buscarAnuncioPorId($id);

    // Proteção: Apenas o dono do anúncio ou um admin pode editar.
    if ($item) {
        $id_logado = getUsuarioIdLogado();
        if (!eAdmin() && $id_logado !== $item['fk_usuario_id']) {
            echo "<h1>Acesso Negado</h1><p>Você não tem permissão para editar este anúncio.</p>";
            exit();
        }
    }

    if ($item) {
        // Instancia todos os managers
        $veiculoManager = new Veiculo(null, null, null, null, null, null, null, null, $conexao);
        $modeloManager = new Modelo(null, null, null, null, $conexao);
        $marcaManager = new Marca(null, null, $conexao);
        $corManager = new Cor(null, null, $conexao);
        $chassiManager = new Chassi(null, null, $conexao);
        $combustivelManager = new Combustivel(null, null, $conexao);
        $imagemManager = new Foto(null, null, null, $conexao);
        
        // Busca os dados
        $fotos = $imagemManager->listarImagemPorIdDeAnuncio($item['anuncio_id']);
        
        // CORREÇÃO: Estava buscando veículo pelo ID do anúncio
        $veiculos = $veiculoManager->buscarVeiculoPorId($item['fk_veiculo_id']); 
        
        $modelos = $modeloManager->listarModelo();
        $marcas = $marcaManager->listarMarca();
        $cores = $corManager->listarCor();
        $chassis = $chassiManager->listarChassi();
        $combustiveis = $combustivelManager->listarCombustivel();
        $opcoes_status = $anuncioManager->buscarOpcoesEnum($conexao, 'anuncio_status');

        // Prepara o array de modelos para o JavaScript (para o filter-functions.php)
        $todosModelos = $modeloManager->listarModelo();
        $modelosAgrupados = [];
        foreach ($todosModelos as $modelo) {
            $modelosAgrupados[$modelo['fk_marca_id']][] = [
                'id' => $modelo['modelo_id'],
                'desc' => $modelo['modelo_desc']
                // 'ano' foi removido do JS, então não é necessário aqui
            ];
        }
?>

<script>
    const modelosPorMarca = <?= json_encode($modelosAgrupados) ?>;
</script>
        
        <div class="card">
            <div class="card-header"><h2>Editar Anúncio</h2></div>
            <div class="card-body">
                <form action="../php/global/global.php" method="POST"  enctype="multipart/form-data" class="edit-form" onsubmit="validarFormAnuncio(event)">
            
                <input type="hidden" name="anuncio_id" value="<?= $item['anuncio_id'] ?>">
                <input type="hidden" name="veiculo_id" value="<?= $item['fk_veiculo_id'] ?>">
                <input type="hidden" name="usuario_id" value="<?= $item['fk_usuario_id'] ?>">
                
                <p>Imagens Atuais:</p>
                <div>
                    <?php foreach ($fotos as $foto): ?>
                        <img src="../<?= htmlspecialchars(ltrim($foto['imagem_url'], 'src/')) ?>" alt="Foto" style="width: 100px; height: auto; margin-right: 10px;">
                    <?php endforeach; ?>
                </div>
                <div class="form-group">
                    <label>Substituir/Adicionar Imagens (Novas imagens irão apagar as antigas):</label>
                    <input type="file" name="img[]" multiple>
                </div>

                <!-- SUBSTITUIÇÃO DO INCLUDE: Campos de Marca e Modelo diretamente aqui -->
                <div class="filter-row">
                    <div class="form-group">
                        <label for="marcaSelect">Marca</label>
                        <div class="custom-select-wrapper">
                            <select name="fk_marca_id" id="marcaSelect">
                                <option value="">Selecione</option>
                                <?php foreach ($marcas as $marca): ?>
                                    <option value="<?= $marca['marca_id'] ?>"><?= htmlspecialchars($marca['marca_desc']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modeloSelect">Modelo</label>
                        <div class="custom-select-wrapper">
                            <select name="fk_modelo_id" id="modeloSelect">
                                <option value="">Selecione a marca primeiro</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Pega os valores do PHP
                        const marcaFiltrada = <?= json_encode($veiculos['fk_marca_id'] ?? null) ?>;
                        const modeloFiltrado = <?= json_encode($veiculos['fk_modelo_id'] ?? null) ?>;
                        
                        // Se temos uma marca para pré-selecionar...
                        if (marcaFiltrada) {
                            const marcaSelect = document.getElementById('marcaSelect');
                            if (marcaSelect) {
                                // 1. Seleciona a marca correta
                                marcaSelect.value = marcaFiltrada;

                                // 2. Chama a função para carregar os modelos DIRETAMENTE
                                carregarModelos(); 

                                // 3. Seleciona o modelo correto na lista que acabou de ser carregada
                                const modeloSelect = document.getElementById('modeloSelect');
                                if (modeloSelect && modeloFiltrado) {
                                    modeloSelect.value = modeloFiltrado;
                                }
                            }
                        }
                    });
                </script>

                <div class="form-group">
                    <label for="veiculo_ano">Ano:</label>
                    <input type="text" id="veiculo_ano" name="veiculo_ano" pattern="\d{4}" maxlength="4" required placeholder="Ano" value="<?= $veiculos['veiculo_ano'] ?>">
                </div>

                <div class="form-group">
                    <label>Chassi:</label>
                    <select name="fk_chassi_id">
                        <?php foreach ($chassis as $chassi): ?>
                            <option value="<?= $chassi['chassi_id'] ?>" <?= ($chassi['chassi_id'] == $veiculos['fk_Chassi_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($chassi['chassi_desc']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Cor:</label>
                    <select name="fk_cor_id">
                    <?php foreach ($cores as $cor): ?>
                        <option value="<?= $cor['cor_id'] ?>" <?= isset($veiculos) && $cor['cor_id'] == $veiculos['fk_Cor_id'] ? 'selected' : '' ?>><?= htmlspecialchars($cor['cor_desc']) ?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Combustível:</label>
                    <select name="fk_combustivel_id">
                    <?php foreach ($combustiveis as $comb): ?>
                        <option value="<?= $comb['comb_id'] ?>" <?= isset($veiculos) && $comb['comb_id'] == $veiculos['fk_combustivel_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($comb['comb_desc']) ?>
                    </option>
                    <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status:</label>
                    <select name="anuncio_status" required>
                        <?php foreach ($opcoes_status as $status): ?>
                        <option value="<?= htmlspecialchars($status) ?>" <?= ($status == $item['anuncio_status']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars(ucfirst($status)) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group"><label>Quilometragem:</label><input type="number" name="veiculo_quilometragem" required value="<?= $veiculos['veiculo_quilometragem'] ?>"></div>
                <div class="form-group"><label>Versão:</label><input type="text" name="veiculo_versao" required value="<?= $veiculos['veiculo_versao'] ?>"></div>
                <div class="form-group"><label>Sobre Este Veiculo</label><textarea name="anuncio_desc" rows="4"><?= $item['anuncio_desc'] ?></textarea></div>
                <div class="form-group"><label>Preço:</label><input type="number" name="anuncio_valor" step="0.01" required value="<?= $item['anuncio_valor'] ?>"></div>

                <div class="form-actions">
                    <!-- BALÃO DE AVISO (inicialmente oculto) -->
                    <div id="form-feedback-popup" class="feedback-popup"></div>

                    <a href="javascript:history.back()" class="btn btn-secondary">Cancelar</a>
                    <input type="submit" value="Salvar Alterações" name="editar_anuncio" class="btn btn-primary">
                </div>
                </form>
            </div>
        </div>
            
    <?php } else { echo "<p>Anúncio não encontrado.</p>"; }


// --- CASO NENHUM ITEM SEJA SELECIONADO ---
} else {
    echo "<div class='card'><div class='card-body' style='text-align: center;'><h2>Nenhum item selecionado</h2><p>Por favor, selecione um item para editar a partir da página anterior.</p></div></div>";
}
?>

</div>
<script src="../JS/js-functions.js"></script>
<?php
include '../components/footer.php';
?>
</body>
</html>