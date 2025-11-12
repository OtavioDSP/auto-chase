<?php
    class Foto{

        private $imagem_id;
        private $imagem_url;
        private $fk_anuncio_id;
        private $conexao;

        public function __construct($imagem_id, $imagem_url, $fk_anuncio_id, $conexao){

            $this->imagem_id = $imagem_id;
            $this->imagem_url = $imagem_url;
            $this->fk_anuncio_id = $fk_anuncio_id;
            $this->conexao = $conexao;

        }
        public function insereImagem(){
            $sql = "INSERT INTO imagem (imagem_url, fk_anuncio_id) VALUES (?, ?)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('si',
            $this->imagem_url,
            $this->fk_anuncio_id
            );
             if($stmt->execute()){
                echo "foto inserida";
            }else{
                echo "Erro ao Inserir foto". $stmt->error;
            }
            
        }public function deletarImagem(){
            // Garante que estamos deletando uma imagem específica.
            if (empty($this->imagem_id)) {
                // Não faz nada se o ID da imagem não for fornecido.
                // Você pode adicionar um log de erro aqui se preferir.
                return;
            }
            $sql = "DELETE FROM imagem WHERE imagem_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('i',$this->imagem_id);
        
            if($stmt->execute()){
                // Silencioso em caso de sucesso para não poluir a saída.
            } else {
                // Em um ambiente de produção, o ideal seria logar este erro.
                echo "Erro ao deletar foto: " . $stmt->error;
            }
        }
        
        public function deletarImagensPorAnuncioId(){
            $sql = "DELETE FROM imagem WHERE fk_anuncio_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('i', $this->fk_anuncio_id);
            $stmt->execute();


        }public function listarImagem(){
            $sql = "SELECT imagem_id, imagem_url FROM imagem ";
          //  echo  "SELECT imagem_id, imagem_url FROM imagem WHERE fk_anuncio_id = $this->fk_anuncio_id";
            
            $stmt = $this->conexao->prepare($sql);

            // $stmt->bind_param('i', $this->fk_anuncio_id);
            $fotos = [];
            if($stmt->execute()){
                $resultado = $stmt->get_result();
               

                while($foto = $resultado->fetch_assoc()){
                    //echo $foto;
                    $fotos[] = $foto;
                }

            

                // echo "foto listar com sucesso";
            }else{
                echo "Erro ao listar fotos" .$stmt->error;
            }
            return $fotos;
            

        }public function editarImagem(){
            // ATENÇÃO: Este método é problemático se um anúncio tiver várias imagens
            // e a coluna imagem_url for UNIQUE.
            // A melhor abordagem é deletar as antigas e inserir as novas.
            // Mantendo o método, mas corrigindo para usar o ID da imagem.
            $sql = "UPDATE imagem SET imagem_url = ? WHERE imagem_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('si', $this->imagem_url, $this->imagem_id);
            if($stmt->execute()){
                echo "foto editada com sucesso";
            }else{
                echo "Erro ao editar foto" .$stmt->error;
            }
        }public function listarImagemPorIdDeAnuncio($fk_anuncio_id){
            $sql = "SELECT imagem_id, imagem_url FROM imagem WHERE fk_anuncio_id = ?";
            
            $stmt = $this->conexao->prepare($sql);

            $stmt->bind_param('i', $fk_anuncio_id);
            $fotos = [];
            if($stmt->execute()){
                $resultado = $stmt->get_result();
               

                while($foto = $resultado->fetch_assoc()){
                    //echo $foto;
                    $fotos[] = $foto;
                }

            

                // echo "foto listar com sucesso";
            }else{
                echo "Erro ao listar fotos" .$stmt->error;
            }
            return $fotos;
            

        }



    }

?>