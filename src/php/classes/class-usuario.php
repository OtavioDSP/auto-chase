<?php
Class Usuario{
    private $usuario_id;
    private $usuario_nome;
    private $usuario_email;
    private $usuario_senha;
    private $usuario_telefone;
    private $usuario_endereco;
    private $doc_cpf_cnpj;
    private $nivel_acesso;
    private $conexao;

    public function __construct($usuario_id, $usuario_nome, $usuario_email, $usuario_senha, $usuario_telefone, $usuario_endereco, $doc_cpf_cnpj, $conexao){

        $this->usuario_id = $usuario_id;
        $this->usuario_nome = $usuario_nome;
        $this->usuario_email = $usuario_email;
        $this->usuario_senha = $usuario_senha;
        $this->usuario_telefone = $usuario_telefone;
        $this->usuario_endereco = $usuario_endereco;
        $this->doc_cpf_cnpj = $doc_cpf_cnpj;
    
        $this->conexao = $conexao;
        
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
    } public function deletarUsuario(){
        $sql = "DELETE FROM Usuario WHERE usuario_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('i',$this->usuario_id);
        if($stmt->execute()){

            echo "Usuario deletado com sucesso";
    

        }else{

            echo "erro ao deletar Usuario" .$stmt->error;

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
        }public function editarUsuario(){
            $sql = "UPDATE Usuario SET usuario_nome = ?, usuario_email = ?, usuario_senha = ?, usuario_telefone = ?, usuario_endereco = ?, usuario_doc_cpf_cnpj = ?, nivel_acesso = ? WHERE usuario_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param('ssssssis',
                $this->usuario_nome,
                $this->usuario_email,
                $this->usuario_senha,
                $this->usuario_telefone,
                $this->usuario_endereco,
                $this->doc_cpf_cnpj,
                $this->usuario_id,
                $this->nivel_acesso
            );
            if($stmt->execute()){
                echo "Usuario editado com sucesso";
            }else{
                echo "Erro ao editar usuario" .$stmt->error;
            }

        }



}









?>