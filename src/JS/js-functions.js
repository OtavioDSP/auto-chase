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
