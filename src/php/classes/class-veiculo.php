<?php

Class Veiculo{

    private $veiculo_id;
    private $veiculo_descricao;
    private $veiculo_quilometragem;
    private $veiculo_ano;
    private $fk_usuario_id;
    private $fk_cor_id;
    private $fk_modelo_id;
    private $fk_chassi_id;
    private $fk_comb_id;
    private $fk_marca_id;
    private $fk_anuncio_id;
    private $conexao;

    public function __construct($veiculo_id, $veiculo_descricao,$veiculo_quilometragem,  $veiculo_ano, $fk_usuario_id, $fk_cor_id, $fk_modelo_id, $fk_chassi_id, $fk_comb_id, $fk_marca_id, $fk_anuncio_id, $conexao) {
        $this->veiculo_id = $veiculo_id;
        $this->veiculo_descricao = $veiculo_descricao;
        $this->veiculo_quilometragem = $veiculo_quilometragem;
        $this->veiculo_ano = $veiculo_ano;
        $this->fk_usuario_id = $fk_usuario_id;
        $this->fk_cor_id = $fk_cor_id;
        $this->fk_modelo_id = $fk_modelo_id;
        $this->fk_chassi_id = $fk_chassi_id;
        $this->fk_comb_id = $fk_comb_id;
        $this->fk_marca_id = $fk_marca_id;
        $this->fk_anuncio_id = $fk_anuncio_id;
        $this->conexao = $conexao;
    }

    public function insereVeiculo(){
        $sql = "INSERT INTO Veiculo (veiculo_id, veiculo_descricao, veiculo_quilometragem, veiculo_ano, fk_usuario_id, fk_cor_id, fk_modelo_id, fk_chassi_id, fk_comb_id, fk_marca_id, fk_anuncio_id) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("isssi", 
            $this->veiculo_id, 
            $this->veiculo_descricao, 
            $this->veiculo_quilometragem, 
            $this->veiculo_ano, 
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
            veiculo.veiculo_descricao,
            veiculo.veiculo_quilometragem,
            veiculo.veiculo_ano,
            marca.marca_desc,
            cor.cor_desc,
            chassi.chassi_desc,
            combustivel.combustivel_desc,
            marca.marca_desc,
            usuario.usuario_nome

        FROM 
            veiculo
        INNER JOIN 
            cor ON veiculo.cor_id = cor.cor_id
        INNER JOIN
            chassi ON veiculo.chassi_id = chassi.chassi_id
        INNER JOIN
            marca ON veiculo.marca_id = marca.marca_id
        INNER JOIN
            combustivel ON veiculo.combustivel_id = combustivel.combustivel_id
        INNER JOIN
            usuario ON veiculo.usuario_id = usuario.usuario_id
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
        $sql = "UPDATE veiculo SET veiculo_descricao = ?, veiculo_quilometragem = ?, veiculo_ano = ?,  WHERE veiculo_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("sssi", 
            $this->veiculo_descricao, 
            $this->veiculo_quilometragem, 
            $this->veiculo_ano, 
            $this->veiculo_id  
        );
        if($stmt->execute()){
            echo "veiculo editada";
        }else{
            echo "Erro ao editar veiculo". $stmt->error;
        }
    }



}











?>