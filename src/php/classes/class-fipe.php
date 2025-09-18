<?php
    class Fipe{

        private $fipe_id;
        private $fipe_desc;
        private $conexao;

        public function __construct($fipe_id,$fipe_desc, $conexao){

            $this->fipe_id = $fipe_id;
            $this->fipe_desc = $fipe_desc;
            $this->conexao = $conexao;

        }
        public function insereFipe(){

            $sql = "INSERT INTO fipe (fipe_desc) VALUES (?)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('s',
            $this->fipe_desc,
            );
             if($stmt->execute()){
                echo "Fipe inserido";
            }else{
                echo "Erro ao Inserir Fipe". $stmt->error;
            }
        





        }public function deletarFipe(){

            $sql = "DELETE FROM fipe WHERE fipe_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('i',$this->fipe_id);
            if($stmt->execute()){

                echo "Fipe excluido com sucesso";

            }else{

                echo "Erro ao deletar: " . $stmt->error;

            }


        }public function listarFipe(){

            $sql = "
            SELECT 
                *
            FROM 
                fipe
            ";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $fipes = [];

            while($fipe = $resultado->fetch_assoc()){
                $fipes[] = $fipe;
            }

            return $fipes;

        }public function editarFipe(){

            $sql = "UPDATE fipe SET fipe_desc = ? WHERE fipe_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('si', $this->fipe_desc, $this->fipe_id);
            if($stmt->execute()){
                echo "Fipe editado com sucesso";
            }else{
                echo "Erro ao editar fipe" .$stmt->error;
            }

        }

    }

?>