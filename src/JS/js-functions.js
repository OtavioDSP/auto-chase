const inputValorVisivel = document.getElementById('valor-formatado');

function toggleSenha(inputId) {
    const campo = document.getElementById(inputId);
    campo.type = (campo.type === "password") ? "text" : "password";
}

/* ==============================================
   FUNÇÃO DE MÁSCARA E VERIFICAÇÃO DE DOCUMENTO
   ============================================== */
function maskAndVerifyDocumento(input) {
    // 1. Pega os elementos da janela de feedback
    const popup = document.getElementById('doc-feedback-popup');
    const textoFeedback = document.getElementById('feedback-text');

    // 2. Remove tudo que não for número
    let v = input.value.replace(/\D/g, '');
    let resultFormatado = "";

    // 3. Aplica a máscara (CPF ou CNPJ) dinamicamente
    if (v.length > 11) {
        // --- É um CNPJ ---
        v = v.substring(0, 14); // Limita em 14

        // Formato: XX.XXX.XXX/XXXX-XX
        resultFormatado = v.substring(0, 2);
        if (v.length > 2) resultFormatado += "." + v.substring(2, 5);
        if (v.length > 5) resultFormatado += "." + v.substring(5, 8);
        if (v.length > 8) resultFormatado += "/" + v.substring(8, 12);
        if (v.length > 12) resultFormatado += "-" + v.substring(12, 14);
    
    } else {
        // --- É um CPF ---
        v = v.substring(0, 11); // Limita em 11
        
        // Formato: XXX.XXX.XXX-XX
        resultFormatado = v.substring(0, 3);
        if (v.length > 3) resultFormatado += "." + v.substring(3, 6);
        if (v.length > 6) resultFormatado += "." + v.substring(6, 9);
        if (v.length > 9) resultFormatado += "-" + v.substring(9, 11);
    }
    
    // 4. Devolve o valor formatado para o input
    input.value = resultFormatado;

    // 5. Mostra a janela e atualiza o texto e a cor
    popup.classList.add('visible');
    popup.classList.remove('status-success', 'status-error', 'status-neutral'); // Limpa status antigos

    if (v.length === 11) {
        textoFeedback.textContent = "CPF válido em tamanho.";
        popup.classList.add('status-success');
    } else if (v.length === 14) {
        textoFeedback.textContent = "CNPJ válido em tamanho.";
        popup.classList.add('status-success');
    } else if (v.length === 0) {
        textoFeedback.textContent = "Digite seu CPF ou CNPJ para validação.";
        popup.classList.add('status-neutral');
    } else if (v.length > 0) {
        textoFeedback.textContent = "Documento inválido! Faltando dígitos.";
        popup.classList.add('status-error');
    } else {
        // Esconde o popup se o campo estiver vazio e não focado
        popup.classList.remove('visible');
    }
}


function formatarMoeda(element) {
    let valor = element.value.replace(/\D/g, '');
    if (valor === "") {
        element.value = "";
        return;
    }
    let valorNumerico = parseInt(valor) / 100;
    let valorFormatado = new Intl.NumberFormat('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(valorNumerico);
    element.value = valorFormatado;
}

function carregarModelos() {
    const marcaSelect = document.getElementById("marcaSelect");
    const modeloSelect = document.getElementById("modeloSelect");
    
    // Verifica se os elementos existem antes de continuar
    if (!marcaSelect || !modeloSelect) return; 

    const marcaId = marcaSelect.value;

    // Limpa os modelos anteriores
    modeloSelect.innerHTML = '<option value="">Selecione um modelo</option>';

    if (marcaId && modelosPorMarca[marcaId]) {
        const modelos = modelosPorMarca[marcaId];
        modelos.forEach(modelo => {
            const option = document.createElement("option");
            option.value = modelo.id;
            // CORREÇÃO: O array 'modelosPorMarca' (definido em filter-functions.php)
            // só tem 'id' e 'desc', não tem 'ano'.
            option.textContent = modelo.desc; 
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
    let v = input.value.replace(/\D/g, '');
    v = v.substring(0, 11);
    v = v.replace(/^(\d{2})/, '($1) ');
    v = v.replace(/(\d{5})(\d{1,4})$/, '$1-$2');
    input.value = v;
}

/* ==============================================
   EVENT LISTENER (O que faz o filtro funcionar)
   ============================================== */
document.addEventListener('DOMContentLoaded', function() {
    const marcaSelect = document.getElementById("marcaSelect");
    if (marcaSelect) {
        // Adiciona o gatilho para chamar 'carregarModelos'
        marcaSelect.addEventListener('change', carregarModelos);
    }
});

/* ==============================================
   LÓGICA DO CARROSSEL DE IMAGENS (PÁGINA card.php)
   ============================================== */
let currentImageIndex = 0;

// Função para mostrar uma imagem específica pelo índice
function showImage(index) {
    const mainImage = document.getElementById('main-image');
    const thumbnails = document.querySelectorAll('.thumbnail');

    // Proteção para caso não haja imagens
    if (!images || images.length === 0) return;

    // Garante que o índice seja válido
    if (index >= images.length) index = 0;
    if (index < 0) index = images.length - 1;

    // Atualiza a imagem principal
    mainImage.src = images[index];

    // Atualiza a classe 'active' nas miniaturas
    thumbnails.forEach(thumb => thumb.classList.remove('active'));
    if (thumbnails[index]) {
        thumbnails[index].classList.add('active');
    }

    currentImageIndex = index;
}

// Função para os botões "próximo" e "anterior"
function changeImage(direction) {
    showImage(currentImageIndex + direction);
}