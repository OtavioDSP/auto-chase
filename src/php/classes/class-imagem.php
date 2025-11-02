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

            $sql = "DELETE FROM imagem WHERE imagem_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('i',$this->imagem_id);
        
            if($stmt->execute()){

            echo "Foto deletada com sucesso";


        }else{

            echo "erro ao deletar foto" .$stmt->error;

            

        }



        }public function listarImagem(){
            $sql = "SELECT imagem_id, imagem_desc FROM imagem WHERE fotos_id = ?";
            $stmt = $this->conexao->prepare($sql);

            $stmt->bind('ssi',$this->imagem_url, $this->imagem_id);

            if($stmt->execute()){
                echo "foto listar com sucesso";
            }else{
                echo "Erro ao listar fotos" .$stmt->error;
            }


        }public function editarImagem(){

            $sql = "UPDATE imagem SET imagem_url = ? WHERE imagem_id = ?";

            $stmt = $this->conexao->prepare($sql);

            $stmt->bind_param('si', $this->imagem_url, $this->imagem_id);
            
            if($stmt->execute()){
                echo "foto editada com sucesso";
            }else{
                echo "Erro ao editar foto" .$stmt->error;
            }


        }



    }

?>