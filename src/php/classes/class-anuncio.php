<?php
    class anuncio{

        private $anuncio_id;
        private $anuncio_valor;
        private $data_de_criacao;
        private $data_de_exclusao;
        private $conexao;

        public function __construct($anuncio_id, $anuncio_valor, $data_de_criacao, $data_de_exclusao, $conexao){

            $this->anuncio_id = $anuncio_id;
            $this->anuncio_valor = $anuncio_valor;
            $this->data_de_criacao = $anuncio_valor;
            $this->data_de_exclusao = $data_de_exclusao;
            $this->conexao = $conexao;

        }


        public function criaAnuncio(){
            $sql = "INSERT INTO anuncio (anuncio_valor, data_de_criacao, data_de_exclusao) VALUES ???";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('iss',
            $this->anuncio_valor,
            $this->data_de_criacao,
            $this->data_de_exclusao

            );
             if($stmt->execute()){
                echo "anuncio criado";
            }else{
                echo "Erro ao criar anuncio". $stmt->error;
            }
        





        } public function deletarAnuncio(){
            $sql = "DELETE FROM anuncio WHERE anuncio_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('i',$this->anuncio_id);
            if($stmt->execute()){

                echo "Anuncio deletado com sucesso"; 


            }else{
                echo "erro ao deletar anuncio" .$stmt->error;

            }




        }



    }

?>