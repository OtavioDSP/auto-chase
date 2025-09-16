<?php
Class Usuario{
    private $usuario_id;
    private $usuario_nome;
    private $usuario_email;
    private $usuario_senha;
    private $usuario_telefone;
    private $usuario_endereco;
    private $doc_cpf_cnpj;
    private $usuario_nivel_de_acesso;
    private $conexao;

    public function __construct($usuario_id, $usuario_nome, $usuario_email, $usuario_senha, $usuario_telefone, $usuario_endereco, $doc_cpf_cnpj, $usuario_nivel_de_acesso, $conexao){

        $this->usuario_id = $usuario_id;
        $this->usuario_nome = $usuario_nome;
        $this->usuario_email = $usuario_email;
        $this->usuario_senha = $usuario_senha;
        $this->usuario_telefone = $usuario_telefone;
        $this->usuario_endereco = $usuario_endereco;
        $this->doc_cpf_cnpj = $doc_cpf_cnpj;
        $this->usuario_nivel_de_acesso = $usuario_nivel_de_acesso;
        $this->conexao = $conexao;
        
    }
    public function deletarUsuario(){


        $sql = "DELETE FROM Usuario WHERE usuario_id = ?";


        $stmt = $this->conexao->prepare($sql);


        $stmt->bind_param('i',$this->usuario_id);


        if($stmt->execute()){
        echo "Usuario deletado com sucesso";

        } // Dentro da sua classe Usuario
    }



           
    
    public function insereUsuario(){

        $sql = "INSERT INTO usuario (usuario_nome, usuario_email, usuario_senha, usuario_telefone, usuario_endereco, usuario_doc_cpf_cnpj, usuario_nivel_de_acesso) VALUES (?,?,?,?,?,?,DEFAULT)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bind_param('ssssss', 
            $this->usuario_nome,
            $this->usuario_email,
            $this->usuario_senha,
            $this->usuario_endereco,
            $this->usuario_telefone,
            $this->doc_cpf_cnpj,
    
        );
        
        if($stmt->execute()){
            echo "usuario Inserido";
        }else{
            echo "Erro ao inserir usuario". $stmt->error;
        }
    } // Dentro da sua classe Usuario

public function editarUsuario() {
    
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
                    usuario_doc_cpf_cnpj = ?, 
                    usuario_nivel_de_acesso = ? 
                WHERE usuario_id = ?";
                
        $stmt = $this->conexao->prepare($sql);
        
        // Criptografa a NOVA senha antes de salvar
        $senha_hashed = password_hash($this->usuario_senha, PASSWORD_DEFAULT);
        
        // bind_param com 8 parâmetros (7 strings, 1 int)
        $stmt->bind_param('sssssssi',
            $this->usuario_nome,
            $this->usuario_email,
            $senha_hashed, // Usa a nova senha criptografada
            $this->usuario_telefone,
            $this->usuario_endereco,
            $this->doc_cpf_cnpj,
            $this->usuario_nivel_de_acesso,
            $this->usuario_id
        );

    } else {
        
        // CENÁRIO 2: SENHA EM BRANCO - Atualiza tudo, EXCETO a senha
        
        $sql = "UPDATE usuario 
                SET usuario_nome = ?, 
                    usuario_email = ?, 
                    usuario_telefone = ?, 
                    usuario_endereco = ?, 
                    usuario_doc_cpf_cnpj = ?, 
                    usuario_nivel_de_acesso = ? 
                WHERE usuario_id = ?";
                
        $stmt = $this->conexao->prepare($sql);
        
        // bind_param com 7 parâmetros (6 strings, 1 int) - SEM a senha
        $stmt->bind_param('ssssssi',
            $this->usuario_nome,
            $this->usuario_email,
            $this->usuario_telefone,
            $this->usuario_endereco,
            $this->doc_cpf_cnpj,
            $this->usuario_nivel_de_acesso,
            $this->usuario_id
        );
    }

    // A execução é a mesma para os dois cenários
    if ($stmt->execute()) {
        // Redireciona para a lista de usuários com uma mensagem de sucesso
       echo "usuario inserido";
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

}









?>
