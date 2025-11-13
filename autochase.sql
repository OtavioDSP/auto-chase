-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20251026.88b7dfd0f0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 12, 2025 at 04:15 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `autochase`
--

-- --------------------------------------------------------

--
-- Table structure for table `anuncio`
--

CREATE TABLE `anuncio` (
  `anuncio_id` int NOT NULL,
  `anuncio_valor` decimal(10,2) NOT NULL,
  `anuncio_data_de_alteracao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `anuncio_data_de_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `anuncio_desc` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `anuncio_status` enum('ATIVO','INATIVO','VENDIDO') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'ATIVO',
  `fk_usuario_id` int NOT NULL,
  `fk_veiculo_id` int NOT NULL COMMENT 'FK do veículo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anuncio`
--

INSERT INTO `anuncio` (`anuncio_id`, `anuncio_valor`, `anuncio_data_de_alteracao`, `anuncio_data_de_criacao`, `anuncio_desc`, `anuncio_status`, `fk_usuario_id`, `fk_veiculo_id`) VALUES
(1, 120000.00, '2025-11-02 18:15:14', '2025-11-02 18:15:14', 'Corolla 2020 semi-novo', 'ATIVO', 1, 1),
(2, 115000.00, '2025-11-02 18:15:14', '2025-11-02 18:15:14', 'Civic 2021', 'ATIVO', 2, 2),
(3, 140000.00, '2025-11-02 18:15:14', '2025-11-02 18:15:14', 'Fusion 2022', 'INATIVO', 1, 3),
(4, 55000.00, '2025-11-02 18:15:14', '2025-11-02 18:15:14', 'Gol 2023', 'VENDIDO', 2, 4),
(6, 8000.00, '2025-11-02 19:11:28', '2025-11-02 19:11:28', 'vovorolla lindo', 'ATIVO', 1, 7),
(8, 2000.00, '2025-11-07 22:22:13', '2025-11-02 19:21:35', 'RS6', 'ATIVO', 1, 9),
(9, 11111.00, '2025-11-02 22:27:39', '2025-11-02 22:27:39', '1aaaaa', 'ATIVO', 1, 10),
(10, 1111.00, '2025-11-02 22:33:14', '2025-11-02 22:33:14', '1111', 'ATIVO', 1, 11),
(11, 11111.00, '2025-11-02 22:38:08', '2025-11-02 22:38:08', '1111', 'ATIVO', 1, 12),
(12, 111111.00, '2025-11-02 23:04:16', '2025-11-02 23:04:16', 'TESTE', 'ATIVO', 1, 13),
(13, 1.00, '2025-11-03 00:03:20', '2025-11-03 00:03:20', 'deve ter so 1', 'ATIVO', 1, 15),
(14, 10000.00, '2025-11-08 17:27:06', '2025-11-03 00:04:27', 'Audi teste', 'INATIVO', 1, 16),
(15, 2222.00, '2025-11-07 20:00:00', '2025-11-07 20:00:00', '2222', 'ATIVO', 1, 17),
(16, 55555.00, '2025-11-07 20:01:01', '2025-11-07 20:01:01', 'gggg', 'ATIVO', 1, 18),
(17, 4555566.00, '2025-11-07 20:03:11', '2025-11-07 20:03:11', 'ssss', 'ATIVO', 1, 19),
(18, 55555.00, '2025-11-07 20:08:09', '2025-11-07 20:08:09', 'sadassda', 'ATIVO', 1, 20),
(19, 55555.00, '2025-11-07 20:11:03', '2025-11-07 20:11:03', 'sadassda', 'ATIVO', 1, 21),
(20, 1111.00, '2025-11-08 20:18:25', '2025-11-08 20:18:25', 'aaaa', 'ATIVO', 1, 22),
(21, 1111.00, '2025-11-08 20:19:52', '2025-11-08 20:19:52', '111', 'ATIVO', 1, 23),
(22, 33333.00, '2025-11-12 02:30:52', '2025-11-08 21:34:53', 'teste civic', 'ATIVO', 6, 24);

-- --------------------------------------------------------

--
-- Table structure for table `chassi`
--

CREATE TABLE `chassi` (
  `chassi_id` int NOT NULL,
  `chassi_desc` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chassi`
--

INSERT INTO `chassi` (`chassi_id`, `chassi_desc`) VALUES
(1, 'SW'),
(2, 'Sedan'),
(3, 'SUV'),
(4, 'Pickup'),
(6, 'Coupé');

-- --------------------------------------------------------

--
-- Table structure for table `combustivel`
--

CREATE TABLE `combustivel` (
  `comb_id` int NOT NULL,
  `comb_desc` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `combustivel`
--

INSERT INTO `combustivel` (`comb_id`, `comb_desc`) VALUES
(1, 'Gasolina'),
(2, 'Álcool'),
(3, 'Diesel'),
(4, 'GAY');

-- --------------------------------------------------------

--
-- Table structure for table `cor`
--

CREATE TABLE `cor` (
  `cor_id` int NOT NULL,
  `cor_desc` varchar(55) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cor`
--

INSERT INTO `cor` (`cor_id`, `cor_desc`) VALUES
(1, 'Pretoo'),
(2, 'Branco'),
(3, 'Prata'),
(4, 'Vermelho'),
(5, 'Verde'),
(9, 'Amarelo');

-- --------------------------------------------------------

--
-- Table structure for table `imagem`
--

CREATE TABLE `imagem` (
  `imagem_id` int NOT NULL,
  `imagem_url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fk_anuncio_id` int NOT NULL,
  `imagem_data_insercao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `imagem`
--

INSERT INTO `imagem` (`imagem_id`, `imagem_url`, `fk_anuncio_id`, `imagem_data_insercao`) VALUES
(1, '/images/corolla_frente.jpg', 1, '2025-11-02 18:15:14'),
(2, '/images/corolla_interior.jpg', 1, '2025-11-02 18:15:14'),
(3, '../../uploads/104616fd-c7b4-4a60-8a65-b9b6f5ec4c6f_9e60e5d4-e0ad-438e-b45c-af931241dd7f.webp', 2, '2025-11-02 18:15:14'),
(4, '/images/fusion_completo.jpg', 3, '2025-11-02 18:15:14'),
(6, '../../uploads/Marca 01.jpg', 8, '2025-11-02 19:21:35'),
(7, '../../uploads/5396239.png', 9, '2025-11-02 22:27:39'),
(8, 'E:\\laragon\\www\\TCC\\auto-chase\\src\\php\\global/../../uploads/6907dc2a8a434-cosmic-2nog8px0dq0y2q24.jpg', 10, '2025-11-02 22:33:14'),
(9, 'E:\\laragon\\www\\TCC\\auto-chase\\src\\php\\global/../../uploads/6907dc2a98787-images.jpeg', 10, '2025-11-02 22:33:14'),
(10, 'E:\\laragon\\www\\TCC\\auto-chase\\src\\php\\global/../../uploads/6907dc2aa9f27-audi-rs6-4.0-v8-tfsi-mhev-avant-performance-tiptronic-wmimagem08305069556.jpg', 10, '2025-11-02 22:33:14'),
(11, 'E:\\laragon\\www\\TCC\\auto-chase\\src\\php\\global/../../uploads/6907dc2abd09c-i-made-the-praying-meme-v0-wjh3bsyxlhse1.webp', 10, '2025-11-02 22:33:14'),
(12, 'E:\\laragon\\www\\TCC\\auto-chase\\src\\php\\global/../../uploads/6907dc2ac93ce-2203422.png', 10, '2025-11-02 22:33:14'),
(13, 'E:\\laragon\\www\\TCC\\auto-chase\\src\\php\\global/../../uploads/6907dc2ad78a1-5396239.png', 10, '2025-11-02 22:33:14'),
(19, 'uploads/6907e370c9849-cosmic-2nog8px0dq0y2q24.jpg', 12, '2025-11-02 23:04:16'),
(20, 'uploads/6907e370ebc25-images.jpeg', 12, '2025-11-02 23:04:16'),
(21, 'uploads/6907e3711636d-audi-rs6-4.0-v8-tfsi-mhev-avant-performance-tiptronic-wmimagem08305069556.jpg', 12, '2025-11-02 23:04:17'),
(22, '../../uploads/audi-rs6-4.0-v8-tfsi-mhev-avant-performance-tiptronic-wmimagem08305069556.jpg', 13, '2025-11-03 00:03:20'),
(25, 'uploads/Marca 02.jpg', 18, '2025-11-07 20:08:09'),
(26, '../../uploads/Marca 02.jpg', 19, '2025-11-07 20:11:03'),
(27, '../../uploads/imagemlegaldeteaaa.webp', 11, '2025-11-08 17:23:22'),
(28, '../../uploads/imagem.webp', 14, '2025-11-08 17:27:06'),
(29, 'src/uploads/audi-rs6-4.0-v8-tfsi-mhev-avant-performance-tiptronic-wmimagem08305069556.jpg', 21, '2025-11-08 20:19:52'),
(30, 'src/uploads/images.jpeg', 22, '2025-11-08 21:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `marca`
--

CREATE TABLE `marca` (
  `marca_id` int NOT NULL,
  `marca_desc` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marca`
--

INSERT INTO `marca` (`marca_id`, `marca_desc`) VALUES
(1, 'Toyotaa'),
(2, 'Honda'),
(3, 'Ford'),
(4, 'Volkswagen'),
(6, 'Ferrari'),
(9, 'Audi'),
(10, 'Mazda ');

-- --------------------------------------------------------

--
-- Table structure for table `modelo`
--

CREATE TABLE `modelo` (
  `modelo_id` int NOT NULL,
  `modelo_desc` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  `modelo_valor_fipe` decimal(10,2) NOT NULL,
  `fk_Marca_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modelo`
--

INSERT INTO `modelo` (`modelo_id`, `modelo_desc`, `modelo_valor_fipe`, `fk_Marca_id`) VALUES
(1, 'Corolla', 0.00, 1),
(2, 'Civic', 19000.00, 2),
(3, 'Corolla', 95000.00, 1),
(4, 'Gol', 45000.00, 4),
(5, 'Fusion', 100000.00, 3),
(7, 'RS6', 111111.00, 9),
(8, 'RX7', 70000.00, 10);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int NOT NULL,
  `usuario_nome` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `usuario_senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `usuario_nivel_de_acesso` enum('ADMIN','USUARIO') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'USUARIO',
  `usuario_email` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  `usuario_telefone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `usuario_endereco` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `usuario_doc_cpf_cnpj` varchar(25) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nome`, `usuario_senha`, `usuario_nivel_de_acesso`, `usuario_email`, `usuario_telefone`, `usuario_endereco`, `usuario_doc_cpf_cnpj`) VALUES
(1, 'Administrador', 'admin123', 'ADMIN', 'admin@example.com', '999999999', 'Rua 1, 123', '12345678901'),
(2, 'Usuário Teste', 'usuario123', 'USUARIO', 'usuario@example.com', '988888888', 'Rua 2, 456', '98765432100'),
(5, 'teste', '$2y$10$VSLKDlcFhFGVChLp6XiDYuSJNudRWcj90G0NySoTaFQhMZteIWWnm', 'ADMIN', 'teste@gmail.com', 'teste', '2222222', '111.131.111-11'),
(6, 'usuario teste', '$2y$10$USfTwu700aUcQ.ZS.vUT..pz6aZgMSbQ.zw5QjM4keyJZIWD9be1G', 'USUARIO', 'teste1@gmail.com', '6666666', 'rua ', '111.144.111-11');

-- --------------------------------------------------------

--
-- Table structure for table `veiculo`
--

CREATE TABLE `veiculo` (
  `veiculo_id` int NOT NULL,
  `veiculo_quilometragem` decimal(10,2) NOT NULL,
  `fk_Chassi_id` int NOT NULL,
  `fk_Cor_id` int NOT NULL,
  `fk_Modelo_id` int NOT NULL,
  `fk_combustivel_id` int NOT NULL,
  `veiculo_versao` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `veiculo_ano` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `veiculo`
--

INSERT INTO `veiculo` (`veiculo_id`, `veiculo_quilometragem`, `fk_Chassi_id`, `fk_Cor_id`, `fk_Modelo_id`, `fk_combustivel_id`, `veiculo_versao`, `veiculo_ano`) VALUES
(1, 25000.00, 1, 2, 1, 1, 'Versão 2023', 2020),
(2, 15000.00, 2, 2, 2, 1, 'Versão 2021', 2021),
(3, 5000.00, 3, 3, 3, 3, 'Versão 2022', 2022),
(4, 0.00, 4, 4, 4, 4, 'Versão 2023', 2023),
(7, 9999.00, 2, 2, 1, 4, 'XEi', 1995),
(8, 9999.00, 2, 2, 1, 4, 'XEi', 1995),
(9, 3400.00, 2, 2, 1, 1, 'Avant MHEV Diesel', 2021),
(10, 111.00, 1, 1, 1, 1, '1111', 1111),
(11, 1111.00, 1, 1, 1, 1, '1111', 1111),
(12, 1111.00, 1, 1, 2, 1, '1111', 1111),
(13, 1111.00, 1, 1, 1, 1, 'TESTE ', 1111),
(14, 111.00, 1, 1, 1, 1, '111', 1111),
(15, 111.00, 1, 1, 1, 1, '111', 1111),
(16, 200000.00, 1, 5, 7, 2, '11', 2015),
(17, 111.00, 1, 1, 1, 1, 'aaa', 1111),
(18, 888.00, 1, 1, 1, 1, 'hhhh', 8888),
(19, 5555.00, 1, 1, 1, 1, 'ssdsd', 5555),
(20, 3333.00, 1, 1, 1, 1, 'asda', 6666),
(21, 3333.00, 1, 1, 1, 1, 'asda', 6666),
(22, 111.00, 1, 1, 2, 1, '1111', 1111),
(23, 111.00, 1, 1, 2, 1, 'saasa', 1111),
(24, 1111.00, 1, 1, 2, 1, 'ssss', 2011);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anuncio`
--
ALTER TABLE `anuncio`
  ADD PRIMARY KEY (`anuncio_id`),
  ADD KEY `fk_usuario_id` (`fk_usuario_id`),
  ADD KEY `fk_veiculo_id` (`fk_veiculo_id`);

--
-- Indexes for table `chassi`
--
ALTER TABLE `chassi`
  ADD PRIMARY KEY (`chassi_id`);

--
-- Indexes for table `combustivel`
--
ALTER TABLE `combustivel`
  ADD PRIMARY KEY (`comb_id`);

--
-- Indexes for table `cor`
--
ALTER TABLE `cor`
  ADD PRIMARY KEY (`cor_id`);

--
-- Indexes for table `imagem`
--
ALTER TABLE `imagem`
  ADD PRIMARY KEY (`imagem_id`),
  ADD UNIQUE KEY `imagem_url` (`imagem_url`),
  ADD KEY `fk_anuncio_id` (`fk_anuncio_id`);

--
-- Indexes for table `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`marca_id`);

--
-- Indexes for table `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`modelo_id`),
  ADD KEY `fk_Marca_id` (`fk_Marca_id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Indexes for table `veiculo`
--
ALTER TABLE `veiculo`
  ADD PRIMARY KEY (`veiculo_id`),
  ADD KEY `fk_Chassi_id` (`fk_Chassi_id`),
  ADD KEY `fk_Cor_id` (`fk_Cor_id`),
  ADD KEY `fk_Modelo_id` (`fk_Modelo_id`),
  ADD KEY `fk_combustivel_id` (`fk_combustivel_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anuncio`
--
ALTER TABLE `anuncio`
  MODIFY `anuncio_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `chassi`
--
ALTER TABLE `chassi`
  MODIFY `chassi_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `combustivel`
--
ALTER TABLE `combustivel`
  MODIFY `comb_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cor`
--
ALTER TABLE `cor`
  MODIFY `cor_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `imagem`
--
ALTER TABLE `imagem`
  MODIFY `imagem_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `marca`
--
ALTER TABLE `marca`
  MODIFY `marca_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `modelo`
--
ALTER TABLE `modelo`
  MODIFY `modelo_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `veiculo`
--
ALTER TABLE `veiculo`
  MODIFY `veiculo_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anuncio`
--
ALTER TABLE `anuncio`
  ADD CONSTRAINT `anuncio_ibfk_1` FOREIGN KEY (`fk_usuario_id`) REFERENCES `usuario` (`usuario_id`),
  ADD CONSTRAINT `anuncio_ibfk_2` FOREIGN KEY (`fk_veiculo_id`) REFERENCES `veiculo` (`veiculo_id`);

--
-- Constraints for table `imagem`
--
ALTER TABLE `imagem`
  ADD CONSTRAINT `imagem_ibfk_1` FOREIGN KEY (`fk_anuncio_id`) REFERENCES `anuncio` (`anuncio_id`) ON DELETE CASCADE;

--
-- Constraints for table `modelo`
--
ALTER TABLE `modelo`
  ADD CONSTRAINT `modelo_ibfk_1` FOREIGN KEY (`fk_Marca_id`) REFERENCES `marca` (`marca_id`);

--
-- Constraints for table `veiculo`
--
ALTER TABLE `veiculo`
  ADD CONSTRAINT `veiculo_ibfk_1` FOREIGN KEY (`fk_Chassi_id`) REFERENCES `chassi` (`chassi_id`),
  ADD CONSTRAINT `veiculo_ibfk_2` FOREIGN KEY (`fk_Cor_id`) REFERENCES `cor` (`cor_id`),
  ADD CONSTRAINT `veiculo_ibfk_3` FOREIGN KEY (`fk_Modelo_id`) REFERENCES `modelo` (`modelo_id`),
  ADD CONSTRAINT `veiculo_ibfk_4` FOREIGN KEY (`fk_combustivel_id`) REFERENCES `combustivel` (`comb_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
