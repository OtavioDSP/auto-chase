<?php
Class Usuario{
    private $usuario_id;
    private $usuario_nome;
    private $usuario_email;
    private $usuario_senha;
    private $usuario_telefone;
    private $usuario_endereco;
    private $usuario_doc_cpf_cnpj;
    private $usuario_nivel_de_acesso;
    private $conexao;

    public function __construct($usuario_id, $usuario_nome, $usuario_email, $usuario_senha, $usuario_telefone, $usuario_endereco, $usuario_doc_cpf_cnpj, $usuario_nivel_de_acesso, $conexao){

        $this->usuario_id = $usuario_id;
        $this->usuario_nome = $usuario_nome;
        $this->usuario_email = $usuario_email;
        $this->usuario_senha = $usuario_senha;
        $this->usuario_telefone = $usuario_telefone;
        $this->usuario_endereco = $usuario_endereco;
        $this->usuario_doc_cpf_cnpj = $usuario_doc_cpf_cnpj;
        $this->usuario_nivel_de_acesso = $usuario_nivel_de_acesso;
        $this->conexao = $conexao;
        
    }
    public function deletarUsuario($usuario_id){
        $this->conexao->begin_transaction();

        try {
            // 1. Encontrar todos os anúncios (e veículos associados) do usuário
            $sql_anuncios = "SELECT anuncio_id, fk_veiculo_id FROM anuncio WHERE fk_usuario_id = ?";
            $stmt_anuncios = $this->conexao->prepare($sql_anuncios);
            $stmt_anuncios->bind_param('i', $usuario_id);
            $stmt_anuncios->execute();
            $result_anuncios = $stmt_anuncios->get_result();

            $anuncios_ids = [];
            $veiculos_ids = [];
            while ($row = $result_anuncios->fetch_assoc()) {
                $anuncios_ids[] = $row['anuncio_id'];
                $veiculos_ids[] = $row['fk_veiculo_id'];
            }
            $stmt_anuncios->close();

            if (!empty($anuncios_ids)) {
                // 2. Deletar imagens associadas aos anúncios
                // (ON DELETE CASCADE na tabela imagem já faz isso, mas para garantir)
                $sql_delete_imagens = "DELETE FROM imagem WHERE fk_anuncio_id IN (" . implode(',', array_fill(0, count($anuncios_ids), '?')) . ")";
                $stmt_delete_imagens = $this->conexao->prepare($sql_delete_imagens);
                $stmt_delete_imagens->bind_param(str_repeat('i', count($anuncios_ids)), ...$anuncios_ids);
                $stmt_delete_imagens->execute();
                $stmt_delete_imagens->close();

                // 3. Deletar os anúncios
                $sql_delete_anuncios = "DELETE FROM anuncio WHERE fk_usuario_id = ?";
                $stmt_delete_anuncios = $this->conexao->prepare($sql_delete_anuncios);
                $stmt_delete_anuncios->bind_param('i', $usuario_id);
                $stmt_delete_anuncios->execute();
                $stmt_delete_anuncios->close();
            }

            if (!empty($veiculos_ids)) {
                // 4. Deletar os veículos
                $sql_delete_veiculos = "DELETE FROM veiculo WHERE veiculo_id IN (" . implode(',', array_fill(0, count($veiculos_ids), '?')) . ")";
                $stmt_delete_veiculos = $this->conexao->prepare($sql_delete_veiculos);
                $stmt_delete_veiculos->bind_param(str_repeat('i', count($veiculos_ids)), ...$veiculos_ids);
                $stmt_delete_veiculos->execute();
                $stmt_delete_veiculos->close();
            }

            // 5. Deletar o usuário
            $sql_delete_usuario = "DELETE FROM usuario WHERE usuario_id = ?";
            $stmt_delete_usuario = $this->conexao->prepare($sql_delete_usuario);
            $stmt_delete_usuario->bind_param('i', $usuario_id);
            $stmt_delete_usuario->execute();
            $stmt_delete_usuario->close();

            $this->conexao->commit();
            return true;

        } catch (Exception $e) {
            $this->conexao->rollback();
            // Opcional: logar o erro $e->getMessage()
            return false;
        }
    }



           
    
    public function insereUsuario(){

        $sql = "INSERT INTO usuario (usuario_nome, usuario_email, usuario_senha, usuario_telefone, usuario_endereco, usuario_doc_cpf_cnpj, usuario_nivel_de_acesso) VALUES (?,?,?,?,?,?,DEFAULT)";

        $stmt = $this->conexao->prepare($sql);

        // CRIPTOGRAFA A SENHA ANTES DE INSERIR
        $senha_hashed = password_hash($this->usuario_senha, PASSWORD_DEFAULT);

        $stmt->bind_param('ssssss', 
            $this->usuario_nome,
            $this->usuario_email,
            $senha_hashed, // Usa a senha criptografada
            $this->usuario_telefone,
            $this->usuario_endereco,
            $this->usuario_doc_cpf_cnpj,
    
        );
        
        if($stmt->execute()){
            return $stmt->insert_id;
        }else{
            echo "Erro ao inserir usuario". $stmt->error;
        }
    } // Dentro da sua classe Usuario

public function editarUsuario() {
    
    // Inclui o gerenciador de sessão para usar a função eAdmin()
    include_once __DIR__ . '/../../config/env/logout.php';

    // VERIFICA SE UMA NOVA SENHA FOI FORNECIDA
    // A função empty() retorna true para "", null, 0, etc.
    if (!empty($this->usuario_senha)) {
        
        // CENÁRIO 1: SENHA FOI PREENCHIDA - Atualiza todos os campos, incluindo a senha
        
        $sql = "UPDATE usuario 
            SET usuario_nome = ?, 
                usuario_email = ?, 
                usuario_senha = ?, 
                usuario_telefone = ?, 
                usuario_endereco = ?, 
                usuario_doc_cpf_cnpj = ?
                " . (eAdmin() ? ", usuario_nivel_de_acesso = ? " : "") . "
            WHERE usuario_id = ?";

        $stmt = $this->conexao->prepare($sql);
        
        // Criptografa a NOVA senha antes de salvar
        $senha_hashed = password_hash($this->usuario_senha, PASSWORD_DEFAULT);
        
        // bind_param com 8 parâmetros (7 strings, 1 int)
        if (eAdmin()) {
            $stmt->bind_param('sssssssi',
                $this->usuario_nome, $this->usuario_email, $senha_hashed,
                $this->usuario_telefone, $this->usuario_endereco, $this->usuario_doc_cpf_cnpj,
                $this->usuario_nivel_de_acesso, $this->usuario_id
            );
        } else {
            $stmt->bind_param('ssssssi',
                $this->usuario_nome, $this->usuario_email, $senha_hashed,
                $this->usuario_telefone, $this->usuario_endereco, $this->usuario_doc_cpf_cnpj,
                $this->usuario_id
            );
        }
    } else {
        
        // CENÁRIO 2: SENHA EM BRANCO - Atualiza tudo, EXCETO a senha
        
        $sql = "UPDATE usuario 
            SET usuario_nome = ?, 
                usuario_email = ?, 
                usuario_telefone = ?, 
                usuario_endereco = ?, 
                usuario_doc_cpf_cnpj = ?
                " . (eAdmin() ? ", usuario_nivel_de_acesso = ? " : "") . "
            WHERE usuario_id = ?";

        $stmt = $this->conexao->prepare($sql);
        
        // bind_param com 7 parâmetros (6 strings, 1 int) - SEM a senha
        if (eAdmin()) {
            $stmt->bind_param('ssssssi',
                $this->usuario_nome, $this->usuario_email,
                $this->usuario_telefone, $this->usuario_endereco, $this->usuario_doc_cpf_cnpj,
                $this->usuario_nivel_de_acesso, $this->usuario_id
            );
        } else {
            $stmt->bind_param('sssssi',
                $this->usuario_nome, $this->usuario_email,
                $this->usuario_telefone, $this->usuario_endereco, $this->usuario_doc_cpf_cnpj,
                $this->usuario_id
            );
        }
    }

    // A execução é a mesma para os dois cenários
    if ($stmt->execute()) {
        // Redireciona para a lista de usuários com uma mensagem de sucesso
       echo "Usuário editado com sucesso!";
        exit();
    } else {
        echo "Erro ao editar usuário: " . $stmt->error;
    }

    }public function listarUsuario(){
        $sql = "
        SELECT 
            *
        FROM 
            Usuario";

            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $usuarios = [];

            while($usuario = $resultado->fetch_assoc()){
                $usuarios[] = $usuario;
            }

            return $usuarios;
        }
        public function buscarUsuarioPorId($usuario_id) {
            $sql = "SELECT * FROM usuario WHERE usuario_id = ?";
            
            $stmt = $this->conexao->prepare($sql);
            
            // Vincula o ID do usuário ao placeholder da consulta
            // 'i' indica que o parâmetro é um inteiro
            $stmt->bind_param('i', $usuario_id);
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            // Retorna a primeira linha do resultado como um array associativo
            // Ou 'null' se nenhum usuário for encontrado
            return $result->fetch_assoc();
        }
        public function buscarUsuarioPorEmail($usuario_email) {
            $sql = "SELECT * FROM usuario WHERE usuario_email = ?";
            
            $stmt = $this->conexao->prepare($sql);
            
            $stmt->bind_param('s', $usuario_email);
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            // Retorna a primeira linha do resultado como um array associativo
            // Ou 'null' se nenhum usuário for encontrado
            return $result->fetch_assoc();
        }

}









?>
