<?php 

Class Modelo{

    private $modelo_id;
    private $modelo_desc;

    private $modelo_fipe;
    private $fk_marca_id;
    private $conexao;
    
    public function __construct($modelo_id, $modelo_desc, $modelo_fipe,
     $fk_marca_id, $conexao) {
        $this->modelo_id = $modelo_id;
        $this->modelo_desc = $modelo_desc;
        $this->modelo_fipe = $modelo_fipe;
        $this->fk_marca_id = $fk_marca_id;
        $this->conexao = $conexao;
    }

    public function insereModelo(){
        $sql = "INSERT INTO modelo (modelo_desc, modelo_valor_fipe, fk_Marca_id) VALUES (?, ?, ?)";

        $stmt = $this->conexao->prepare($sql);
        
        $stmt->bind_param('sds', 
            $this->modelo_desc,
            $this->modelo_fipe,
            $this->fk_marca_id
        );
        if($stmt->execute()){
            echo "fipe inserida";
        }else{
            echo "Erro ao inserir fipe". $stmt->error;
        }    
        
    }
    
    public function deletarModelo(){

        $sql = "DELETE FROM modelo WHERE modelo_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('i',$this->modelo_id);
    
        if($stmt->execute()){
            echo "modelo deletado com sucesso";
        } else{
            echo "erro ao deletar modelo" .$stmt->error;   
        }

    }
    
    public function listarModelo(){
            $sql = "
            SELECT 
                modelo.modelo_desc,
                modelo.modelo_valor_fipe,
                modelo.modelo_id,
                modelo.fk_marca_id,
                marca.marca_desc
            FROM 
                modelo
            INNER JOIN 
                marca ON modelo.fk_marca_id = marca.marca_id
            ";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $modelos = [];

            while($modelo = $resultado->fetch_assoc()){
                $modelos[] = $modelo;
            }

            return $modelos;
    }
    public function listarModeloPorMarca($marca){
        $sql = "SELECT * FROM modelo WHERE fk_marca_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('i', $marca);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $modelos = [];

        while($modelo = $resultado->fetch_assoc()){
            $modelos[] = $modelo;
        }

        return $modelos;
    }

    
    public function editarModelo(){

            $sql = "UPDATE modelo SET modelo_desc = ?, modelo_valor_fipe = ?, fk_marca_id = ? WHERE modelo_id = ?";

            $stmt = $this->conexao->prepare($sql);

          $stmt->bind_param('ssidi',
                $this->modelo_desc,    
                $this->modelo_fipe,  
                $this->fk_marca_id,   
                $this->modelo_id      
            );

            if($stmt->execute()){
                echo "Modelo editado com sucesso";
            }else{
                echo "Erro ao editar modelo" .$stmt->error;
            }


        } public function buscarModeloPorId($modelo_id) {
            $sql = "SELECT 
                modelo.modelo_desc,
                modelo.modelo_valor_fipe,
                modelo.modelo_id,
                modelo.fk_marca_id,
                marca.marca_desc
            FROM 
                modelo
            INNER JOIN 
                marca ON modelo.fk_marca_id = marca.marca_id
            WHERE 
                modelo.modelo_id = ? 
            ";
            
            $stmt = $this->conexao->prepare($sql);
            
            // Vincula o ID do modelo ao placeholder da consulta
            // 'i' indica que o parâmetro é um inteiro
            $stmt->bind_param('i', $modelo_id);
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            // Retorna a primeira linha do resultado como um array associativo
            // Ou 'null' se nenhum usuário for encontrado
            return $result->fetch_assoc();
        }
    
        
   

}





?>