<?php
    class Anuncio{

        private $anuncio_id;
        private $anuncio_desc;
        private $fk_usuario_id;
        private $fk_veiculo_id;
        private $anuncio_valor;
        private $conexao;

        public function __construct($anuncio_id, $anuncio_desc, $fk_usuario_id, $fk_veiculo_id, $anuncio_valor, $conexao){

            $this->anuncio_id = $anuncio_id;
            $this->anuncio_desc = $anuncio_desc;
            $this->fk_usuario_id = $fk_usuario_id;
            $this->fk_veiculo_id = $fk_veiculo_id;
            $this->anuncio_valor = $anuncio_valor;
            
            $this->conexao = $conexao;

        }


        public function criaAnuncio(){
            $sql = "INSERT INTO anuncio (anuncio_valor, anuncio_desc, fk_usuario_id, fk_veiculo_id) VALUES (?,?,?,?)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('issi',
            $this->anuncio_valor,
            $this->anuncio_desc,
            $this->fk_usuario_id,
            $this->fk_veiculo_id,

            );
             if($stmt->execute()){
                echo "anuncio criado";
            }else{
                echo "Erro ao criar anuncio". $stmt->error;
            }
        





        } public function deletarAnuncio(){
            $sql = "DELETE FROM anuncio WHERE anuncio_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('i',$this->anuncio_id);
            if($stmt->execute()){

                echo "Anuncio deletado com sucesso"; 


            }else{
                echo "erro ao deletar anuncio" .$stmt->error;

            }




        } public function listarAnuncio(){
            $sql = "
            SELECT 
                anuncio_id,
                anuncio_valor,
                data_de_criacao,
                usuario.usuario_nome,
                carro.carro_desc,
                carro.carro_ano,
                carro.carro_marca,
                chassi.chassi_desc,
                modelo.modelo_desc,
                marca.marca_desc
            FROM 
                anuncio
            INNER JOIN 
                usuario ON usuario.usuario_id = anuncio.fk_usuario_id
            INNER JOIN
                carro ON carro.carro_id = anuncio.fk_veiculo_id
            INNER JOIN 
                modelo ON carro.fk_modelo_id = modelo.modelo_id
            INNER JOIN 
                marca ON carro.fk_marca_id = marca.marca_id
            INNER JOIN
                combustivel ON carro.fk_comb_id = combustivel.combustivel_id
            INNER JOIN
                chassi ON carro.fk_chassi_id = chassi.chassi_id
            INNER JOIN
                fotos ON fotos.fotos_id = anuncio.anuncio_id
            ";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $anuncios = [];
            while($anuncio = $resultado->fetch_assoc()){
                $anuncios[] = $anuncio;

            }

            return $anuncios;




        }public function editarAnuncio(){

            $sql = "UPDATE anuncio SET anuncio_desc = ?, anuncio_valor = ?, WHERE anuncio_id = ?";

            $stmt = $this->conexao->prepare($sql);
        
            $stmt->bind_param('ssi', $this->anuncio_desc, $this->anuncio_valor, $this->anuncio_id);
            if($stmt->execute()){
                echo "Cor editada com sucesso";
            }else{
                echo "Erro ao editar cor" .$stmt->error;
            }

        }

    }

?>