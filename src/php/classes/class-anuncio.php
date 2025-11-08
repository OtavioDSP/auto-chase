<?php
class Anuncio {

    public $anuncio_id;
    private $anuncio_desc;

    private $fk_usuario_id;
    private $fk_veiculo_id;
    private $anuncio_valor;
    private $anuncio_status;
    private $conexao;
    public function __construct($anuncio_id, $anuncio_desc, $fk_usuario_id, $fk_veiculo_id, $anuncio_valor, $anuncio_status, $conexao) {
        $this->anuncio_id = $anuncio_id;
        $this->anuncio_desc = $anuncio_desc;
        $this->fk_usuario_id = $fk_usuario_id;
        $this->fk_veiculo_id = $fk_veiculo_id;
        $this->anuncio_valor = $anuncio_valor;
        $this->anuncio_status = $anuncio_status;
        $this->conexao = $conexao;
    }

    // public getAnuncio_id(){
    //     return $this->anuncio_id;
    // }
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
        return $this->conexao->insert_id;
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
            anuncio.anuncio_status,
            anuncio.anuncio_data_de_criacao,
            anuncio.anuncio_data_de_alteracao,
            anuncio.fk_usuario_id, -- Adicionado para verificação de permissão
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
        // CORREÇÃO: Removida a vírgula extra antes de "anuncio_status".
        $sql = "UPDATE anuncio SET anuncio_desc = ?, anuncio_valor = ?, anuncio_status = ? WHERE anuncio_id = ?";
        $stmt = $this->conexao->prepare($sql);

        // CORREÇÃO: Ajustado o bind_param para os tipos corretos.
        // anuncio_desc (string), anuncio_valor (double/decimal), anuncio_status (string), anuncio_id (integer)
        // Tipos: s = string, d = double, i = integer
        $stmt->bind_param('sdsi', $this->anuncio_desc, $this->anuncio_valor, $this->anuncio_status, $this->anuncio_id);

        if ($stmt->execute()) {
            echo "Anúncio editado com sucesso!";
        } else {
            echo "Erro ao editar anúncio: " . $stmt->error;
        }
    }
    public function buscarAnuncioPorId($anuncio_id) {
        $sql = "SELECT * FROM anuncio WHERE anuncio_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('i', $anuncio_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    // Em: class-anuncio.php

public static function buscarOpcoesEnum($conexao, $coluna) {
    
    $tabela = "anuncio"; 

    // =======================================================
    // CORREÇÃO:
    // O comando SHOW COLUMNS não aceita '?' (placeholders) no LIKE.
    // Como a variável $coluna é controlada pelo desenvolvedor (ex: 'anuncio_status')
    // e não vem do usuário, é seguro concatenar diretamente.
    // =======================================================
    $sql = "SHOW COLUMNS FROM {$tabela} LIKE '{$coluna}'";

    // Usar query() é mais simples e direto, já que não há parâmetros
    $resultado = $conexao->query($sql); // <-- Linha 145 (MODIFICADA)
    
    // Tratamento de erro para query()
    if ($resultado === false) {
        throw new Exception("Falha ao preparar/executar (SHOW COLUMNS): " . $conexao->error);
    }

    // O resto do seu código continua igual...
    if ($resultado->num_rows == 0) {
        throw new Exception("Coluna '{$coluna}' não encontrada na tabela '{$tabela}'.");
    }

    $coluna_info = $resultado->fetch_assoc();

    preg_match_all("/'([^']+)'/", $coluna_info['Type'], $matches);

    if (isset($matches[1]) && !empty($matches[1])) {
        return $matches[1];
    } else {
        throw new Exception("A coluna '{$coluna}' não parece ser do tipo ENUM.");
    }
}
}

?>
