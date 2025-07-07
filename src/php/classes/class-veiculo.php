<?php

Class Veiculo{

    private $carro_id;
    private $carro_descricao;
    private $cor_id;
    private $modelo_id;
    private $chassi_id;
    private $comb_id;
    private $marca_id;
    private $anuncio_id;
    private $conexao;

    public function __construct($carro_id, $carro_descricao, $cor_id, $modelo_id, $chassi_id, $comb_id, $marca_id, $anuncio_id, $conexao) {
        $this->carro_id = $carro_id;
        $this->carro_descricao = $carro_descricao;
        $this->cor_id = $cor_id;
        $this->modelo_id = $modelo_id;
        $this->chassi_id = $chassi_id;
        $this->comb_id = $comb_id;
        $this->marca_id = $marca_id;
        $this->anuncio_id = $anuncio_id;
        $this->conexao = $conexao;
    }

    public function insereCarro(){
        $sql = "INSERT INTO Carro (carro_id, carro_descricao, cor_id, modelo_id, chassi_id, comb_id, marca_id) VALUES (?,?,?,?,?,?,?)";
        
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("issiiii", 
            $this->carro_id, 
            $this->carro_descricao, 
            $this->cor_id, 
            $this->modelo_id, 
            $this->chassi_id, 
            $this->comb_id, 
            $this->marca_id
        );
        if($stmt->execute()){
            echo "veiculo inserida";
        }else{
            echo "Erro ao inserir veiculo". $stmt->error;
        }
        
        
    }



}








// -- TABELA ANUNCIO
// CREATE TABLE Anuncio (
//     id_anuncio INT AUTO_INCREMENT PRIMARY KEY,
//     anuncio_valor DECIMAL(10, 2),
//     data_de_criacao DATE,
//     data_de_exclusao DATE,
//     cliente_id INT,
//     FOREIGN KEY (cliente_id) REFERENCES Cliente(cliente_id)
// );

// -- TABELA FOTOS
// CREATE TABLE Fotos (
//     fotos_id INT AUTO_INCREMENT PRIMARY KEY,
//     foto TEXT,
//     id_anuncio INT,
//     FOREIGN KEY (id_anuncio) REFERENCES Anuncio(id_anuncio)
// );

// -- TABELA COR
// CREATE TABLE Cor (
//     cor_id INT AUTO_INCREMENT PRIMARY KEY,
//     cor_descricao VARCHAR(50)
// );

// -- TABELA CHASSI
// CREATE TABLE Chassi (
//     chassi_id INT AUTO_INCREMENT PRIMARY KEY,
//     chassi_descricao VARCHAR(100)
// );

// -- TABELA COMBUSTIVEL
// CREATE TABLE Combustivel (
//     comb_id INT AUTO_INCREMENT PRIMARY KEY,
//     comb_tipo VARCHAR(50)
// );

// -- TABELA MARCA
// CREATE TABLE Marca (
//     marca_id INT AUTO_INCREMENT PRIMARY KEY,
//     marca_descricao VARCHAR(100)
// );




// -- RELACIONAMENTO ANUNCIO - CARRO (1:1)
// ALTER TABLE Anuncio
// ADD carro_id INT UNIQUE,
// ADD FOREIGN KEY (carro_id) REFERENCES Carro(carro_id);



?>