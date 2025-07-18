<?php
    class Marca{

        private $marca_id;
        private $marca_desc;
        private $conexao;

        public function __construct($marca_id, $marca_desc, $conexao){

            $this->marca_id = $marca_id;
            $this->marca_desc = $marca_desc;
            $this->conexao = $conexao;

        }
        public function criaAnuncio(){
            $sql = "INSERT INTO Marca (marca_desc) VALUES ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('s',
            $this->marca_desc,
            );
             if($stmt->execute()){
                echo "marca inserida";
            }else{
                echo "Erro ao Inserir marca". $stmt->error;
            }
        





        }



    }

?>