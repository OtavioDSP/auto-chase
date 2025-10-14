<?php
// Este arquivo espera que você já tenha os arrays $marcas e $modelos definidos

// Agrupa os modelos por marca
$agrupados = [];
foreach ($modelos as $modelo) {
    $marca_id = $modelo['fk_marca_id'];
    $agrupados[$marca_id][] = [
        'id' => $modelo['modelo_id'],
        'desc' => $modelo['modelo_desc'],
        'ano' => $modelo['modelo_ano']
    ];
}
?>

<!-- Filtro de Marca -->
<label>Marca:</label>
<select name="fk_marca_id" id="marcaSelect" onchange="atualizarModelos()" required>
  <option value="">Selecione uma marca</option>
  <?php foreach ($marcas as $marca): ?>
    <option value="<?php echo $marca['marca_id']; ?>"><?php echo $marca['marca_desc']; ?></option>
  <?php endforeach; ?>
</select>
<br>

<!-- Filtro de Modelo -->
<label>Modelo:</label>
<select name="fk_modelo_id" id="modeloSelect" required>
  <option value="">Selecione a marca primeiro</option>
</select>
<br><br>
