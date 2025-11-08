<?php 


function salvarImagens($anuncio_id, $arquivos, $conexao): void{
    $caminhoFinal = null;
      for ($i = 0; $i < count($arquivos['name']); $i++) {
    $nomeArquivo = $arquivos['name'][$i];
            $tipo = $arquivos['type'][$i];
            $pasta        = "../../uploads/";
            $tmpName = $arquivos['tmp_name'][$i];
            $erro = $arquivos['error'][$i];
            $tamanho = $arquivos['size'][$i];

            if ($erro === UPLOAD_ERR_OK) {
                // Defina o caminho final onde quer salvar o arquivo
                $caminhoFinal = $pasta . basename($nomeArquivo);

                if ($caminhoFinal && isset($_POST['criar_anuncio'])) {
                        $imagem = new Foto(
                            "",
                            $caminhoFinal,
                            $anuncio_id,
                            $conexao
                        );
                        $imagem->insereImagem();
                }else if($caminhoFinal && isset($_POST['editar_anuncio'])) {
                   $imagem = new Foto(
                            "",
                            $caminhoFinal,
                            $anuncio_id,
                            $conexao
                        );
                        $imagem->editarImagem();
                }

                // Mova o arquivo temporário para o caminho final
                if (!move_uploaded_file($tmpName, $caminhoFinal)) {
                    throw new Exception("Erro ao salvar a imagem: $nomeArquivo");
                }
            } else {
                throw new Exception("Erro no upload do arquivo: $nomeArquivo");
            }
        } 

    }


?>