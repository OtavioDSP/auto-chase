<?php

Class Cliente{
    private $cliente_id;
    private $cliente_nome;
    private $cliente_email;
    private $cliente_senha;
    private $cliente_telefone;
    private $cliente_endereco;
    private $doc_cpf_cnpj;
    private $conexao;

    public function __construct($cliente_id, $cliente_nome, $cliente_email, $cliente_senha, $cliente_telefone, $cliente_endereco, $doc_cpf_cnpj, $conexao){

        $this->cliente_id = $cliente_id;
        $this->cliente_nome = $cliente_nome;
        $this->cliente_email = $cliente_email;
        $this->cliente_senha = $cliente_senha;
        $this->cliente_telefone = $cliente_telefone;
        $this->cliente_endereco = $cliente_endereco;
        $this->doc_cpf_cnpj = $doc_cpf_cnpj;
        $this->conexao = $conexao;
        
    }
    public function insereCliente(){

        $sql = "INSERT INTO Cliente (cliente_nome, cliente_email, cliente_senha, cliente_senha, cliente_telefone, cliente_endereco, doc_cpf_cnpj) VALUES (?,?,?,?,?,?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bind_param('ssssss', 
            $this->cliente_nome,
            $this->cliente_email,
            $this->cliente_endereco,
            $this->cliente_senha,
            $this->cliente_telefone,
            $this->doc_cpf_cnpj,
        );
        
        if($stmt->execute()){
            echo "cliente Inserido";
        }else{
            echo "Erro ao inserir cliente". $stmt->error;
        }
    } public function deletarCliente(){
        $sql = "DELETE FROM Cliente WHERE cliente_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param('i',$this->cliente_id);
        if($stmt->execute()){

            echo "CLiente deletado com sucesso";
    

        }else{

            echo "erro ao deletar Cliente" .$stmt->error;

        }

    }public function listarCliente(){
        $sql = "
        SELECT 
            *
        FROM 
            Cliente";

            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $clientes = [];

            while($cliente = $resultado->fetch_assoc()){
                $clientes[] = $cliente;
            }

            return $clientes;
        }



}









?>