-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/11/2025 às 06:20
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `auto-chase`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `anuncio`
--

CREATE TABLE `anuncio` (
  `anuncio_id` int(11) NOT NULL,
  `anuncio_valor` decimal(10,2) NOT NULL,
  `anuncio_data_de_alteracao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `anuncio_data_de_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `anuncio_desc` varchar(50) DEFAULT NULL,
  `anuncio_status` enum('ATIVO','INATIVO','VENDIDO') NOT NULL DEFAULT 'ATIVO',
  `fk_usuario_id` int(11) NOT NULL,
  `fk_veiculo_id` int(11) NOT NULL COMMENT 'FK do veículo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `anuncio`
--

INSERT INTO `anuncio` (`anuncio_id`, `anuncio_valor`, `anuncio_data_de_alteracao`, `anuncio_data_de_criacao`, `anuncio_desc`, `anuncio_status`, `fk_usuario_id`, `fk_veiculo_id`) VALUES
(2, 115000.00, '2025-11-02 18:15:14', '2025-11-02 18:15:14', 'Civic 2021', 'ATIVO', 2, 2),
(3, 140000.00, '2025-11-02 18:15:14', '2025-11-02 18:15:14', 'Fusion 2022', 'INATIVO', 1, 3),
(4, 55000.00, '2025-11-02 18:15:14', '2025-11-02 18:15:14', 'Gol 2023', 'VENDIDO', 2, 4),
(6, 8000.00, '2025-11-02 19:11:28', '2025-11-02 19:11:28', 'vovorolla lindo', 'ATIVO', 1, 7),
(8, 2000.00, '2025-11-07 22:22:13', '2025-11-02 19:21:35', 'RS6', 'ATIVO', 1, 9),
(9, 11111.00, '2025-11-02 22:27:39', '2025-11-02 22:27:39', '1aaaaa', 'ATIVO', 1, 10),
(11, 11111.00, '2025-11-02 22:38:08', '2025-11-02 22:38:08', '1111', 'ATIVO', 1, 12),
(12, 111111.00, '2025-11-02 23:04:16', '2025-11-02 23:04:16', 'TESTE', 'ATIVO', 1, 13),
(13, 1.00, '2025-11-03 00:03:20', '2025-11-03 00:03:20', 'deve ter so 1', 'ATIVO', 1, 15),
(14, 10000.00, '2025-11-08 17:27:06', '2025-11-03 00:04:27', 'Audi teste', 'INATIVO', 1, 16),
(15, 2222.00, '2025-11-07 20:00:00', '2025-11-07 20:00:00', '2222', 'ATIVO', 1, 17),
(16, 55555.00, '2025-11-07 20:01:01', '2025-11-07 20:01:01', 'gggg', 'ATIVO', 1, 18),
(17, 4555566.00, '2025-11-07 20:03:11', '2025-11-07 20:03:11', 'ssss', 'ATIVO', 1, 19),
(18, 55555.00, '2025-11-07 20:08:09', '2025-11-07 20:08:09', 'sadassda', 'ATIVO', 1, 20),
(20, 1111.00, '2025-11-08 20:18:25', '2025-11-08 20:18:25', 'aaaa', 'ATIVO', 1, 22),
(22, 33333.00, '2025-11-12 02:30:52', '2025-11-08 21:34:53', 'teste civic', 'ATIVO', 6, 24),
(23, 99922.00, '2025-11-13 03:35:49', '2025-11-13 03:35:49', 'pica', 'ATIVO', 5, 25),
(24, 1000900.90, '2025-11-17 04:18:45', '2025-11-16 22:40:34', 'wiger V8 Biturbo 4.8L', 'ATIVO', 5, 26),
(25, 50100.00, '2025-11-17 04:25:48', '2025-11-17 04:25:48', 'Manual F23 - Exclusivo', 'ATIVO', 5, 27);

-- --------------------------------------------------------

--
-- Estrutura para tabela `chassi`
--

CREATE TABLE `chassi` (
  `chassi_id` int(11) NOT NULL,
  `chassi_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chassi`
--

INSERT INTO `chassi` (`chassi_id`, `chassi_desc`) VALUES
(1, 'SW'),
(2, 'Sedan'),
(3, 'SUV'),
(4, 'Pickup'),
(6, 'Coupé'),
(7, 'Hatchback'),
(8, 'Shooting Brake'),
(9, 'Roadster'),
(10, 'Cabriolet'),
(11, 'Spyder'),
(12, 'Barchetta'),
(13, 'Xibiu');

-- --------------------------------------------------------

--
-- Estrutura para tabela `combustivel`
--

CREATE TABLE `combustivel` (
  `comb_id` int(11) NOT NULL,
  `comb_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `combustivel`
--

INSERT INTO `combustivel` (`comb_id`, `comb_desc`) VALUES
(1, 'Gasolina'),
(2, 'Álcool'),
(3, 'Diesel'),
(4, 'GAY'),
(6, 'GNV'),
(7, 'Flex');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cor`
--

CREATE TABLE `cor` (
  `cor_id` int(11) NOT NULL,
  `cor_desc` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cor`
--

INSERT INTO `cor` (`cor_id`, `cor_desc`) VALUES
(1, 'Preto'),
(2, 'Branco'),
(3, 'Prata'),
(4, 'Vermelho'),
(5, 'Verde'),
(9, 'Amarelo'),
(10, 'Azul'),
(11, 'Rosa'),
(12, 'Roxo'),
(14, 'Cinza'),
(16, 'AZUL GREMIO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagem`
--

CREATE TABLE `imagem` (
  `imagem_id` int(11) NOT NULL,
  `imagem_url` varchar(255) NOT NULL,
  `fk_anuncio_id` int(11) NOT NULL,
  `imagem_data_insercao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `imagem`
--

INSERT INTO `imagem` (`imagem_id`, `imagem_url`, `fk_anuncio_id`, `imagem_data_insercao`) VALUES
(31, 'src/uploads/Jason_and_Lucia_01_landscape.jpg', 23, '2025-11-13 03:35:49'),
(32, 'src/uploads/G54VbpYW8AAC9FU.jpg', 24, '2025-11-16 22:40:34'),
(33, 'src/uploads/D_NQ_NP_2X_798131-MLB97216666515_112025-T-vectra-elite-24-mpfi-16v-flexpower-aut.webp', 25, '2025-11-17 04:25:48');

-- --------------------------------------------------------

--
-- Estrutura para tabela `marca`
--

CREATE TABLE `marca` (
  `marca_id` int(11) NOT NULL,
  `marca_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `marca`
--

INSERT INTO `marca` (`marca_id`, `marca_desc`) VALUES
(1, 'Toyota'),
(2, 'Honda'),
(3, 'Ford'),
(4, 'Volkswagen'),
(6, 'Ferrari'),
(9, 'Audi'),
(10, 'Mazda '),
(13, 'KOKOKOx'),
(15, 'Chevrolet');

-- --------------------------------------------------------

--
-- Estrutura para tabela `modelo`
--

CREATE TABLE `modelo` (
  `modelo_id` int(11) NOT NULL,
  `modelo_desc` varchar(55) NOT NULL,
  `modelo_valor_fipe` decimal(10,2) NOT NULL,
  `fk_Marca_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `modelo`
--

INSERT INTO `modelo` (`modelo_id`, `modelo_desc`, `modelo_valor_fipe`, `fk_Marca_id`) VALUES
(1, 'Corolla', 0.00, 1),
(2, 'Civic', 19000.00, 2),
(3, 'Corolla Cross', 300000.00, 1),
(4, 'Gol', 45000.00, 4),
(5, 'Fusion', 100000.00, 3),
(7, 'RS6', 111111.00, 9),
(8, 'RX7', 70000.00, 10),
(9, 'XUXUXU2', 2.00, 13),
(10, 'Vectra', 29857.62, 15);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `usuario_nome` varchar(30) NOT NULL,
  `usuario_senha` varchar(255) NOT NULL,
  `usuario_nivel_de_acesso` enum('ADMIN','USUARIO') NOT NULL DEFAULT 'USUARIO',
  `usuario_email` varchar(55) NOT NULL,
  `usuario_telefone` varchar(20) NOT NULL,
  `usuario_endereco` varchar(50) NOT NULL,
  `usuario_doc_cpf_cnpj` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_nome`, `usuario_senha`, `usuario_nivel_de_acesso`, `usuario_email`, `usuario_telefone`, `usuario_endereco`, `usuario_doc_cpf_cnpj`) VALUES
(1, 'Administrador', 'admin123', 'ADMIN', 'admin@example.com', '999999999', 'Rua 1, 123', '12345678901'),
(2, 'Usuário Teste', 'usuario123', 'USUARIO', 'usuario@example.com', '988888888', 'Rua 2, 456', '98765432100'),
(5, 'teste', '$2y$10$VSLKDlcFhFGVChLp6XiDYuSJNudRWcj90G0NySoTaFQhMZteIWWnm', 'ADMIN', 'teste@gmail.com', 'teste', '2222222', '111.131.111-11'),
(6, 'usuario teste', '$2y$10$USfTwu700aUcQ.ZS.vUT..pz6aZgMSbQ.zw5QjM4keyJZIWD9be1G', 'USUARIO', 'teste1@gmail.com', '6666666', 'rua ', '111.144.111-88'),
(7, 'otavio', '$2y$10$OxrVLYgaLiaglzL1Tyxqke.QHqCSUmW3FDSsRYiXLkfBcK4YYuUvy', 'ADMIN', 'otavio@a.a', '(11) 11111-1111', 'ru22321', '222.222.222-22'),
(9, 'coitado', '$2y$10$xed0tfZGm7n9zUWMszaiBea4oTgpQLlsW9T9ZCo1pCPaQwUuqPrA.', 'USUARIO', 'coitado@1.com', '(11) 11111-1111', '111111111111111111111111111111', '11.111.111/1111-11');

-- --------------------------------------------------------

--
-- Estrutura para tabela `veiculo`
--

CREATE TABLE `veiculo` (
  `veiculo_id` int(11) NOT NULL,
  `veiculo_quilometragem` decimal(10,2) NOT NULL,
  `fk_Chassi_id` int(11) NOT NULL,
  `fk_Cor_id` int(11) NOT NULL,
  `fk_Modelo_id` int(11) NOT NULL,
  `fk_combustivel_id` int(11) NOT NULL,
  `veiculo_versao` varchar(60) NOT NULL,
  `veiculo_ano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `veiculo`
--

INSERT INTO `veiculo` (`veiculo_id`, `veiculo_quilometragem`, `fk_Chassi_id`, `fk_Cor_id`, `fk_Modelo_id`, `fk_combustivel_id`, `veiculo_versao`, `veiculo_ano`) VALUES
(2, 15000.00, 2, 2, 2, 1, 'Versão 2021', 2021),
(3, 5000.00, 3, 3, 3, 3, 'Versão 2022', 2022),
(4, 0.00, 4, 4, 4, 4, 'Versão 2023', 2023),
(7, 9999.00, 2, 2, 1, 4, 'XEi', 1995),
(8, 9999.00, 2, 2, 1, 4, 'XEi', 1995),
(9, 3400.00, 2, 2, 1, 1, 'Avant MHEV Diesel', 2021),
(10, 111.00, 1, 1, 1, 1, '1111', 1111),
(12, 1111.00, 1, 1, 2, 1, '1111', 1111),
(13, 1111.00, 1, 1, 1, 1, 'TESTE ', 1111),
(14, 111.00, 1, 1, 1, 1, '111', 1111),
(15, 111.00, 1, 1, 1, 1, '111', 1111),
(16, 200000.00, 1, 5, 7, 2, '11', 2015),
(17, 111.00, 1, 1, 1, 1, 'aaa', 1111),
(18, 888.00, 1, 1, 1, 1, 'hhhh', 8888),
(19, 5555.00, 1, 1, 1, 1, 'ssdsd', 5555),
(20, 3333.00, 1, 1, 1, 1, 'asda', 6666),
(22, 111.00, 1, 1, 2, 1, '1111', 1111),
(24, 1111.00, 1, 1, 2, 1, 'ssss', 2011),
(25, 22222222.00, 2, 4, 5, 4, 'hybrid', 2018),
(26, 10900.00, 1, 1, 7, 1, 'niggamode AVANT', 2018),
(27, 139000.00, 2, 1, 10, 7, 'Elite 2.4 16v', 2006);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `anuncio`
--
ALTER TABLE `anuncio`
  ADD PRIMARY KEY (`anuncio_id`),
  ADD KEY `fk_usuario_id` (`fk_usuario_id`),
  ADD KEY `fk_veiculo_id` (`fk_veiculo_id`);

--
-- Índices de tabela `chassi`
--
ALTER TABLE `chassi`
  ADD PRIMARY KEY (`chassi_id`);

--
-- Índices de tabela `combustivel`
--
ALTER TABLE `combustivel`
  ADD PRIMARY KEY (`comb_id`);

--
-- Índices de tabela `cor`
--
ALTER TABLE `cor`
  ADD PRIMARY KEY (`cor_id`);

--
-- Índices de tabela `imagem`
--
ALTER TABLE `imagem`
  ADD PRIMARY KEY (`imagem_id`),
  ADD UNIQUE KEY `imagem_url` (`imagem_url`),
  ADD KEY `fk_anuncio_id` (`fk_anuncio_id`);

--
-- Índices de tabela `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`marca_id`);

--
-- Índices de tabela `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`modelo_id`),
  ADD KEY `fk_Marca_id` (`fk_Marca_id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Índices de tabela `veiculo`
--
ALTER TABLE `veiculo`
  ADD PRIMARY KEY (`veiculo_id`),
  ADD KEY `fk_Chassi_id` (`fk_Chassi_id`),
  ADD KEY `fk_Cor_id` (`fk_Cor_id`),
  ADD KEY `fk_Modelo_id` (`fk_Modelo_id`),
  ADD KEY `fk_combustivel_id` (`fk_combustivel_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `anuncio`
--
ALTER TABLE `anuncio`
  MODIFY `anuncio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `chassi`
--
ALTER TABLE `chassi`
  MODIFY `chassi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `combustivel`
--
ALTER TABLE `combustivel`
  MODIFY `comb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `cor`
--
ALTER TABLE `cor`
  MODIFY `cor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `imagem`
--
ALTER TABLE `imagem`
  MODIFY `imagem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de tabela `marca`
--
ALTER TABLE `marca`
  MODIFY `marca_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `modelo`
--
ALTER TABLE `modelo`
  MODIFY `modelo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `veiculo`
--
ALTER TABLE `veiculo`
  MODIFY `veiculo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `anuncio`
--
ALTER TABLE `anuncio`
  ADD CONSTRAINT `anuncio_ibfk_1` FOREIGN KEY (`fk_usuario_id`) REFERENCES `usuario` (`usuario_id`),
  ADD CONSTRAINT `anuncio_ibfk_2` FOREIGN KEY (`fk_veiculo_id`) REFERENCES `veiculo` (`veiculo_id`);

--
-- Restrições para tabelas `imagem`
--
ALTER TABLE `imagem`
  ADD CONSTRAINT `imagem_ibfk_1` FOREIGN KEY (`fk_anuncio_id`) REFERENCES `anuncio` (`anuncio_id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `modelo`
--
ALTER TABLE `modelo`
  ADD CONSTRAINT `modelo_ibfk_1` FOREIGN KEY (`fk_Marca_id`) REFERENCES `marca` (`marca_id`);

--
-- Restrições para tabelas `veiculo`
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
