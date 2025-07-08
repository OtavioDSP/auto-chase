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
            $stmt = 




        }



    }

?>