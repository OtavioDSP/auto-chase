<?php 

Class Modelo{

    private $modelo_id;
    private $modelo_desc;
    private $conexao;

    public function __construct($modelo_id, $modelo_desc, $conexao) {
        $this->modelo_id = $modelo_id;
        $this->$modelo_desc = $modelo_desc;
    
        $this->conexao = $conexao;
    }

    public function insereFipe(){
        $sql = "INSERT INTO modelo (modelo_desc) VALUES (?,?)";

        $stmt = $this->conexao->prepare($sql);
        
        $stmt->bind_param('s', 
            $this->modelo_desc,
            );
        if($stmt->execute()){
            echo "fipe inserida";
        }else{
            echo "Erro ao inserir fipe". $stmt->error;
        }





    }public function deletarModelo(){

        $sql = "DELETE FROM modelo WHERE modelo_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('i',$this->modelo_id);
    
        if($stmt->execute()){

        echo "modelo deletado com sucesso";


    }else{

        echo "erro ao deletar modelo" .$stmt->error;

        

    }



    }public function listarModelo(){
            $sql = "
            SELECT 
                modelo.modelo_desc
            FROM 
                modelo
            ";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $modelos = [];

            while($modelo = $resultado->fetch_assoc()){
                $modelos[] = $modelo;
            }

            return $modelos;

        }public function editarModelo(){

            $sql = "UPDATE modelo SET modelo_desc = ? WHERE modelo_id = ?";

            $stmt = $this->conexao->prepare($sql);

            $stmt->bind_param('si', $this->modelo_desc, $this->modelo_id);
            
            if($stmt->execute()){
                echo "Modelo editado com sucesso";
            }else{
                echo "Erro ao editar modelo" .$stmt->error;
            }


        }



}





?>