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
            
            $sql = "INSERT INTO Chassi (chassi_desc) VALUES (?)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('s',
            $this->chassi_desc,
            );
             if($stmt->execute()){
                echo " chassi inserido";
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
                *
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

        }public function editarChassi(){

            $sql = "UPDATE Chassi SET chassi_desc = ? WHERE chassi_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('si', $this->chassi_desc, $this->chassi_id);
            if($stmt->execute()){
                echo "Chassi editado com sucesso";
            }else{
                echo "Erro ao editar chassi" .$stmt->error;
            }

        }public function buscarChassiPorId($chassi_id) {
            $sql = "SELECT * FROM chassi WHERE chassi_id = ?";
            
            $stmt = $this->conexao->prepare($sql);
            
            // Vincula o ID do modelo ao placeholder da consulta
            // 'i' indica que o parâmetro é um inteiro
            $stmt->bind_param('i', $chassi_id);
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            // Retorna a primeira linha do resultado como um array associativo
            // Ou 'null' se nenhum usuário for encontrado
            return $result->fetch_assoc();
        }

    }

?>