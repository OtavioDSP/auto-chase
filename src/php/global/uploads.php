<?php

echo "<pre>";
print_r($_FILES);
print_r($_POST);
echo "</pre>";
//exit();

if(isset($_FILES['img']) && $_FILES['img']['error'] == 0){


    $nomeOriginal = $_FILES['img']['name'];
    $temporario = $_FILES['img']['tmp_name'];
    $pasta = "../../uploads/";
    $nomeUnico = uniqid() . "_" . $nomeOriginal; // evita arquivos com o mesmo nome
    $caminhoFinal = $pasta . $nomeUnico;

}if (move_uploaded_file($temporario, $caminhoFinal)) {
    echo "Arquivo salvo em: " . $caminhoFinal;
} else {
    echo "Erro ao salvar a imagem.";
}




?>