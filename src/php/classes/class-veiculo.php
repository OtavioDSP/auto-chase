<?php

class Veiculo {

    // Propriedades do Veículo, incluindo as chaves estrangeiras (FKs)
    private $veiculo_id;
    private $veiculo_quilometragem;
    private $veiculo_versao;
    private $fk_chassi_id;
    private $fk_combustivel_id;
    private $fk_cor_id;
    private $fk_modelo_id;

    
    private $conexao;

    // Construtor atualizado para receber todos os novos parâmetros
    public function __construct(
        $veiculo_id,
        $veiculo_quilometragem,
        $veiculo_versao,
        $fk_chassi_id,
        $fk_combustivel_id,
        $fk_cor_id,
        $fk_modelo_id,
        
        $conexao
    ) {
        $this->veiculo_id = $veiculo_id;
        $this->veiculo_quilometragem = $veiculo_quilometragem;
        $this->veiculo_versao = $veiculo_versao;
        $this->fk_chassi_id = $fk_chassi_id;
        $this->fk_combustivel_id = $fk_combustivel_id;
        $this->fk_cor_id = $fk_cor_id;
        $this->fk_modelo_id = $fk_modelo_id;
    
        $this->conexao = $conexao;
    }

    /**
     * Insere um novo veículo no banco de dados com todas as suas chaves estrangeiras.
     * OBS: O campo veiculo_id não deve ser inserido se for AUTO_INCREMENT na sua tabela.
     * Se for o caso, remova "veiculo_id" da query e o primeiro "?" e "$this->veiculo_id" do bind_param.
     */
    public function insereVeiculo() {
        $sql = "INSERT INTO Veiculo (
                    veiculo_id, veiculo_quilometragem, veiculo_versao, 
                    fk_chassi_id, fk_combustivel_id, fk_cor_id, fk_modelo_id
                ) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexao->prepare($sql);
        // Tipos: i=integer, s=string. Ajuste se necessário.
        $stmt->bind_param("isiiiii", 
            $this->veiculo_id,
            $this->veiculo_quilometragem,
            $this->veiculo_versao,
            $this->fk_chassi_id,
            $this->fk_combustivel_id,
            $this->fk_cor_id,
            $this->fk_modelo_id,
            
        );

        if ($stmt->execute()) {
            return $this->conexao->insert_id;
        } else {
            echo "Erro ao inserir veículo: " . $stmt->error;
        }
    }

    /**
     * Atualiza os dados de um veículo existente.
     */
    public function editarVeiculo() {
        $sql = "UPDATE veiculo SET 
                    veiculo_quilometragem = ?, 
                    veiculo_versao = ?, 
                    fk_chassi_id = ?, 
                    fk_combustivel_id = ?, 
                    fk_cor_id = ?, 
                    fk_modelo_id = ? 
                WHERE veiculo_id = ?";
                
        $stmt = $this->conexao->prepare($sql);
        // Tipos: i=integer, s=string. Ajuste se necessário.
        $stmt->bind_param("isiiiii",
            $this->veiculo_quilometragem,
            $this->veiculo_versao,
            $this->fk_chassi_id,
            $this->fk_combustivel_id,
            $this->fk_cor_id,
            $this->fk_modelo_id,
            $this->veiculo_id
        );

        if ($stmt->execute()) {
            echo "Veículo editado com sucesso!";
        } else {
            echo "Erro ao editar veículo: " . $stmt->error;
        }
    }

    public function deletarVeiculo() {
        $sql = "DELETE FROM veiculo WHERE veiculo_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('i', $this->veiculo_id);

        if ($stmt->execute()) {
            echo "Veículo deletado com sucesso";
        } else {
            echo "Erro ao deletar veículo: " . $stmt->error;
        }
    }
    
    // O método listarVeiculo já estava correto, buscando os dados através dos JOINs.
    public function listarVeiculo() {
        $sql = "
        SELECT 
            veiculo.veiculo_id,
            veiculo.veiculo_versao,
            veiculo.veiculo_quilometragem,
            marca.marca_desc,
            cor.cor_desc,
            chassi.chassi_desc,
            combustivel.comb_desc,
            modelo.modelo_desc
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
    }
    
    public function buscarVeiculoPorId($veiculo_id) {
        $sql = "SELECT * FROM veiculo WHERE veiculo_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('i', $veiculo_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function listarVersoes() {
        try {
            $sql = "SELECT DISTINCT veiculo_versao FROM veiculo ORDER BY veiculo_versao ASC";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $versoes = $resultado->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $versoes;
        } catch (Exception $e) {
            error_log("Erro ao listar versões: " . $e->getMessage());
            return [];
        }
    }
}
?>