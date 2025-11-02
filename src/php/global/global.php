<?php

include_once '../../config/env/imports.php';

// --- Bloco criar_conta ---
if (isset($_POST['criar_conta'])) {
    $usuario_nome = $_POST['usuario_nome'];
    $usuario_senha = $_POST['usuario_senha'];
    $usuario_email = $_POST['usuario_email'];
    $usuario_telefone = $_POST['usuario_telefone'];
    $usuario_endereco = $_POST['usuario_endereco'];
    $doc_cpf_cnpj = $_POST['doc_cpf_cnpj'];
    
    $doc_formatado = formatarDocumento($doc_cpf_cnpj);
    
    // O 8º parâmetro (nivel_de_acesso) estava vazio. 
    // Se o padrão no banco não for 'USUARIO', isso pode falhar.
    $usuario = new Usuario("", $usuario_nome, $usuario_email, $usuario_senha, $usuario_endereco, $usuario_telefone, $doc_formatado, "", $conexao);
    $usuario->insereUsuario();

// --- Bloco deletar_usuario ---
// Use 'else if' para evitar processamento desnecessário
} else if (isset($_POST['deletar_usuario'])) { 
    
    // ERRO CORRIGIDO: $usuario_id não estava definido.
    // Você DEVE pegar o ID do formulário que enviou a requisição.
    $usuario_id_para_deletar = $_POST['usuario_id']; // Supondo que o form envie 'usuario_id'

    $usu = new Usuario($usuario_id_para_deletar, "", "", "", "", "", "", "", $conexao);
    $usu->deletarUsuario();

// --- Bloco enviar_informacoes ---
} if (isset($_POST['criar_cor'])) {
    $cor_desc = $_POST['cor_desc'];
    $cor = new Cor("", $cor_desc, $conexao);
    $cor->insereCor();
}else if (isset($_POST['deletar_cor'])) { 
    
    // ERRO CORRIGIDO: $usuario_id não estava definido.
    // Você DEVE pegar o ID do formulário que enviou a requisição.
    $cor_id = $_POST['cor_id']; // Supondo que o form envie 'cor_id'
    $cr = new Cor(
        $cor_id, 
        "", 
        $conexao
    );
    $cr->deletarCor();

}else if (isset($_POST['criar_marca_modelo'])) {
    $marca_desc = $_POST['marca_desc'];
    $modelo_desc = $_POST['modelo_desc'];
    $modelo_valor_fipe = $_POST['modelo_valor_fipe'];

    // 1. Criar e inserir a Marca
    $marca = new Marca("", $marca_desc, $conexao);
    $marca->insereMarca();
    $marca_id_gerado = $conexao->insert_id;  // Pega o ID gerado da marca

    // 2. Criar e inserir o Modelo com o fk da Marca gerada
    $modelo = new Modelo(
        "",
        $modelo_desc,
        $modelo_valor_fipe,
        $marca_id_gerado,
        $conexao
    );
    $modelo->insereModelo();

    // Opcional: você pode retornar os IDs ou fazer eco se quiser
    echo "Marca ID: $marca_id_gerado | Modelo inserido com sucesso.";
}
else if (isset($_POST['deletar_marca'])) { 
    
    // ERRO CORRIGIDO: $usuario_id não estava definido.
    // Você DEVE pegar o ID do formulário que enviou a requisição.
    $marca_id = $_POST['marca_id']; // Supondo que o form envie 'marca_id'
    $mc = new Marca($marca_id, "", $conexao);
    $mc->deletarMarca();


}else if (isset($_POST['criar_modelo'])) {
   
}else if (isset($_POST['deletar_modelo'])) { 
    
    // ERRO CORRIGIDO: $usuario_id não estava definido.
    // Você DEVE pegar o ID do formulário que enviou a requisição.
    $modelo_id = $_POST['modelo_id']; // Supondo que o form envie 'modelo_id'
    $mc = new Modelo(
        $modelo_id,
        "",
        "",
        "",
        $conexao);
    $mc->deletarModelo();


}
else if (isset($_POST['criar_chassi'])) {
    $chassi_desc = $_POST['chassi_desc'];
    $chassi = new Chassi(
        "",
        $chassi_desc,
        $conexao);
    $chassi->insereChassi();
}else if (isset($_POST['deletar_chassi'])) { 
    
    // ERRO CORRIGIDO: $usuario_id não estava definido.
    // Você DEVE pegar o ID do formulário que enviou a requisição.
    $chassi_id = $_POST['chassi_id']; // Supondo que o form envie 'chassi_id'
    $ch = new Chassi(
        $chassi_id,
        "",
         $conexao
    );
    $ch->deletarChassi();

}else if (isset($_POST['criar_combustivel'])) {
    $comb_desc = $_POST['comb_desc'];
    $combustivel = new Combustivel(
        "",
        $comb_desc,
        $conexao
    );
    $combustivel->insereCombustivel();
} else if (isset($_POST['deletar_combustivel'])) {
    
    // ERRO CORRIGIDO: $usuario_id não estava definido.
    // Você DEVE pegar o ID do formulário que enviou a requisição.
    $combustivel_id = $_POST['comb_id']; // Supondo que o form envie 'combustivel_id'
    $cb = new Combustivel(
        $combustivel_id,
        "",
        $conexao
    );
    $cb->deletarCombustivel();

} else if (isset($_POST['editar_usuario'])) {

    $usuario_id = $_POST['usuario_id'];
    $usuario_nome = $_POST['usuario_nome'];
    $usuario_senha = $_POST['usuario_senha']; // Cuidado: Salvar senha em texto puro é inseguro. Use password_hash()
    $usuario_email = $_POST['usuario_email'];
    $usuario_telefone = $_POST['usuario_telefone'];
    $usuario_endereco = $_POST['usuario_endereco'];
    $usuario_doc_cpf_cnpj = $_POST['usuario_doc_cpf_cnpj'];
    $usuario_nivel_de_acesso = $_POST['usuario_nivel_de_acesso'];

    $doc_formatado = formatarDocumento($usuario_doc_cpf_cnpj);
    echo $doc_formatado;

    $usuario = new Usuario($usuario_id, $usuario_nome, $usuario_email, $usuario_senha, $usuario_endereco, $usuario_telefone, $doc_formatado, $usuario_nivel_de_acesso, $conexao);
    $usuario->editarUsuario();

// --- Bloco editar_marca ---
} else if (isset($_POST['editar_marca'])) { // ERRO CORRIGIDO: Você tinha este bloco duplicado
    $marca_id = $_POST['marca_id'];
    $marca_desc = $_POST['marca_desc'];
    
    $mrc = new Marca($marca_id, $marca_desc, $conexao);
    $mrc->editarMarca();

// --- Bloco editar_cor ---
} else if (isset($_POST['editar_cor'])) {
    $cor_id = $_POST['cor_id'];
    $cor_desc = $_POST['cor_desc'];

    $cr = new Cor($cor_id, $cor_desc, $conexao);
    $cr->editarCor();

// --- Bloco editar_combustivel ---
} else if (isset($_POST['editar_combustivel'])) {
    $comb_id = $_POST['comb_id'];
    $comb_desc = $_POST['comb_desc'];

    $cb = new Combustivel($comb_id, $comb_desc, $conexao);
    $cb->editarCombustivel();

// --- Bloco editar_chassi ---
} else if (isset($_POST['editar_chassi'])) {
    $chassi_id = $_POST['chassi_id'];
    $chassi_desc = $_POST['chassi_desc'];

    $ch = new Chassi($chassi_id, $chassi_desc, $conexao);
    $ch->editarChassi();

// --- Bloco editar_veiculo ---
} else if (isset($_POST['editar_veiculo'])) {
    // ... seu código para editar veículo ...
    // (A lógica de $mdlAno->insereModelo() aqui parece estranha, 
    //  você está criando um novo modelo ao invés de editar?)
    $veiculo_id = $_POST['veiculo_id'];
    $fk_marca_id = $_POST['fk_Marca_id'];
    $fk_modelo_id = $_POST['fk_Modelo_id']; 
    $fk_cor_id = $_POST['fk_cor_id'];
    $fk_chassi_id = $_POST['fk_chassi_id'];
    $fk_combustivel_id = $_POST['fk_combustivel_id'];
    $veiculo_versao = $_POST['veiculo_versao'];
    $veiculo_quilometragem = $_POST['veiculo_quilometragem'];
    $veiculo_ano = $_POST['veiculo_ano'];
    $modelo_desc = $_POST['modelo_desc'];

    $vcl = new Veiculo($veiculo_id, $veiculo_quilometragem, $veiculo_versao, $veiculo_ano, $fk_chassi_id, $fk_combustivel_id, $fk_cor_id, $fk_modelo_id, $conexao);
    $vcl->editarVeiculo();
    
    // Isso está criando um NOVO modelo toda vez que você EDITA um veículo. 
    // Tem certeza que é isso que quer?
    $mdlAno = new Modelo("",
    $modelo_desc,
    "",
    $fk_marca_id,
    $conexao);
    $mdlAno->insereModelo();

// --- Bloco criar_anuncio (O PRINCIPAL) ---
}else if (isset($_POST['criar_anuncio'])) {
    try {
        echo "Chegou aqui<br>";

        // 1. OBTER DADOS DO FORMULÁRIO E SESSÃO
        $fk_usuario_id         = 1; // TODO: pegar usuário logado
        $fk_modelo_id          = $_POST['fk_modelo_id'];
        $fk_chassi_id          = $_POST['fk_chassi_id'];
        $fk_cor_id             = $_POST['fk_cor_id'];
        $fk_combustivel_id     = $_POST['fk_combustivel_id'];
        $veiculo_quilometragem = $_POST['veiculo_quilometragem'];
        $veiculo_versao        = $_POST['veiculo_versao'];
        $anuncio_desc          = $_POST['anuncio_desc'];
        $anuncio_valor         = $_POST['anuncio_valor'];
        $veiculo_ano           = $_POST['veiculo_ano'] ?? null;

        // 2. PROCESSAR UPLOAD DA IMAGEM
        $caminhoFinal = null;
        if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
            $nomeOriginal = $_FILES['img']['name'];
            $temporario   = $_FILES['img']['tmp_name'];
            $pasta        = "../../uploads/";
            $nomeUnico    = uniqid() . "_" . basename($nomeOriginal);
            $caminhoFinal = $pasta . $nomeUnico;

            if (!move_uploaded_file($temporario, $caminhoFinal)) {
                throw new Exception("Erro ao salvar a imagem.");
            }
        }

        // 3. CRIAR E INSERIR O VEÍCULO
        $veiculo = new Veiculo(
            "", // veiculo_id (auto_increment)
            $veiculo_quilometragem,
            $veiculo_versao,
            $fk_chassi_id,
            $fk_combustivel_id,
            $fk_cor_id,
            $fk_modelo_id,
            $veiculo_ano,
            $conexao
        );

        $veiculo->insereVeiculo();

        // 4. PEGAR O ID DO VEÍCULO INSERIDO
        $veiculo_id_gerado = $conexao->insert_id;
        if (!$veiculo_id_gerado) {
            throw new Exception("Falha ao obter ID do veículo inserido.");
        }

        echo "ID do Veículo gerado: $veiculo_id_gerado<br>";

        // 5. CRIAR E INSERIR O ANÚNCIO
        $anun = new Anuncio(
            "", // anuncio_id (auto_increment)
            $anuncio_desc,
            $fk_usuario_id,
            $veiculo_id_gerado,
            $anuncio_valor,
            $conexao
        );

        $anun->insereAnuncio();

        // 6. PEGAR O ID DO ANÚNCIO INSERIDO
        $anuncio_id_gerado = $conexao->insert_id;
        if (!$anuncio_id_gerado) {
            throw new Exception("Falha ao obter ID do anúncio inserido.");
        }

        echo "Anúncio ID $anuncio_id_gerado criado com sucesso para o Veículo ID $veiculo_id_gerado!<br>";

        // 7. SALVAR A IMAGEM (SE ENVIADA)
        if ($caminhoFinal) {
            $imagem = new Foto(
                "",
                $caminhoFinal,
                $anuncio_id_gerado,
                $conexao
            );
            $imagem->insereImagem();
        }

    } catch (Exception $e) {
        // Em caso de erro, desfaz tudo
        $conexao->rollback();
        echo "Erro: " . $e->getMessage();
    }
}


?>