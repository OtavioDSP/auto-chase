<?php
    class Fotos{

        private $fotos_id;
        private $foto_caminho;
        private $fk_foto_user;
        private $data_de_upload;
        private $conexao;

        public function __construct($fotos_id, $foto_caminho, $foto_user, $data_de_upload, $conexao){

            $this->fotos_id = $fotos_id;
            $this->foto_user = $foto_user;
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
            $stmt->bind_param('i',$this->fotos_id);
        
            if($stmt->execute()){

            echo "Foto deletada com sucesso";


        }else{

            echo "erro ao deletar foto" .$stmt->error;

            

        }



        }



    }

?>