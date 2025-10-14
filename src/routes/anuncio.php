<?php
include_once '../php/classes/class-veiculo.php';
include_once '../php/classes/class-anuncio.php';
include_once '../config/db/connect.php';
include_once '../php/classes/class-usuario.php';
include_once '../php/classes/class-modelo.php';
include_once '../php/classes/class-marca.php';
include_once '../php/classes/class-cor.php';
include_once '../php/classes/class-chassi.php';
include_once '../php/classes/class-combustivel.php';

$modeloManager = new Modelo(null, null, null, null, null, $conexao);
$marcaManager = new Marca(null, null, $conexao);
$corManager = new Cor(null, null, $conexao);
$chassiManager = new Chassi(null, null, $conexao);
$combustivelManager = new Combustivel(null, null, $conexao);

$modelos = $modeloManager->listarModelo();
$marcas = $marcaManager->listarMarca();
$cores = $corManager->listarCor();
$chassis = $chassiManager->listarChassi();
$combustiveis = $combustivelManager->listarCombustivel();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Criar Anúncio</title>
<script>
// Objeto que liga modelo -> marca
const marcasPorModelo = {
<?php foreach ($modelos as $modelo): ?>
    "<?php echo $modelo['modelo_id']; ?>": "<?php echo addslashes($modelo['marca_desc']); ?>"
<?php endforeach; ?>
};


</script>
</head>
<body>
<h2>Criar novo anúncio</h2>

<form action="../routes/salvar_anuncio.php" method="POST">
    <label>Modelo:</label>
    <select name="fk_modelo_id" onchange="atualizarMarca()">
        <option value="">Selecione um modelo</option>
        <?php foreach ($modelos as $modelo): ?>
            <option value="<?php echo $modelo['modelo_id'] ; ?>">
                <?php echo $modelo['modelo_desc'] ; echo  -  $modelo['modelo_ano']?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <label>Marca:</label>
    <span id="marca_nome" style="display:inline-block; font-weight:bold; margin-left:10px;">—</span>
    <br><br>

    <label>Chassi:</label>
    <select name="fk_chassi_id">
        <?php foreach ($chassis as $chassi): ?>
            <option value="<?php echo $chassi['chassi_id']; ?>">
                <?php echo $chassi['chassi_desc']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <label>Cor:</label>
    <select name="fk_cor_id">
        <?php foreach ($cores as $cor): ?>
            <option value="<?php echo $cor['cor_id']; ?>">
                <?php echo $cor['cor_desc']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <label>Combustível:</label>
    <select name="fk_combustivel_id">
        <?php foreach ($combustiveis as $comb): ?>
            <option value="<?php echo $comb['comb_id']; ?>">
                <?php echo $comb['comb_desc']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br>

    <label>Quilometragem:</label>
    <input type="number" name="veiculo_quilometragem" required><br>

    <label>Versão:</label>
    <input type="text" name="veiculo_versao" required><br>

    <label>Título do Anúncio:</label>
    <input type="text" name="anuncio_titulo" required><br>

    <label>Descrição:</label>
    <textarea name="anuncio_descricao" rows="4"></textarea><br>

    <label>Preço:</label>
    <input type="number" name="anuncio_preco" step="0.01" required><br>

    <input type="submit" value="Publicar Anúncio">
</form>

<script>
function atualizarMarca() {
    const modeloSelect = document.querySelector('select[name="fk_modelo_id"]');
    const marcaTexto = document.querySelector('#marca_nome');
    const modeloSelecionado = modeloSelect.value;
    marcaTexto.textContent = marcasPorModelo[modeloSelecionado] || '—';
}
    
</script>
</body>
</html>
