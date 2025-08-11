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
        public function insereChassi(){
            
            $sql = "INSERT INTO Chassi (chassi_desc) VALUES ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('s',
            $this->chassi_desc,
            );
             if($stmt->execute()){
                echo " combustivel inserido";
            }else{
                echo "Erro ao Inserir combustivel". $stmt->error;
            }
        





        }public function deletarChassi(){

            $sql = "DELETE FROM Chassi WHERE chassi_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('i',$this->chassi_id);
            if($stmt->execute()){

                echo "Chassi excluido com sucesso";

            }else{

                echo "Erro ao deletar: " . $stmt->error;

            }


        }public function listarChassi(){

            $sql = "
            SELECT 
                chassi.chassi_desc
            FROM 
                chassi
            ";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $chassis = [];

            while($chassi = $resultado->fetch_assoc()){
                $chassis[] = $chassi;
            }

            return $chassis;
        }

    }

?>