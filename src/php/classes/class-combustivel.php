<?php
    class Combustivel{

        private $comb_id;
        private $comb_desc;
        private $conexao;

        public function __construct($comb_id,$comb_desc, $conexao){

            $this->comb_id = $comb_id;
            $this->comb_desc = $comb_desc;
            $this->conexao = $conexao;

        }
        public function insereCombustivel(){
            $sql = "INSERT INTO Combustivel (comb_desc) VALUES (?)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('s',
            $this->comb_desc,
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



        } public function listarCombustivel(){
            $sql = "SELECT * FROM combustivel";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $combustiveis = [];

            while($combustivel = $resultado->fetch_assoc()){
                $combustiveis[] = $combustivel;
            }

            return $combustiveis;
        }public function editarCombustivel(){
            $sql = "UPDATE combustivel SET comb_desc = ? WHERE comb_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('si', $this->comb_desc, $this->comb_id);
            if($stmt->execute()){
                echo "Combustivel editado com sucesso";
            }else{
                echo "Erro ao editar combustivel" .$stmt->error;
            }

        }public function buscarCombustivelPorId($comb_id) {
            $sql = "SELECT * FROM combustivel WHERE comb_id = ?";
            
            $stmt = $this->conexao->prepare($sql);
            
            // Vincula o ID do modelo ao placeholder da consulta
            // 'i' indica que o parâmetro é um inteiro
            $stmt->bind_param('i', $comb_id);
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            // Retorna a primeira linha do resultado como um array associativo
            // Ou 'null' se nenhum usuário for encontrado
            return $result->fetch_assoc();
        }

    }
?>