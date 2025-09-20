<?php
    class Cor{

        private $cor_id;
        private $cor_desc;
        private $conexao;

        public function __construct($cor_id, $cor_desc, $conexao){

            $this->cor_id = $cor_id;
            $this->cor_desc = $cor_desc;
            $this->conexao = $conexao;

        }
        public function insereCor(){
            $sql = "INSERT INTO Cor (cor_desc) VALUES (?)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('s',
            $this->cor_desc,
            );
             if($stmt->execute()){
                echo "Cor inserida";
            }else{
                echo "Erro ao Inserir cor". $stmt->error;
            }
        





        } public function deletarCor(){
        $sql = "DELETE FROM Cor WHERE cor_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('i',$this->cor_id);
        if($stmt->execute()){

            echo "cor deletada com sucesso";


        }else{

            echo "erro ao deletar cor" .$stmt->error;

            

        }



        } public function listarCores(){
            $sql = "SELECT * FROM cor";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $cores = [];

            while($cor = $resultado->fetch_assoc()){
                $cores[] = $cor;
            }

            return $cores;

        } public function editarCor(){

            $sql = "UPDATE Cor SET cor_desc = ? WHERE cor_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('si', $this->cor_desc, $this->cor_id);
            if($stmt->execute()){
                echo "Cor editada com sucesso";
            }else{
                echo "Erro ao editar cor" .$stmt->error;
            }

        }



    }
?>