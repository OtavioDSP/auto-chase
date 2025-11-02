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

$modeloManager = new Modelo(
  null,
  null,
  null,
  null,
  $conexao
);
$marcaManager = new Marca(null,
  null,
  $conexao
);
$corManager = new Cor(
  null,
  null,
  $conexao
);
$chassiManager = new Chassi(
  null,
  null,
  $conexao
);
$combustivelManager = new Combustivel(
  null,
  null,
  $conexao
);

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
  <title>Criar Anúncio</title>
</head>
<body>
<h2>Criar novo anúncio</h2>




<form action="../php/global/global.php" method="POST"  enctype="multipart/form-data">
  <p>Imagem:</p>
  <input type="file" name="img[]" multiple>
  <br>
  <br>
  <br>
  <!-- Filtro Marca → Modelo -->
  <?php include '../php/functions/filter-functions.php'; ?>


  <label for="veiculo_ano">Ano:</label>
  <input type="text" id="veiculo_ano" name="veiculo_ano" pattern="\d{4}" maxlength="4" required placeholder="Ano">

  <label>Chassi:</label>
  <select name="fk_chassi_id">
    <?php foreach ($chassis as $chassi): ?>
      <option value="<?= $chassi['chassi_id'] ?>"><?= $chassi['chassi_desc'] ?></option>
    <?php endforeach; ?>
  </select>
  <br>

  <label>Cor:</label>
  <select name="fk_cor_id">
    <?php foreach ($cores as $cor): ?>
      <option value="<?= $cor['cor_id'] ?>"><?= $cor['cor_desc'] ?></option>
    <?php endforeach; ?>
  </select>
  <br>

  <label>Combustível:</label>
  <select name="fk_combustivel_id">
    <?php foreach ($combustiveis as $comb): ?>
      <option value="<?= $comb['comb_id'] ?>"><?= $comb['comb_desc'] ?></option>
    <?php endforeach; ?>
  </select>
  <br>

  <label>Quilometragem:</label>
  <input type="number" name="veiculo_quilometragem" required><br>

  <label>Versão:</label>
  <input type="text" name="veiculo_versao" required><br>

  

  <label>Sobre Este Veiculo</label>
  <textarea name="anuncio_desc" rows="4"></textarea><br>

  <label>Preço:</label>
  <input type="number" name="anuncio_valor" step="0.01" required><br>

  <input type="submit" value="Publicar Anúncio" name="criar_anuncio">
</form>

</body>

</html>
