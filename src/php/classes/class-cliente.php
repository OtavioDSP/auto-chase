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
    }




}









?>