<?php

Class Veiculo{



}





// CREATE DATABASE IF NOT EXISTS autochase;
// USE autochase;

// -- TABELA CLIENTE
// CREATE TABLE Cliente (
//     cliente_id INT AUTO_INCREMENT PRIMARY KEY,
//     cliente_nome VARCHAR(100),
//     cliente_email VARCHAR(100) UNIQUE,
//     cliente_senha VARCHAR(100),
//     cliente_telefone VARCHAR(20),
//     cliente_endereco VARCHAR(200),
//     doc_cpf_cnpj VARCHAR(20) UNIQUE
// );

// -- TABELA CHAT
// CREATE TABLE Chat (
//     chat_id INT AUTO_INCREMENT PRIMARY KEY,
//     conteudo TEXT,
//     data_envio DATETIME,
//     lido BOOLEAN DEFAULT FALSE,
//     cliente_id INT,
//     FOREIGN KEY (cliente_id) REFERENCES Cliente(cliente_id)
// );

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

// -- TABELA FIPE
// CREATE TABLE Fipe (
//     fipe_id INT AUTO_INCREMENT PRIMARY KEY,
//     fipe_valor DECIMAL(10,2)
// );

// -- TABELA MODELO
// CREATE TABLE Modelo (
//     modelo_id INT AUTO_INCREMENT PRIMARY KEY,
//     marca_id INT,
//     fipe_id INT,
//     FOREIGN KEY (marca_id) REFERENCES Marca(marca_id),
//     FOREIGN KEY (fipe_id) REFERENCES Fipe(fipe_id)
// );

// -- TABELA CARRO
// CREATE TABLE Carro (
//     carro_id INT AUTO_INCREMENT PRIMARY KEY,
//     carro_descricao VARCHAR(255),
//     cor_id INT,
//     modelo_id INT,
//     chassi_id INT,
//     comb_id INT,
//     FOREIGN KEY (cor_id) REFERENCES Cor(cor_id),
//     FOREIGN KEY (modelo_id) REFERENCES Modelo(modelo_id),
//     FOREIGN KEY (chassi_id) REFERENCES Chassi(chassi_id),
//     FOREIGN KEY (comb_id) REFERENCES Combustivel(comb_id)
// );

// -- RELACIONAMENTO ANUNCIO - CARRO (1:1)
// ALTER TABLE Anuncio
// ADD carro_id INT UNIQUE,
// ADD FOREIGN KEY (carro_id) REFERENCES Carro(carro_id);



?>