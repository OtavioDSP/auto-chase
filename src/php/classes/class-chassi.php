<?php
    class Chassi{

        private $chassi_id;
        private $chassi_desc;
        private $conexao;

        public function __construct($chassi_id,$chassi_desc, $conexao){

            $this->chassi_id = $chassi_id;
            $this->chassi_desc = $chassi_desc;
            $this->conexao = $conexao;

        }
        public function insereCombustivel(){
            $sql = "INSERT INTO Combustivel (comb_tipo) VALUES ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('s',
            $this->chassi_desc,
            );
             if($stmt->execute()){
                echo " combustivel inserido";
            }else{
                echo "Erro ao Inserir combustivel". $stmt->error;
            }
        





        }



    }

?>