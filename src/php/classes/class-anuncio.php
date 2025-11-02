<?php
class Anuncio {

    private $anuncio_id;
    private $anuncio_desc;

    private $fk_usuario_id;
    private $fk_veiculo_id;
    private $anuncio_valor;
    private $conexao;
    public function __construct($anuncio_id, $anuncio_desc, $fk_usuario_id, $fk_veiculo_id, $anuncio_valor, $conexao) {
        $this->anuncio_id = $anuncio_id;
        $this->anuncio_desc = $anuncio_desc;
        $this->fk_usuario_id = $fk_usuario_id;
        $this->fk_veiculo_id = $fk_veiculo_id;
        $this->anuncio_valor = $anuncio_valor;
        $this->conexao = $conexao;
    }

    // Insere um novo anúncio no banco de dados
    public function insereAnuncio() {
        $sql = "INSERT INTO anuncio (anuncio_valor, anuncio_desc, fk_usuario_id, fk_veiculo_id) VALUES (?,?,?,?)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('issi', $this->anuncio_valor, $this->anuncio_desc, $this->fk_usuario_id, $this->fk_veiculo_id);

        if ($stmt->execute()) {
            echo "Anúncio criado com sucesso!";
        } else {
            echo "Erro ao criar anúncio: " . $stmt->error;
        }
    }

    // Deleta um anúncio do banco de dados
    public function deletarAnuncio() {
        $sql = "DELETE FROM anuncio WHERE anuncio_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('i', $this->anuncio_id);

        if ($stmt->execute()) {
            echo "Anúncio deletado com sucesso!";
        } else {
            echo "Erro ao deletar anúncio: " . $stmt->error;
        }
    }

    // Lista todos os anúncios no banco de dados
    public function listarAnuncios() {
    $sql = "
        SELECT 
            -- Dados do anúncio
            anuncio.anuncio_id,
            anuncio.anuncio_desc,
            anuncio.anuncio_valor,
            anuncio.anuncio_data_de_criacao,
            anuncio.anuncio_data_de_alteracao,
            combustivel.comb_desc,
            -- Foto do anúncio
            imagem.imagem_url,
            -- Usuário que criou o anúncio
            usuario.usuario_nome,
            
            -- Dados do veículo
            veiculo.veiculo_versao,
            
            -- Modelo do veículo
            modelo.modelo_desc,
            modelo.modelo_valor_fipe,
            
            -- Marca do modelo
            marca.marca_desc,
            
            -- Chassi
            chassi.chassi_desc

        FROM anuncio

        -- Usuário do anúncio
        INNER JOIN usuario 
            ON usuario.usuario_id = anuncio.fk_usuario_id

        -- Veículo do anúncio
        INNER JOIN veiculo 
            ON anuncio.fk_veiculo_id = veiculo.veiculo_id


        -- Veículo -> Modelo
        INNER JOIN modelo 
            ON veiculo.fk_modelo_id = modelo.modelo_id

        -- Modelo -> Marca
        INNER JOIN marca 
            ON modelo.fk_marca_id = marca.marca_id

        -- Veículo -> Chassi
        INNER JOIN chassi 
            ON veiculo.fk_chassi_id = chassi.chassi_id
        inner join combustivel
            on veiculo.fk_combustivel_id = combustivel.comb_id
        inner join imagem
            on anuncio.anuncio_id = imagem.fk_anuncio_id
    ";

    // Preparação e execução
    $stmt = $this->conexao->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Array que receberá os anúncios
    $anuncios = [];
    while ($anuncio = $resultado->fetch_assoc()) {
        $anuncios[] = $anuncio;
    }

    return $anuncios;
}

    // Edita um anúncio
    public function editarAnuncio() {
        $sql = "UPDATE anuncio SET anuncio_desc = ?, anuncio_valor = ? WHERE anuncio_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('ssi', $this->anuncio_desc, $this->anuncio_valor, $this->anuncio_id);

        if ($stmt->execute()) {
            echo "Anúncio editado com sucesso!";
        } else {
            echo "Erro ao editar anúncio: " . $stmt->error;
        }
    }
}
?>
