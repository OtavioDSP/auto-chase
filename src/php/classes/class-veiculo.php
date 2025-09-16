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
            veiculo.veiculo_desc,
            veiculo.veiculo_quilometragem,
            marca.marca_desc,
            cor.cor_desc,
            chassi.chassi_desc,
            combustivel.comb_desc,
            usuario.usuario_nome

        FROM 
            veiculo
        INNER JOIN 
            cor ON veiculo.fk_cor_id = cor.cor_id
        INNER JOIN
            chassi ON veiculo.fk_chassi_id = chassi.chassi_id
        INNER JOIN
            combustivel ON veiculo.fk_combustivel_id = combustivel.comb_id
        INNER JOIN
            anuncio ON veiculo.fk_anuncio_id = anuncio.anuncio_id
        INNER JOIN
            usuario ON anuncio.fk_usuario_id = usuario.usuario_id  
        INNER JOIN
            modelo ON veiculo.fk_modelo_id = modelo.modelo_id
        INNER JOIN 
            marca ON modelo.fk_marca_id = marca.marca_Id 
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
    }



}











?>