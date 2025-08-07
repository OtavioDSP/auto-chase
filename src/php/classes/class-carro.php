<?php

Class Veiculo{

    private $carro_id;
    private $carro_descricao;
    private $cor_id;
    private $modelo_id;
    private $chassi_id;
    private $comb_id;
    private $marca_id;
    private $anuncio_id;
    private $conexao;

    public function __construct($carro_id, $carro_descricao, $cor_id, $modelo_id, $chassi_id, $comb_id, $marca_id, $anuncio_id, $conexao) {
        $this->carro_id = $carro_id;
        $this->carro_descricao = $carro_descricao;
        $this->cor_id = $cor_id;
        $this->modelo_id = $modelo_id;
        $this->chassi_id = $chassi_id;
        $this->comb_id = $comb_id;
        $this->marca_id = $marca_id;
        $this->anuncio_id = $anuncio_id;
        $this->conexao = $conexao;
    }

    public function insereCarro(){
        $sql = "INSERT INTO Carro (carro_id, carro_descricao, cor_id, modelo_id, chassi_id, comb_id, marca_id) VALUES (?,?,?,?,?,?,?)";
        
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("issiiii", 
            $this->carro_id, 
            $this->carro_descricao, 
            $this->cor_id, 
            $this->modelo_id, 
            $this->chassi_id, 
            $this->comb_id, 
            $this->marca_id
        );
        if($stmt->execute()){
            echo "veiculo inserida";
        }else{
            echo "Erro ao inserir veiculo". $stmt->error;
        }
        
        
    }public function deletarVeiculo(){

        $sql = "DELETE FROM carro WHERE carro_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('i',$this->carro_id);
    
        if($stmt->execute()){

        echo "veiculo deletado com sucesso";


    }else{

        echo "erro ao deletar veiculo" .$stmt->error;

        

    }



    }



}











?>