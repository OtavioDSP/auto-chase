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
} else if (isset($_POST['enviar_informacoes'])) {
    
    $cor_desc = $_POST['cor_desc'];
    $marca_desc = $_POST['marca_desc'];
    $modelo_desc = $_POST['modelo_desc'];
    $modelo_ano = $_POST['modelo_ano'];
    $modelo_fipe = $_POST['modelo_fipe'];
    $chassi_desc = $_POST['chassi_desc'];
    $comb_desc = $_POST['comb_desc'];

    ECHO "ANO: $modelo_ano";

    // Insere a marca e pega o ID
    $marca = new Marca("", $marca_desc, $conexao);
    $marca->insereMarca(); // <-- Você tinha $marcaGerada = $marca->insereMarca();
    $marcaGerada = $conexao->insert_id;

    echo "MARCA GERADA:$marcaGerada";
    
    $cor = new Cor("",
    $cor_desc,
    $conexao);
    $modelo = new Modelo("", 
    $modelo_desc,
    $modelo_fipe,
    $marcaGerada,
    $conexao
    );
    
    $chassi = new Chassi("",
    $chassi_desc,
    $conexao);
    $combustivel = new Combustivel("",
    $comb_desc,
    $conexao
    );
    
    // Insere o restante
    $cor->insereCor();
    $modelo->insereModelo();
    $chassi->insereChassi();
    $combustivel->insereCombustivel();
    
// --- Bloco editar_modelo ---
} else if (isset($_POST['editar_modelo'])) {
    $modelo_id = $_POST['modelo_id'];
    $modelo_desc = $_POST['modelo_desc'];
    $modelo_ano = $_POST['modelo_ano'];
    $modelo_valor_fipe = $_POST['modelo_valor_fipe'];
    $fk_marca_id = $_POST['fk_marca_id'];

    $model = new Modelo($modelo_id,
    $modelo_desc,
    $modelo_valor_fipe,
    $fk_marca_id,
    $conexao);
    $model->editarModelo();

// --- Bloco editar_usuario ---
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
    $modelo_ano = $_POST['modelo_ano'];
    $modelo_desc = $_POST['modelo_desc'];

    $vcl = new Veiculo($veiculo_id, $veiculo_quilometragem, $veiculo_versao, $fk_chassi_id, $fk_combustivel_id, $fk_cor_id, $fk_modelo_id, $conexao);
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
} else if (isset($_POST['criar_anuncio'])) {

    echo "Chegou aqui";

    // 1. OBTER DADOS DO FORMULÁRIO E SESSÃO
    $fk_usuario_id = 1; // Lembre-se de trocar por getUsuarioIdLogado()
    $fk_modelo_id = $_POST['fk_modelo_id'];
    $fk_chassi_id = $_POST['fk_chassi_id'];
    $fk_cor_id = $_POST['fk_cor_id'];
    $fk_combustivel_id = $_POST['fk_combustivel_id'];
    $veiculo_quilometragem = $_POST['veiculo_quilometragem'];
    $veiculo_versao = $_POST['veiculo_versao'];
    $anuncio_desc = $_POST['anuncio_desc'];
    $anuncio_valor = $_POST['anuncio_valor'];

    
    // 2. PROCESSAR UPLOAD DA IMAGEM (LÓGICA CORRIGIDA)
    // A lógica do upload estava separada, o que causa erro se nenhum arquivo for enviado.
    $caminhoFinal = null; // Inicia a variável

    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {

        $nomeOriginal = $_FILES['img']['name'];
        $temporario = $_FILES['img']['tmp_name'];
        $pasta = "../../uploads/";
        $nomeUnico = uniqid() . "_" . $nomeOriginal; // evita arquivos com o mesmo nome
        $caminhoFinal = $pasta . $nomeUnico;

        // move_uploaded_file DEVE estar DENTRO do if
        if (move_uploaded_file($temporario, $caminhoFinal)) {
            echo "Arquivo salvo em: " . $caminhoFinal;
        } else {
            echo "Erro ao salvar a imagem.";
            $caminhoFinal = null; // Se falhar, não salva o caminho no banco
        }
    } else {
        echo "Nenhuma imagem foi enviada ou houve um erro.";
        // $caminhoFinal permanece null
    }
    
    // 3. CRIAR E INSERIR O VEÍCULO (PRIMEIRO)
    // O código estava tentando usar $veiculo e $anun ANTES de criá-los.
    // O construtor do Veiculo também estava errado (tinha fk_anuncio_id, baseado no SQL anterior).
    
    // Confirme que os parâmetros do construtor batem com sua classe Veiculo.php
    // Removi o $fk_anuncio_id que estava no seu código.


    $modelo = new Modelo(
    "",
    $modelo_desc,
    "",
    $fk_marca_id,
    $conexao
);





    $veiculo = new Veiculo(
    "", // veiculo_id (autoincrement)
    $veiculo_quilometragem,
    $veiculo_versao,
    $fk_chassi_id,
    $fk_combustivel_id,
    $fk_cor_id,
    $fk_modelo_id,
    $conexao
    );
    
    // Insere o veículo no banco
    $veiculo->insereVeiculo();
    
    // 4. PEGAR O ID DO VEÍCULO QUE ACABOU DE SER CRIADO
    $veiculo_id_gerado = $conexao->insert_id;
    
    echo "ID do Veículo gerado: $veiculo_id_gerado";

    // 5. CRIAR E INSERIR O ANÚNCIO (SEGUNDO)
    // Agora usamos o $veiculo_id_gerado
    
    // O seu construtor de Anuncio estava usando $fk_veiculo_id, que não existia.
    $anun = new Anuncio(
        "", // anuncio_id (autoincrement)
        $anuncio_desc,
        $fk_usuario_id,
        $veiculo_id_gerado, // <-- AQUI a correção de lógica
        $anuncio_valor,
        $conexao
    );
    
    // Insere o anúncio no banco
    $anun->insereAnuncio();
    
    // 6. PEGAR O ID DO ANÚNCIO (Opcional)
    $anuncio_id_gerado = $conexao->insert_id;

    // echo "Anúncio ID $anuncio_id_gerado criado com sucesso para o Veículo ID $veiculo_id_gerado!";

    // IMPORTANTE: Você precisa salvar a imagem!
    // O SQL que corrigimos tem uma tabela 'imagem' que espera o $anuncio_id_gerado e o $caminhoFinal
   
}

?>