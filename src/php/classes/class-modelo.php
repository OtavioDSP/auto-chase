<?php 

Class Modelo{

    private $modelo_id;
    private $marca_id;
    private $fipe; 
    private $conexao;

    public function __construct($modelo_id, $marca_id, $fipe, $conexao) {
        $this->modelo_id = $modelo_id;
        $this->marca_id = $marca_id;
        $this->fipe = $fipe;
        $this->conexao = $conexao;
    }

    public function insereFipe(){
        $sql = "INSERT INTO fipe (marca_id, fipe) VALUES (?,?)";

        $stmt = $this->conexao->prepare($sql);
        
        $stmt->bind_param('ii', 
            $this->marca_id, 
            $this->fipe
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



    }


}





?>