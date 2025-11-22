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


function formatarMoeda(input) {
    let valor = input.value.replace(/\D/g, '');
    valor = (valor/100).toFixed(2) + '';
    let valorParaBanco = valor; // Salva o formato numérico (ex: 45000.00)
    valor = valor.replace('.', ',');
    valor = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    input.value = valor; // Atualiza o campo visível (ex: 45.000,00)
    input.parentNode.querySelector('#valorBanco').value = valorParaBanco; // Atualiza o campo escondido
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
   VALIDAÇÃO DE FORMULÁRIO (MARCA/MODELO)
   ============================================== */
function validarFormAnuncio(event) {
    // Pega os elementos do formulário
    const marcaSelect = document.getElementById('marcaSelect');
    const modeloSelect = document.getElementById('modeloSelect');
    const feedbackPopup = document.getElementById('form-feedback-popup');

    // Função auxiliar para mostrar o aviso
    const mostrarAviso = (mensagem) => {
        if (feedbackPopup) {
            feedbackPopup.textContent = mensagem;
            feedbackPopup.classList.add('visible', 'status-error');
            // Esconde o aviso após 4 segundos
            setTimeout(() => {
                feedbackPopup.classList.remove('visible');
            }, 4000);
        }
        event.preventDefault(); // Impede o envio do formulário
    };

    // Verifica se o campo de MARCA existe e está vazio
    if (marcaSelect && marcaSelect.value === "") {
        mostrarAviso("Por favor, selecione uma Marca.");
    }
    // Verifica se o campo de MODELO existe e está vazio
    else if (modeloSelect && modeloSelect.value === "") {
        mostrarAviso("Por favor, selecione um Modelo.");
    }
}


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

/* ==============================================
   Lógica do Lightbox Modal para a página card.php
   ============================================== */

let slideIndex = 1;

// Função para abrir o lightbox
function openLightbox(n) {
    const modal = document.getElementById('lightbox-modal');
    if (!modal) return; // Só executa se o modal existir na página

    modal.style.display = "flex"; // Usa flex para centralizar
    
    // Cria as miniaturas dinamicamente
    const thumbnailContainer = document.getElementById('lightbox-thumbnail-container');
    thumbnailContainer.innerHTML = ''; // Limpa antes de adicionar
    images.forEach((imgSrc, index) => {
        const thumb = document.createElement('img');
        thumb.src = imgSrc;
        thumb.className = 'lightbox-thumbnail';
        thumb.onclick = () => currentSlide(index + 1);
        thumbnailContainer.appendChild(thumb);
    });

    showSlides(slideIndex = n + 1);
}

// Função para fechar o lightbox
function closeLightbox() {
    const modal = document.getElementById('lightbox-modal');
    if (modal) {
        modal.style.display = "none";
    }
}

// Adiciona a funcionalidade de fechar o lightbox com a tecla ESC
document.addEventListener('keydown', function(event) {
    const modal = document.getElementById('lightbox-modal');
    // Verifica se o modal está visível e se a tecla pressionada foi a Escape
    if (modal && modal.style.display === "flex" && event.key === "Escape") {
        closeLightbox();
    }
});


// Navegação: Próximo/Anterior
function plusSlides(n) {
    showSlides(slideIndex += n);
}

// Navegação: Miniaturas
function currentSlide(n) {
    showSlides(slideIndex = n);
}

// Função principal que mostra o slide
function showSlides(n) {
    const modal = document.getElementById('lightbox-modal');
    if (!modal) return;

    const mainImage = document.getElementById("lightbox-image");
    const captionText = document.getElementById("lightbox-caption");
    const thumbnails = document.getElementsByClassName("lightbox-thumbnail");

    if (n > images.length) { slideIndex = 1 }
    if (n < 1) { slideIndex = images.length }

    // Mostra a imagem principal
    mainImage.src = images[slideIndex - 1];

    // Atualiza a legenda (ex: "Imagem 2 de 5")
    captionText.innerHTML = `Imagem ${slideIndex} de ${images.length}`;

    // Remove a classe 'active' de todas as miniaturas
    for (let i = 0; i < thumbnails.length; i++) {
        thumbnails[i].className = thumbnails[i].className.replace(" active", "");
    }

    // Adiciona a classe 'active' na miniatura correspondente
    thumbnails[slideIndex - 1].className += " active";
}

/* ==============================================
   Lógica para mostrar/ocultar telefone na página card.php
   ============================================== */
document.addEventListener('DOMContentLoaded', function() {
    const btnContato = document.getElementById('btn-contato');
    const sellerNameLine = document.getElementById('seller-name-line');

    if (btnContato && sellerNameLine) {
        btnContato.addEventListener('click', function() {
            const telefone = this.getAttribute('data-telefone');
            const phoneSpan = document.getElementById('seller-phone-span');

            if (phoneSpan) {
                // Se o telefone já está visível, remove-o
                phoneSpan.remove();
                this.textContent = 'Entrar em contato';
            } else {
                // Se o telefone não está visível, cria e adiciona
                if (telefone) {
                    const spanTelefone = document.createElement('span');
                    spanTelefone.id = 'seller-phone-span'; // ID para encontrar e remover depois
                    spanTelefone.innerHTML = ` <span style="margin-left: 30px;"><strong>Telefone:</strong> ${telefone}</span>`;
                    sellerNameLine.appendChild(spanTelefone);

                    this.textContent = 'Ocultar contato';
                }
            }
        });
    }
});
