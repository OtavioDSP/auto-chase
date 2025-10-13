
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
        $model = new Modelo($modelo_id, $modelo_desc, $modelo_ano, $modelo_fipe, $fk_marca_id, $conexao);
        $mrc = new Marca($marca_id, $marca_desc, $conexao);
        $cr = new Cor($cor_id, $cor_desc, $conexao);
        $chss = new Chassi($chassi_id, $chassi_desc, $conexao);
        $cmbt= new Combustivel($comb_id, $comb_desc, $conexao);
        
        $modelos = $modeloManager->listarModelos();
        $marcas = $marcaManager->listarMarcas();
        $cores = $corManager->listarCores();
        $chassis = $chassiManager->listarChassis();
        $combustiveis = $combustivelManager->listarCombustiveis();


    ?>


         <!--
        $veiculo_id,
        $veiculo_quilometragem,
        $veiculo_versao,
        $fk_chassi_id,
        $fk_combustivel_id,
        $fk_cor_id,
        $fk_modelo_id,
        $conexao -->




       
                <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Anúncio</title>
</head>
<body>
    <h2>Criar novo anúncio</h2>

    <form action="../routes/salvar_anuncio.php" method="POST">
        <label>Modelo:</label>
        <select name="fk_modelo_id">
            <?php foreach ($modelos as $modelo): ?>
                <option value="<?php echo $modelo['modelo_id']; ?>">
                    <?php echo $modelo['modelo_desc']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>

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
                <option value="<?php echo $comb['combustivel_id']; ?>">
                    <?php echo $comb['combustivel_desc']; ?>
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
</body>
</html>
