<?php
    class Combustivel{

        private $cor_id;
        private $cor_desc;
        private $conexao;

        public function __construct($cor_id,$cor_desc, $conexao){

            $this->cor_id = $cor_id;
            $this->cor_desc = $cor_desc;
            $this->conexao = $conexao;

        }
        public function insereCor(){
            $sql = "INSERT INTO Cor (cor_desc) VALUES ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('s',
            $this->cor_desc,
            );
             if($stmt->execute()){
                echo "Cor inserida";
            }else{
                echo "Erro ao Inserir cor". $stmt->error;
            }
        





        }



    }

?>