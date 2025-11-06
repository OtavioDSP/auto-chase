<?php 


function formatarDocumento($doc) {
    // 1. Remove espaços extras do início e fim
    $doc = trim($doc);

    // 2. Verifica se está vazio
    if (empty($doc)) {
        echo "⚠️ O documento não pode estar vazio. Por favor, insira novamente.<br>";
        return null; 
    }

    // 3. Remove qualquer caractere que não seja número
    $doc = preg_replace('/\D/', '', $doc);

    // 4. Formata CPF (11 dígitos)
    if (strlen($doc) === 11) {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $doc);
    } 
    // 5. Formata CNPJ (14 dígitos)
    elseif (strlen($doc) === 14) {
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $doc);
    }

    // 6. Caso não seja CPF nem CNPJ
    echo "⚠️ Documento inválido! Insira um CPF (11 dígitos) ou CNPJ (14 dígitos).<br>";
    return null;
}




?>