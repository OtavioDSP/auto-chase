<?php
    class Combustivel{

        private $comb_id;
        private $comb_tipo;
        private $conexao;

        public function __construct($comb_id,$comb_tipo, $conexao){

            $this->comb_id = $comb_id;
            $this->comb_tipo = $comb_tipo;
            $this->conexao = $conexao;

        }
        public function insereCombustivel(){
            $sql = "INSERT INTO Combustivel (comb_tipo) VALUES ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('s',
            $this->comb_tipo,
            );
             if($stmt->execute()){
                echo " combustivel inserido";
            }else{
                echo "Erro ao Inserir combustivel". $stmt->error;
            }
        





        } public function deletarCombustivel(){
        $sql = "DELETE FROM Combustivel WHERE comb_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('i',$this->comb_id);
        if($stmt->execute()){

            echo "Combustivel deletado com sucesso";
    

        }else{

            echo "erro ao deletar Combustivel" .$stmt->error;

            

        }



        }
    }
?>