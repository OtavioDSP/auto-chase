function toggleSenha() {
  const campo = document.getElementById("senha");
  campo.type = (campo.type === "password") ? "text" : "password";
}

function verificarDocumento() {
    const input = document.getElementById('documento').value;

    // Remove tudo que NÃO for número
    const somenteNumeros = input.replace(/\D/g, '');

    const resultado = document.getElementById('resultado');

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
