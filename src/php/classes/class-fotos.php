<?php
    class Fotos{

        private $foto_id;
        private $foto_caminho;
    
        private $conexao;

        public function __construct($foto_id, $foto_caminho, $conexao){

            $this->foto_id = $foto_id;
            $this->foto_caminho = $foto_caminho;
            $this->conexao = $conexao;

        }
        public function insereFoto(){
            $sql = "INSERT INTO Foto (foto) VALUES ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('s',
            $this->foto_caminho,
            );
             if($stmt->execute()){
                echo "foto inserida";
            }else{
                echo "Erro ao Inserir foto". $stmt->error;
            }
        





        }public function deletarFoto(){

            $sql = "DELETE FROM Foto WHERE fotos_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('i',$this->foto_id);
        
            if($stmt->execute()){

            echo "Foto deletada com sucesso";


        }else{

            echo "erro ao deletar foto" .$stmt->error;

            

        }



        }public function listarFoto(){
            $sql = "SELECT foto.foto_caminho, foto.data_de_upload FROM fotos INNER JOIN usuario ON fotos.fk_usuario_id = usuario.usuario_id WHERE fotos_id = ?";
            $stmt = $this->conexao->prepare($sql);

            $stmt->bind('ssi',$this->foto_caminho, $this->foto_id);

            if($stmt->execute()){
                echo "foto listar com sucesso";
            }else{
                echo "Erro ao listar fotos" .$stmt->error;
            }


        }public function editarFoto(){

            $sql = "UPDATE foto SET foto_caminho = ? WHERE foto_id = ?";

            $stmt = $this->conexao->prepare($sql);

            $stmt->bind_param('si', $this->foto_caminho, $this->foto_id);
            
            if($stmt->execute()){
                echo "foto editada com sucesso";
            }else{
                echo "Erro ao editar foto" .$stmt->error;
            }


        }



    }

?>