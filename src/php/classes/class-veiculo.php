<?php

Class Veiculo{

    private $veiculo_id;
    private $veiculo_desc;
    private $veiculo_quilometragem;
    
    private $conexao;

    public function __construct($veiculo_id, $veiculo_desc,$veiculo_quilometragem, $conexao) {
        $this->veiculo_id = $veiculo_id;
        $this->veiculo_desc = $veiculo_desc;
        $this->veiculo_quilometragem = $veiculo_quilometragem;
        
        $this->conexao = $conexao;
    }

    public function insereVeiculo(){
        $sql = "INSERT INTO Veiculo (veiculo_id, veiculo_desc, veiculo_quilometragem) VALUES (?,?,?)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ssss", 
            $this->veiculo_id, 
            $this->veiculo_desc, 
            $this->veiculo_quilometragem, 
            
        
        );
        if($stmt->execute()){
            echo "veiculo inserida";
        }else{
            echo "Erro ao inserir veiculo". $stmt->error;
        }
        
        
    }public function deletarVeiculo(){

        $sql = "DELETE FROM veiculo WHERE veiculo_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('i',$this->veiculo_id);

        if($stmt->execute()){

        echo "veiculo deletado com sucesso";


    }else{

        echo "erro ao deletar veiculo" .$stmt->error;

    }



    } public function listarVeiculo(){

        $sql = "
        SELECT 
        veiculo.veiculo_id,
        veiculo.veiculo_quilometragem,
        marca.marca_desc,
        cor.cor_desc,
        chassi.chassi_desc,
        combustivel.comb_desc,
        modelo.modelo_desc,
            modelo.modelo_ano
        FROM 
            veiculo
        INNER JOIN 
            cor ON veiculo.fk_Cor_id = cor.cor_id
        INNER JOIN
            chassi ON veiculo.fk_Chassi_id = chassi.chassi_id
        INNER JOIN
            combustivel ON veiculo.fk_combustivel_id = combustivel.comb_id
        INNER JOIN
            modelo ON veiculo.fk_Modelo_id = modelo.modelo_id
        INNER JOIN
            marca ON modelo.fk_Marca_id = marca.marca_id
        ";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $veiculos = [];

        while($veiculo = $resultado->fetch_assoc()){
            $veiculos[] = $veiculo;
        }

        return $veiculos;
    }  public function editarVeiculo(){
        $sql = "UPDATE veiculo SET veiculo_desc = ?, veiculo_quilometragem = ?, veiculo_ano = ?,  WHERE veiculo_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ssi", 
            $this->veiculo_desc, 
            $this->veiculo_quilometragem, 
            $this->veiculo_id  
        );
        if($stmt->execute()){
            echo "veiculo editada";
        }else{
            echo "Erro ao editar veiculo". $stmt->error;
        }
    }public function buscarVeiculoPorId($veiculo_id) {
            $sql = "SELECT * FROM veiculo WHERE veiculo_id = ?";
            
            $stmt = $this->conexao->prepare($sql);
            
            // Vincula o ID do usuário ao placeholder da consulta
            // 'i' indica que o parâmetro é um inteiro
            $stmt->bind_param('i', $veiculo_id);
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            // Retorna a primeira linha do resultado como um array associativo
            // Ou 'null' se nenhum usuário for encontrado
            return $result->fetch_assoc();
        }



}











?>