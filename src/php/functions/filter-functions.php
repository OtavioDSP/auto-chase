<?php
    // 1. Prepara o array de modelos para o JavaScript
    $modelosAgrupados = [];
    foreach ($todosModelos as $modelo) {
        $modelosAgrupados[$modelo['fk_marca_id']][] = [
            'id' => $modelo['modelo_id'],
            'desc' => $modelo['modelo_desc']
        ];
    }
?> 

<script>
    const modelosPorMarca = <?= json_encode($modelosAgrupados) ?>;
</script>

<label>Marca:</label>
<select name="fk_marca_id" id="marcaSelect"  required>
  <option value="">Selecione uma marca</option>
  <?php foreach ($marcas as $marca): ?>
    <option value="<?php echo $marca['marca_id']; ?>"><?php echo $marca['marca_desc']; ?></option>
  <?php endforeach; ?>
</select>
<br>

<label>Modelo:</label>
<select name="fk_modelo_id" id="modeloSelect" required>
  <option value="">Selecione a marca primeiro</option>
</select>
<br><br>