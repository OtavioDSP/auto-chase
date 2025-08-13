<?php

Class Veiculo{

    private $carro_id;
    private $carro_descricao;
    private $carro_quilometragem;
    private $carro_ano;
    private $fk_cor_id;
    private $fk_modelo_id;
    private $fk_chassi_id;
    private $fk_comb_id;
    private $fk_marca_id;
    private $fk_anuncio_id;
    private $conexao;

    public function __construct($carro_id, $carro_descricao,$carro_quilometragem,  $carro_ano, $fk_cor_id, $fk_modelo_id, $fk_chassi_id, $fk_comb_id, $fk_marca_id, $fk_anuncio_id, $conexao) {
        $this->carro_id = $carro_id;
        $this->carro_descricao = $carro_descricao;
        $this->carro_quilometragem = $carro_quilometragem;
        $this->carro_ano = $carro_ano;
        $this->fk_cor_id = $fk_cor_id;
        $this->fk_modelo_id = $fk_modelo_id;
        $this->fk_chassi_id = $fk_chassi_id;
        $this->fk_comb_id = $fk_comb_id;
        $this->fk_marca_id = $fk_marca_id;
        $this->fk_anuncio_id = $fk_anuncio_id;
        $this->conexao = $conexao;
    }

    public function insereCarro(){
        $sql = "INSERT INTO Carro (carro_id, carro_descricao, carro_quilometragem, carro_ano, fk_cor_id, fk_modelo_id, fk_chassi_id, fk_comb_id, fk_marca_id, fk_anuncio_id) VALUES (?,?,?,?,?,?,?,?,?,?)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("isssi", 
            $this->carro_id, 
            $this->carro_descricao, 
            $this->carro_quilometragem, 
            $this->carro_ano, 
            $this->fk_cor_id, 
            $this->fk_modelo_id, 
            $this->fk_chassi_id, 
            $this->fk_comb_id, 
            $this->fk_marca_id,
            $this->fk_anuncio_id
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



    } public function listarVeiculo{

        $sql = "
        SELECT 

            carro.carro_id,
            carro.carro_descricao,
            carro.carro_quilometragem,
            carro.carro_ano,
            marca.marca_desc,
            cor.cor_desc,
            chassi.chassi_desc,
            combustivel.combustivel_desc,
            marca.marca_desc

        FROM 
            carro
        INNER JOIN 
            cor ON carro.cor_id = cor.cor_id
        INNER JOIN
            chassi ON carro.chassi_id = chassi.chassi_id
        INNER JOIN
            marca ON carro.marca_id = marca.marca_id
        IN
        ";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $veiculos = [];

        while($veiculo = $resultado->fetch_assoc()){
            $veiculos[] = $veiculo;
        }

        return $veiculos;
    }



}











?>