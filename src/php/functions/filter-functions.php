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


<div class="filter-group">
    <label for="marcaSelect">Marca:</label>
    <select name="fk_marca_id" id="marcaSelect" required>
        <option value="">Selecione uma marca</option>
        <?php foreach ($marcas as $marca): ?>
            <option value="<?= $marca['marca_id'] ?>" <?= ($marca['marca_id'] == ($_GET['fk_marca_id'] ?? null)) ? 'selected' : '' ?>>
                <?= htmlspecialchars($marca['marca_desc']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<div class="filter-group">
    <label for="modeloSelect">Modelo:</label>
    <select name="fk_modelo_id" id="modeloSelect" required>
        <option value="">Selecione a marca primeiro</option>
    </select>
</div>