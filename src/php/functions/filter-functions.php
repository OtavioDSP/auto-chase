<?php
// --- Agrupar modelos por marca ---
$modelosAgrupados = [];
foreach ($todosModelos as $modelo) {
    $modelosAgrupados[$modelo['fk_marca_id']][] = $modelo;
}

// --- Detectar contexto: filtro ou edição ---
$marcaSelecionada = $filtro_marca ?? ($veiculos['fk_marca_id'] ?? null);
$modeloSelecionado = $filtro_modelo ?? ($veiculos['fk_modelo_id'] ?? null);
?>

<!-- SELECT DE MARCA -->
<select id="marcaSelect" name="fk_marca_id" class="form-control">
    <option value="">Selecione uma Marca</option>
    <?php foreach ($marcas as $marca): ?>
        <option value="<?= $marca['marca_id'] ?>"
            <?= ($marca['marca_id'] == $marcaSelecionada) ? 'selected' : '' ?>>
            <?= htmlspecialchars($marca['marca_desc']) ?>
        </option>
    <?php endforeach; ?>
</select>

<!-- SELECT DE MODELO -->
<select id="modeloSelect" name="fk_modelo_id" class="form-control">
    <option value="">Selecione um Modelo</option>
    <?php
    if (!empty($marcaSelecionada) && isset($modelosAgrupados[$marcaSelecionada])):
        foreach ($modelosAgrupados[$marcaSelecionada] as $modelo): ?>
            <option value="<?= $modelo['modelo_id'] ?>"
                <?= ($modelo['modelo_id'] == $modeloSelecionado) ? 'selected' : '' ?>>
                <?= htmlspecialchars($modelo['modelo_desc']) ?>
            </option>
        <?php endforeach;
    endif;
    ?>
</select>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modelosPorMarca = <?= json_encode($modelosAgrupados) ?>;
    const marcaSelect = document.getElementById('marcaSelect');
    const modeloSelect = document.getElementById('modeloSelect');

    function atualizarModelos() {
        const marcaId = marcaSelect.value;
        const modeloSelecionado = modeloSelect.dataset.selected || "";
        modeloSelect.innerHTML = '<option value="">Selecione um Modelo</option>';

        if (modelosPorMarca[marcaId]) {
            modelosPorMarca[marcaId].forEach(modelo => {
                const opt = document.createElement('option');
                opt.value = modelo.modelo_id;
                opt.textContent = modelo.modelo_desc;
                if (modelo.modelo_id == modeloSelecionado) opt.selected = true;
                modeloSelect.appendChild(opt);
            });
        }
    }

    // guarda o modelo selecionado, caso venha do PHP (edição)
    modeloSelect.dataset.selected = "<?= htmlspecialchars($modeloSelecionado ?? '') ?>";

    // atualiza se já houver marca selecionada (edição)
    if (marcaSelect.value) atualizarModelos();

    // atualiza quando o usuário mudar de marca (filtro)
    marcaSelect.addEventListener('change', atualizarModelos);
});
</script>
