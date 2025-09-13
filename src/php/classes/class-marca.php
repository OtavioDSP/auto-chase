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
        public function insereMarca(){
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
        





        }public function deletarMarca(){

            $sql = "DELETE FROM Marca WHERE marca_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('i',$this->marca_id);
        
            if($stmt->execute()){

            echo "Marca deletada com sucesso";


        }else{

            echo "erro ao deletar marca" .$stmt->error;

            

        }



        }public function listarMarcas(){
            $sql = "
            SELECT 
                marca.marca_desc
            FROM 
                marca
            ";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $marcas = [];

            while($marca = $resultado->fetch_assoc()){
                $marcas[] = $marca;
            }

            return $marcas;

        } public function editarMarcas(){
            $sql = "UPDATE Marca SET marca_desc = ? WHERE marca_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('si', $this->marca_desc, $this->marca_id);
            if($stmt->execute()){
                echo "Marca editada com sucesso";
            }else{
                echo "Erro ao editar marca" .$stmt->error;
            }

        }




    }

?>