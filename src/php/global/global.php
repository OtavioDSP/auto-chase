<?php

include_once '../../config/env/imports.php';
// Inclui o gerenciador de sessão para a função de login
include_once '../../config/env/logout.php';

// Roteador de Ações POST
// Este bloco verifica qual botão de submit foi pressionado e chama a função correspondente.

if (isset($_POST['login_usuario'])) {
    $email = $_POST['usuario_email'];
    $senha = $_POST['usuario_senha'];

    $usuarioManager = new Usuario(null, null, null, null, null, null, null, null, $conexao);
    $usuario = $usuarioManager->buscarUsuarioPorEmail($email);

    if ($usuario && password_verify($senha, $usuario['usuario_senha'])) {
        login($usuario); // Função de 'logout.php'
        header('Location: ../../../index.php?status=loginsuccess');
    } else {
        header('Location: ../../../login.php?status=loginfailed');
    }
    exit();

} else if (isset($_POST['logout_usuario'])) {
    logout(); // Função de 'logout.php'
    header('Location: ../../../login.php?status=logoutsuccess');
    exit();

} else if (isset($_POST['criar_conta'])) {
    $doc_formatado = formatarDocumento($_POST['doc_cpf_cnpj']);
    $email_novo_usuario = $_POST['usuario_email'];
    
    $usuario = new Usuario(
        null,
        $_POST['usuario_nome'],
        $_POST['usuario_email'],
        $_POST['usuario_senha'],
        $_POST['usuario_telefone'],
        $_POST['usuario_endereco'],
        $doc_formatado,
        null, // Nível de acesso usará o padrão do banco
        $conexao
    );
    $id_gerado = $usuario->insereUsuario();

    // Se o usuário foi criado com sucesso, faz o login automaticamente
    if ($id_gerado) {
        $usuarioManager = new Usuario(null, null, null, null, null, null, null, null, $conexao);
        $novo_usuario_info = $usuarioManager->buscarUsuarioPorEmail($email_novo_usuario);
        if ($novo_usuario_info) {
            login($novo_usuario_info); // Função de 'logout.php' para iniciar a sessão
            header('Location: ../../../index.php?status=registersuccess');
            exit();
        }
    }
    exit(); // Adicione esta linha para parar o script após o cadastro

} else if (isset($_POST['deletar_usuario'])) { 
    if (!eAdmin()) {
        header('Location: ../../../index.php?status=unauthorized');
        exit();
    }
    $usuario_id = $_POST['usuario_id'];
    $usu = new Usuario($usuario_id, null, null, null, null, null, null, null, $conexao);
    $usu->deletarUsuario('usuario_id');

} else if (isset($_POST['editar_usuario'])) {
    $doc_formatado = formatarDocumento($_POST['usuario_doc_cpf_cnpj']);
    
    // Um usuário normal só pode editar a si mesmo. Um admin pode editar qualquer um.
    $usuario_id_logado = getUsuarioIdLogado();
    if (!eAdmin() && $usuario_id_logado != $_POST['usuario_id']) {
        header('Location: ../../../index.php?status=unauthorized');
        exit();
    }

    // Define o nível de acesso apenas se o usuário for admin.
    // Se não for admin, o método editarUsuario() não tentará atualizar o campo.
    $nivel_de_acesso = null;
    if (eAdmin()) {
        $nivel_de_acesso = $_POST['usuario_nivel_de_acesso'];
    }

    // CORREÇÃO: $usuario_telefone e $usuario_endereco estavam na ordem errada
    $usuario = new Usuario(
        $_POST['usuario_id'],
        $_POST['usuario_nome'],
        $_POST['usuario_email'],
        $_POST['usuario_senha'], // A classe trata se a senha está vazia
        $_POST['usuario_telefone'], // 5. Telefone
        $_POST['usuario_endereco'], // 6. Endereço
        $doc_formatado,
        $nivel_de_acesso, // Passa o nível de acesso (ou null se não for admin)
        $conexao
    );
    $usuario->editarUsuario();

} else if (isset($_POST['criar_anuncio'])) {
    // Garante que o usuário está logado para criar um anúncio
    if (!estaLogado()) {
        header('Location: ../../../login.php?status=unauthorized');
        exit();
    }

    // 1. Criar e inserir o Veículo
    $veiculo = new Veiculo(
        null, // veiculo_id (auto_increment)
        $_POST['veiculo_quilometragem'],
        $_POST['veiculo_versao'],
        $_POST['fk_chassi_id'],
        $_POST['fk_combustivel_id'],
        $_POST['fk_cor_id'],
        $_POST['fk_modelo_id'],
        $_POST['veiculo_ano'],
        $conexao
    );
    $veiculo_id_gerado = $veiculo->insereVeiculo();
    if (!$veiculo_id_gerado) {
        throw new Exception("Falha ao obter ID do veículo inserido.");
    }

    // 2. Criar e inserir o Anúncio
    $anuncio = new Anuncio(
        null, // anuncio_id (auto_increment)
        $_POST['anuncio_desc'],
        getUsuarioIdLogado(), // Usa o ID do usuário da sessão
        $veiculo_id_gerado,
        $_POST['anuncio_valor'],
        null, // Status usará o padrão do banco
        $conexao
    );
    $anuncio_id_gerado = $anuncio->insereAnuncio();
    if (!$anuncio_id_gerado) {
        throw new Exception("Falha ao obter ID do anúncio inserido.");
    }

    // 3. Salvar as imagens
    if (isset($_FILES['img']) && $_FILES['img']['error'][0] !== UPLOAD_ERR_NO_FILE) {
        salvarImagens($anuncio_id_gerado, $_FILES['img'], $conexao);
    }

    echo "Anúncio ID $anuncio_id_gerado criado com sucesso para o Veículo ID $veiculo_id_gerado!";

} else if (isset($_POST['editar_anuncio'])) {
    if (!estaLogado()) {
        header('Location: ../../../login.php?status=unauthorized');
        exit();
    }

    // Busca o anúncio no banco para verificar o proprietário real
    $anuncio_id = $_POST['anuncio_id'];
    $anuncio_info = (new Anuncio($anuncio_id, null, null, null, null, null, $conexao))->buscarAnuncioPorId($anuncio_id);

    // Se o usuário não for admin E não for o dono do anúncio, nega o acesso.
    if (!eAdmin() && getUsuarioIdLogado() != $anuncio_info['fk_usuario_id']) {
        header('Location: ../../../index.php?status=unauthorized_edit');
        exit();
    }

    // 1. Atualizar Veículo
    $veiculo = new Veiculo(
        $_POST['veiculo_id'],
        $_POST['veiculo_quilometragem'],
        $_POST['veiculo_versao'],
        $_POST['fk_chassi_id'],
        $_POST['fk_combustivel_id'],
        $_POST['fk_cor_id'],
        $_POST['fk_modelo_id'], // Corrigido para usar o nome do campo do formulário de edição
        $_POST['veiculo_ano'],
        $conexao
    );
    $veiculo->editarVeiculo();

    // 2. Atualizar Anúncio
    $anuncio = new Anuncio(
        $_POST['anuncio_id'],
        $_POST['anuncio_desc'],
        $anuncio_info['fk_usuario_id'], // Usa o ID do dono original para manter a integridade
        $_POST['veiculo_id'],
        $_POST['anuncio_valor'],
        $_POST['anuncio_status'],
        $conexao
    );
    $anuncio->editarAnuncio();

    // 3. Atualizar Imagens (se novas imagens foram enviadas)
    if (isset($_FILES['img']) && $_FILES['img']['error'][0] !== UPLOAD_ERR_NO_FILE) {
        salvarImagens($_POST['anuncio_id'], $_FILES['img'], $conexao);
    }

} else if (isset($_POST['deletar_anuncio'])) {
    if (!estaLogado()) {
        header('Location: ../../../login.php?status=unauthorized');
        exit();
    }

    $anuncio_id = $_POST['anuncio_id'];
    $anuncio_info = (new Anuncio($anuncio_id, null, null, null, null, null, $conexao))->buscarAnuncioPorId($anuncio_id);

    // Se o usuário não for admin E não for o dono do anúncio, nega o acesso.
    if (!$anuncio_info || (!eAdmin() && getUsuarioIdLogado() != $anuncio_info['fk_usuario_id'])) {
        header('Location: ../../../index.php?status=unauthorized_delete');
        exit();
    }

    // Pega o ID do veículo ANTES de deletar o anúncio.
    $veiculo_id = $anuncio_info['fk_veiculo_id'] ?? null;

    // 1. Deletar Imagens
    $imgManager = new Foto(null, null, $anuncio_id, $conexao);
    $imgManager->deletarImagensPorAnuncioId();

    // 2. Deletar Anúncio
    $anuncioManager = new Anuncio($anuncio_id, null, null, null, null, null, $conexao);
    $anuncioManager->deletarAnuncio();

    // 3. Deletar Veículo (se o ID foi encontrado)
    if ($veiculo_id) {
        $veiculoManager = new Veiculo($veiculo_id, null, null, null, null, null, null, null, $conexao);
        $veiculoManager->deletarVeiculo();
    }

} else if (isset($_POST['criar_cor'])) {
    if (!eAdmin()) { exit("Acesso negado."); }
    $cor = new Cor(null, $_POST['cor_desc'], $conexao);
    $cor->insereCor();

} else if (isset($_POST['deletar_cor'])) {
    if (!eAdmin()) { exit("Acesso negado."); }
    $cr = new Cor($_POST['cor_id'], null, $conexao);
    $cr->deletarCor();

} else if (isset($_POST['editar_cor'])) {
    if (!eAdmin()) { exit("Acesso negado."); }
    $cr = new Cor($_POST['cor_id'], $_POST['cor_desc'], $conexao);
    $cr->editarCor();

} else if (isset($_POST['criar_marca_modelo'])) {
    if (!eAdmin()) { exit("Acesso negado."); }

    $marca_desc = $_POST['marca_desc'];
    $marcaManager = new Marca(null, null, $conexao);

    // Verifica se a marca já existe
    $marca_existente = $marcaManager->buscarMarcaPorDescricao($marca_desc);

    if ($marca_existente) {
        // Se existe, usa o ID dela
        $id_da_marca_para_o_modelo = $marca_existente['marca_id'];
    } else {
        // Se não existe, cria uma nova e pega o ID retornado
        $nova_marca = new Marca(null, $marca_desc, $conexao);
        $id_da_marca_para_o_modelo = $nova_marca->insereMarca();
    }

    $modelo = new Modelo(
        null,
        $_POST['modelo_desc'],
        $_POST['modelo_valor_fipe'],
        $id_da_marca_para_o_modelo, // Usa o ID correto (existente ou novo)
        $conexao
    );
    $modelo->insereModelo();

} else if (isset($_POST['deletar_marca'])) {
    if (!eAdmin()) { exit("Acesso negado."); }
    $mc = new Marca($_POST['marca_id'], null, $conexao);
    $mc->deletarMarca();

} else if (isset($_POST['editar_marca'])) {
    if (!eAdmin()) { exit("Acesso negado."); }
    $mrc = new Marca($_POST['marca_id'], $_POST['marca_desc'], $conexao);
    $mrc->editarMarca();

} else if (isset($_POST['criar_chassi'])) {
    if (!eAdmin()) { exit("Acesso negado."); }
    $chassi = new Chassi(null, $_POST['chassi_desc'], $conexao);
    $chassi->insereChassi();

} else if (isset($_POST['deletar_chassi'])) {
    if (!eAdmin()) { exit("Acesso negado."); }
    $ch = new Chassi($_POST['chassi_id'], null, $conexao);
    $ch->deletarChassi();

} else if (isset($_POST['editar_chassi'])) {
    if (!eAdmin()) { exit("Acesso negado."); }
    $ch = new Chassi($_POST['chassi_id'], $_POST['chassi_desc'], $conexao);
    $ch->editarChassi();

} else if (isset($_POST['criar_combustivel'])) {
    if (!eAdmin()) { exit("Acesso negado."); }
    $combustivel = new Combustivel(null, $_POST['comb_desc'], $conexao);
    $combustivel->insereCombustivel();

} else if (isset($_POST['deletar_combustivel'])) {
    if (!eAdmin()) { exit("Acesso negado."); }
    $cb = new Combustivel($_POST['comb_id'], null, $conexao);
    $cb->deletarCombustivel();

} else if (isset($_POST['editar_combustivel'])) {
    if (!eAdmin()) { exit("Acesso negado."); }
    $cb = new Combustivel($_POST['comb_id'], $_POST['comb_desc'], $conexao);
    $cb->editarCombustivel();

} else if (isset($_POST['editar_modelo'])) {
    if (!eAdmin()) { exit("Acesso negado."); }
    $modelo = new Modelo(
        $_POST['modelo_id'],
        $_POST['modelo_desc'],
        $_POST['modelo_valor_fipe'],
        $_POST['fk_Marca_id'],
        $conexao
    );
    $modelo->editarModelo();
} else if (isset($_POST['deletar_modelo'])) {
    if (!eAdmin()) { exit("Acesso negado."); }
    $modelo = new Modelo($_POST['modelo_id'], null, null, null, $conexao);
    $modelo->deletarModelo();
}

// Após a execução da ação, redireciona para a página inicial para evitar reenvio do formulário.
// Você pode comentar esta linha se preferir ver as mensagens de 'echo' das classes.
header('Location: ../../../index.php');
exit();

// CORREÇÃO: Havia um '}' extra aqui no final do arquivo
?>