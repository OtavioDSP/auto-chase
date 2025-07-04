<?php

class Chat{
    private $chat_id;
    private $conteudo;
    private $data_envio;
    private $lido;
    private $cliente_id_fk;
    private $conexao;

    public function __construct($chat_id, $conteudo, $data_envio, $lido, $cliente_id_fk) {
        $this->chat_id = $chat_id;
        $this->conteudo = $conteudo;
        $this->data_envio = $data_envio;
        $this->lido = $lido;
        $this->cliente_id_fk = $cliente_id_fk;

    }
    public function criaChat(){
        $sql = "INSERT INTO chat (chat_id, conteudo, data_envio, lido, cliente_id)  VALUES (?,?,?,?,?)";

        $stmt = $this->conexao->prepare($sql);

        $stmt->bind_param('sssii',
            $this->chat_id, 
            $this->conteudo, 
            $this->data_envio, 
            $this->lido,        
            $this->cliente_id_fk
        );
        if($stmt->execute()){
            echo "chat criado";
        }else{
            echo "Erro ao criar chat". $stmt->error;
        }



    }



}



?>