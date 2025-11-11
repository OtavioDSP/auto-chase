const inputValorVisivel = document.getElementById('valor-formatado');

function toggleSenha() {
    const campo = document.getElementById("senha");
    campo.type = (campo.type === "password") ? "text" : "password";
}

function verificarDocumento() {
    const input = document.getElementById('documento').value;
    const somenteNumeros = input.replace(/\D/g, '');
    const resultado = document.getElementById('resultado'); // <- aqui estava errado

    if (somenteNumeros.length === 11) {
        resultado.textContent = "É um CPF válido em tamanho.";
        resultado.style.color = "green";
    } 
    else if (somenteNumeros.length === 14) {
        resultado.textContent = "É um CNPJ válido em tamanho.";
        resultado.style.color = "green";
    } 
    else if (somenteNumeros.length === 0) {
        resultado.textContent = "Digite um CPF ou CNPJ.";
        resultado.style.color = "orange";
    }
    else {
        resultado.textContent = "Documento inválido! Deve ter 11 (CPF) ou 14 (CNPJ) dígitos.";
        resultado.style.color = "red";
    }
}


 function formatarMoeda(element) {
    // 1. Pega o valor atual do input e remove tudo que não for dígito.
    let valor = element.value.replace(/\D/g, '');

    // Se não houver nada, o valor será uma string vazia.
    if (valor === "") {
        element.value = "";
        return;
    }

    // 2. Converte o valor para número, tratando como centavos.
    // Ex: '12345' vira 123.45
    let valorNumerico = parseInt(valor) / 100;

    // 3. Usa a API Intl.NumberFormat para formatar no padrão brasileiro.
    // Ela adiciona o ponto de milhar e a vírgula decimal automaticamente.
    let valorFormatado = new Intl.NumberFormat('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(valorNumerico);
    
    // 4. Atualiza o valor do input com a string formatada.
    element.value = valorFormatado;
}
function carregarModelos() {
    const marcaSelect = document.getElementById("marcaSelect");
    const modeloSelect = document.getElementById("modeloSelect");
    const marcaId = marcaSelect.value;

    // Limpa os modelos anteriores
    modeloSelect.innerHTML = '<option value="">Selecione um modelo</option>';

    if (marcaId && modelosPorMarca[marcaId]) {
        const modelos = modelosPorMarca[marcaId];
        modelos.forEach(modelo => {
            const option = document.createElement("option");
            option.value = modelo.id;
            option.textContent = `${modelo.desc} - ${modelo.ano}`;
            modeloSelect.appendChild(option);
        });
    } else {
        modeloSelect.innerHTML = '<option value="">Nenhum modelo encontrado</option>';
    }
}
/* ==============================================
   FUNÇÃO DE MÁSCARA DE TELEFONE
   ============================================== */
   function maskTelefone(input) {
    // 1. Pega o valor, remove tudo que não for número
    let v = input.value.replace(/\D/g, '');
    
    // 2. Limita o total de números a 11
    v = v.substring(0, 11);

    // 3. Aplica a máscara (XX) XXXXX-XXXX
    // Adiciona (XX)
    v = v.replace(/^(\d{2})/, '($1) ');
    
    // Adiciona o hífen
    // O regex (\d{5}) pega os 5 primeiros dígitos após o ") "
    // e o (\d{1,4}) pega os últimos 4 dígitos
    v = v.replace(/(\d{5})(\d{1,4})$/, '$1-$2');
    
    // 4. Devolve o valor formatado para o input
    input.value = v;
}
/* ==============================================
   FUNÇÃO DE MÁSCARA E VERIFICAÇÃO DE DOCUMENTO
   (Substitui a antiga 'verificarDocumento')
   ============================================== */
   function maskAndVerifyDocumento(input) {
    // 1. Pega o elemento de resultado (que você já usa)
    const resultado = document.getElementById('resultado');

    // 2. Remove tudo que não for número
    let v = input.value.replace(/\D/g, '');
    let resultFormatado = "";

    // 3. Aplica a máscara (CPF ou CNPJ)
    if (v.length > 11) {
        // --- É um CNPJ (14 dígitos) ---
        v = v.substring(0, 14); // Limita em 14
        
        // Formato: XX.XXX.XXX/XXXX-XX
        resultFormatado = v.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, "$1.$2.$3/$4-$5");
    } else {
        // --- É um CPF (11 dígitos) ---
        v = v.substring(0, 11); // Limita em 11
        
        // Formato: XXX.XXX.XXX-XX
        resultFormatado = v.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, "$1.$2.$3-$4");
    }
    
    // 4. Devolve o valor formatado para o input
    input.value = resultFormatado;

    // 5. Atualiza o texto de feedback (a lógica que você já tinha)
    // (Note que 'somenteNumeros' agora é 'v')
    if (v.length === 11) {
        resultado.textContent = "CPF válido em tamanho.";
        resultado.style.color = "green";
    } else if (v.length === 14) {
        resultado.textContent = "CNPJ válido em tamanho.";
        resultado.style.color = "green";
    } else if (v.length === 0) {
        resultado.textContent = "Seu número de cadastro:"; // Seu texto original
        resultado.style.color = "orange"; // (Ou a cor que estava antes)
    } else {
        resultado.textContent = "Documento inválido! (Faltando dígitos).";
        resultado.style.color = "red";
    }
}