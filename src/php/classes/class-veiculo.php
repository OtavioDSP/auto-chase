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
    private $veiculo_ano;
    private $conexao;

    // Construtor
    public function __construct(
        $veiculo_id,
        $veiculo_quilometragem,
        $veiculo_versao,
        $fk_chassi_id,
        $fk_combustivel_id,
        $fk_cor_id,
        $fk_modelo_id,
        $veiculo_ano,
        $conexao
    ) {
        $this->veiculo_id = $veiculo_id;
        $this->veiculo_quilometragem = $veiculo_quilometragem;
        $this->veiculo_versao = $veiculo_versao;
        $this->fk_chassi_id = $fk_chassi_id;
        $this->fk_combustivel_id = $fk_combustivel_id;
        $this->fk_cor_id = $fk_cor_id;
        $this->fk_modelo_id = $fk_modelo_id;
        $this->veiculo_ano = $veiculo_ano;
        $this->conexao = $conexao;
    }

    /**
     * Insere um novo veículo no banco de dados.
     * O veiculo_id é auto-increment, então foi removido da query.
     */
    public function insereVeiculo() {
        $sql = "INSERT INTO Veiculo (
                    veiculo_quilometragem, veiculo_versao, 
                    fk_chassi_id, fk_combustivel_id, fk_cor_id, fk_modelo_id, veiculo_ano
                ) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexao->prepare($sql);
        // Tipos: d=decimal, s=string, i=integer
        $stmt->bind_param("dsiiiii", 
            $this->veiculo_quilometragem,
            $this->veiculo_versao,
            $this->fk_chassi_id,
            $this->fk_combustivel_id,
            $this->fk_cor_id,
            $this->fk_modelo_id,
            $this->veiculo_ano
        );

        if ($stmt->execute()) {
            return $this->conexao->insert_id;
        } else {
            echo "Erro ao inserir veículo: " . $stmt->error;
            return false;
        }
    }

    /**
     * Atualiza os dados de um veículo existente.
     */
    public function editarVeiculo() {
        // CORREÇÃO: Adicionada vírgula faltante antes de veiculo_ano
        $sql = "UPDATE veiculo SET 
                    veiculo_quilometragem = ?, 
                    veiculo_versao = ?, 
                    fk_chassi_id = ?, 
                    fk_combustivel_id = ?, 
                    fk_cor_id = ?, 
                    fk_modelo_id = ?, 
                    veiculo_ano = ? 
                WHERE veiculo_id = ?";
                
        $stmt = $this->conexao->prepare($sql);
        // Tipos: d=decimal, s=string, i=integer
        $stmt->bind_param("dsiiiiii",
            $this->veiculo_quilometragem,
            $this->veiculo_versao,
            $this->fk_chassi_id,
            $this->fk_combustivel_id,
            $this->fk_cor_id,
            $this->fk_modelo_id,
            $this->veiculo_ano,
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
    
    /**
     * Lista veículos com seus dados de tabelas relacionadas.
     * CORRIGIDO: Removida vírgula extra e adicionado JOIN com 'anuncio'.
     */
    public function listarVeiculo() {
        $sql = "
        SELECT 
            veiculo.veiculo_id,
            veiculo.veiculo_versao,
            veiculo.veiculo_ano,
            veiculo.veiculo_quilometragem,
            marca.marca_desc,
            cor.cor_desc,
            chassi.chassi_desc,
            combustivel.comb_desc,
            modelo.modelo_desc,
            imagem.imagem_url 
            /* === CORREÇÃO 1: Removida a vírgula extra daqui === */
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
        
        /* === CORREÇÃO 2: Adicionada a tabela 'anuncio' === */
        /* Ela é necessária para ligar 'veiculo' a 'imagem' */
        INNER JOIN
            anuncio ON veiculo.veiculo_id = anuncio.fk_veiculo_id
        
        INNER JOIN
            imagem ON imagem.fk_anuncio_id = anuncio.anuncio_id
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
        // Adicionado JOIN com modelo para buscar o fk_marca_id
        $sql = "SELECT v.*, m.fk_marca_id 
                FROM veiculo v
                JOIN modelo m ON v.fk_modelo_id = m.modelo_id
                WHERE v.veiculo_id = ?";

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