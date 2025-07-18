<?php
    class Fotos{

        private $fotos_id;
        private $foto;
        private $conexao;

        public function __construct($fotos_id, $foto, $conexao){

            $this->fotos_id = $fotos_id;
            $this->foto = $foto;
            $this->conexao = $conexao;

        }
        public function insereFoto(){
            $sql = "INSERT INTO Foto (foto) VALUES ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('s',
            $this->foto,
            );
             if($stmt->execute()){
                echo "foto inserida";
            }else{
                echo "Erro ao Inserir foto". $stmt->error;
            }
        





        }



    }

?>