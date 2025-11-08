<?php 


function salvarImagens($anuncio_id, $arquivos, $conexao): void{
    // Se estamos editando, primeiro removemos as imagens antigas.
    if (isset($_POST['editar_anuncio'])) {
        // Instancia a classe Foto apenas para usar o método de exclusão.
        $imagemManager = new Foto(
            null,
            null,
            $anuncio_id,
            $conexao
        );
        $imagemManager->deletarImagensPorAnuncioId();
    }


    $caminhoFinal = null;
    for ($i = 0; $i < count($arquivos['name']); $i++) {
        $nomeArquivo = $arquivos['name'][$i];
            $tipo = $arquivos['type'][$i];
            $tmpName = $arquivos['tmp_name'][$i];
            $erro = $arquivos['error'][$i];
            $tamanho = $arquivos['size'][$i];

            // Caminho no servidor para mover o arquivo (relativo a este script)
            $pastaServidor = "../../uploads/";
            // Caminho que será salvo no banco de dados (relativo à raiz do site)
            $caminhoBanco = "src/uploads/" . basename($nomeArquivo);

            if ($erro === UPLOAD_ERR_OK) {
                // Defina o caminho final onde quer salvar o arquivo
                $caminhoFinalServidor = $pastaServidor . basename($nomeArquivo);
                
                // Após a verificação, sempre inserimos a nova imagem.
                // Isso funciona tanto para 'criar_anuncio' quanto para 'editar_anuncio',
                // pois na edição, as antigas já foram removidas.
                $imagem = new Foto(
                    "", // imagem_id é auto_increment
                    $caminhoBanco, // Salva o caminho correto no banco
                    $anuncio_id,
                    $conexao
                );
                $imagem->insereImagem();

                // Mova o arquivo temporário para o caminho final
                if (!move_uploaded_file($tmpName, $caminhoFinalServidor)) {
                    throw new Exception("Erro ao salvar a imagem: $nomeArquivo");
                }
            } else {
                throw new Exception("Erro no upload do arquivo: $nomeArquivo");
            }
        } 

    }


?>