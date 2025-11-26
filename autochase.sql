-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/11/2025 às 19:30
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
  `anuncio_desc` varchar(2000) DEFAULT NULL,
  `anuncio_status` enum('ATIVO','INATIVO','VENDIDO') NOT NULL DEFAULT 'ATIVO',
  `fk_usuario_id` int(11) NOT NULL,
  `fk_veiculo_id` int(11) NOT NULL COMMENT 'FK do veículo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `anuncio`
--

INSERT INTO `anuncio` (`anuncio_id`, `anuncio_valor`, `anuncio_data_de_alteracao`, `anuncio_data_de_criacao`, `anuncio_desc`, `anuncio_status`, `fk_usuario_id`, `fk_veiculo_id`) VALUES
(23, 90900.00, '2025-11-22 04:03:17', '2025-11-13 03:35:49', 'GASOLINA 4P AUTOMÁTICO\r\n', 'ATIVO', 5, 25),
(24, 899000.00, '2025-11-21 09:26:38', '2025-11-16 22:40:34', 'Veículo com histórico de manutenção rigorosamente em dia na concessionária. Sem retoques, sem stage (mapa), totalmente original. Para quem busca exclusividade e não aceita andar atrás.', 'ATIVO', 5, 26),
(25, 50100.00, '2025-11-23 06:25:27', '2025-11-17 04:25:48', 'Manual F23 - Exclusivo\r\nEspecial para quem busca conforto, desempenho para viagens e bom custo-benefício no mercado de usados. Seus pontos positivos incluem motor forte e suave, acabamento interno luxuoso e suspensão confortável.', 'ATIVO', 5, 27),
(26, 10120.00, '2025-11-21 08:43:35', '2025-11-17 22:59:29', 'Golzinho filezinho, pegar e andar. Quem chegar primeiro leva essa relíquia', 'ATIVO', 9, 28),
(27, 3000000.00, '2025-11-21 08:27:42', '2025-11-17 23:03:00', 'Motor: 4.5L V8 \"F136\" Aspirado, 570cv.\r\nCâmbio F1 Dual-Clutch 7 marchas, Interior com acabamentos em fibra de carbono.\r\nVolante em Carbono + LEDs, Opcional indispensável para a experiência de pilotagem.\r\nEscudos Scuderia Ferrari Embutidos nos para-lamas.\r\nFreios: Carbono-Cerâmica com pinças Giallo Modena.\r\nInterior Couro de alta gramatura em estado de conservação impecável, sem desgastes.\r\nVeículo mantido com rigor técnico absoluto. Revisões em dia. Carro para colecionadores que entendem que a era dos motores aspirados de alto giro acabou.', 'ATIVO', 5, 29),
(29, 1339300.00, '2025-11-21 06:51:06', '2025-11-21 02:33:02', 'Destaques Técnicos:\r\n\r\nMotor: V8 6.2L LT2 Aspirado | 495cv (Z51 Package).\r\n\r\nCâmbio: Tremec DCT 8 Velocidades (Dupla Embreagem).\r\n\r\nPerformance: 0 a 100 km/h em 2,9s.\r\n\r\nConfiguração & Opcionais:\r\n\r\nPacote Z51 Performance: Freios Brembo maiores, diferencial eLSD, escape esportivo e refrigeração aprimorada.\r\n\r\nFront Lift: Sistema de elevação de eixo dianteiro com memória GPS (item obrigatório para o Brasil).\r\n\r\nInterior 3LT: Acabamento máximo em couro Napa, bancos GT2 em fibra de carbono e teto em Alcantara.\r\n\r\nSom: Bose Performance Series de 14 alto-falantes.\r\n\r\nSuspensão: Magnetic Ride Control 4.0.\r\n\r\nVeículo sem detalhes, com vitrificação de pintura realizada. Documentação 100% em dia. Apenas venda.', 'ATIVO', 5, 31),
(30, 610000.00, '2025-11-22 01:42:54', '2025-11-22 01:42:54', 'simples carro porsche 0 km', 'ATIVO', 9, 32),
(31, 1200000.00, '2025-11-23 06:04:28', '2025-11-22 05:32:08', 'inteiro nunca fuçado', 'ATIVO', 5, 33),
(35, 709900.00, '2025-11-23 06:11:29', '2025-11-23 06:07:00', 'Renault Clio V6 RS super raro', 'INATIVO', 5, 37),
(36, 10400.00, '2025-11-23 06:11:43', '2025-11-23 06:10:26', 'bom de motor', 'VENDIDO', 5, 38);

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
(12, 'Barchetta');

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
(4, 'Híbrido'),
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
(14, 'Cinza');

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
(34, 'src/uploads/G2C7Ne9XIAAFHKB.jpg', 26, '2025-11-17 22:59:29'),
(35, 'src/uploads/G54dihzXIAAS7_R.jpg', 27, '2025-11-17 23:03:00'),
(40, 'src/uploads/chevrolet-corvette---2021-19315689-003.webp', 29, '2025-11-21 02:33:02'),
(41, 'src/uploads/718 Boxster (2024).webp', 30, '2025-11-22 01:42:54'),
(53, 'src/uploads/dcx2omb-46a67bd1-e35d-4212-90cf-5f88bb6ac094.jpg', 31, '2025-11-23 02:07:46'),
(54, 'src/uploads/9uvgylq6ezqwgqh21rflaij38.jpg', 35, '2025-11-23 06:07:00'),
(55, 'src/uploads/escort-hobby-2p1-7262ce547815a94b2e15614879102516-1024-1024.jpg', 36, '2025-11-23 06:10:26'),
(88, 'src/uploads/D_NQ_NP_2X_859153-MLB97216360993_112025-F-vectra-elite-24-mpfi-16v-flexpower-aut.webp', 25, '2025-11-23 06:18:09'),
(89, 'src/uploads/D_NQ_NP_2X_610375-MLB97216360983_112025-F-vectra-elite-24-mpfi-16v-flexpower-aut.webp', 25, '2025-11-23 06:18:09'),
(90, 'src/uploads/D_NQ_NP_2X_775544-MLB97216666327_112025-F-vectra-elite-24-mpfi-16v-flexpower-aut.webp', 25, '2025-11-23 06:18:09'),
(91, 'src/uploads/D_NQ_NP_2X_692995-MLB96759583292_112025-F-vectra-elite-24-mpfi-16v-flexpower-aut.webp', 25, '2025-11-23 06:18:09'),
(92, 'src/uploads/D_NQ_NP_2X_951733-MLB97216360987_112025-F-vectra-elite-24-mpfi-16v-flexpower-aut.webp', 25, '2025-11-23 06:18:09'),
(93, 'src/uploads/D_NQ_NP_2X_759109-MLB96761635836_112025-F-vectra-elite-24-mpfi-16v-flexpower-aut.webp', 25, '2025-11-23 06:18:09'),
(94, 'src/uploads/D_NQ_NP_2X_909480-MLB97216360985_112025-F-vectra-elite-24-mpfi-16v-flexpower-aut.webp', 25, '2025-11-23 06:18:09'),
(95, 'src/uploads/D_NQ_NP_2X_798131-MLB97216666515_112025-F-vectra-elite-24-mpfi-16v-flexpower-aut.webp', 25, '2025-11-23 06:18:09');

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
(9, 'Audi'),
(10, 'Mazda '),
(15, 'Chevrolet'),
(17, 'Ferrari'),
(18, 'Corvette'),
(21, 'Porsche'),
(22, 'Renault');

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
(1, 'Corolla', 37898.00, 1),
(2, 'Civic', 190010.00, 2),
(3, 'Corolla Cross', 300000.00, 1),
(4, 'Gol', 45000.00, 4),
(5, 'Fusion', 100000.00, 3),
(7, 'RS6', 111111.00, 9),
(8, 'RX7', 70000.00, 10),
(10, 'Vectra', 29857.62, 15),
(11, '458 Italia', 2600000.00, 17),
(12, 'C8', 1130000.00, 18),
(18, '911', 758000.00, 21),
(19, '718', 550000.00, 21),
(20, 'Cayenne', 505000.00, 21),
(21, 'Yaris', 130000.00, 1),
(22, 'Hilux', 250000.00, 1),
(23, 'SW4', 421000.00, 1),
(24, 'Prius', 168000.00, 1),
(25, 'Clio', 200000.00, 22),
(26, 'Escort', 8800.00, 3);

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
(1, 'Administrador', '$2y$10$NAHCoamqGbr/JEx1l9nbpOpQ1D9DwM.lUXly3NViNMEOtDgPPrmZ2', 'ADMIN', 'admin@example.com', '999999999', 'Rua 1, 123', '123.456.789-01'),
(2, 'Usuário Teste', '$2y$10$ouKD1dZXNfEMa2Qg/QcUMO1ONdL.rS9ZkzYkLmefwZnn4IopFKvV6', 'USUARIO', 'usuario@example.com', '988888888', 'Rua 2, 456', '987.654.321-00'),
(5, 'Andrei Admin', '$2y$10$VSLKDlcFhFGVChLp6XiDYuSJNudRWcj90G0NySoTaFQhMZteIWWnm', 'ADMIN', 'teste@gmail.com', '(53) 99971-1852', 'Rua Testador Jafet Mil-anos, 3026', '992.231.052-44'),
(6, 'usuario teste', '$2y$10$USfTwu700aUcQ.ZS.vUT..pz6aZgMSbQ.zw5QjM4keyJZIWD9be1G', 'USUARIO', 'teste1@gmail.com', '6666666', 'rua ', '111.144.111-88'),
(7, 'otavio', '$2y$10$OxrVLYgaLiaglzL1Tyxqke.QHqCSUmW3FDSsRYiXLkfBcK4YYuUvy', 'ADMIN', 'otavio@a.a', '(11) 11111-1111', 'ru22321', '222.222.222-22'),
(9, 'Coitado', '$2y$10$xed0tfZGm7n9zUWMszaiBea4oTgpQLlsW9T9ZCo1pCPaQwUuqPrA.', 'USUARIO', 'coitado@1.com', '(53) 99921-1152', 'Rua General dos Coitados da Silva, 1903532', '17.121.161/1530-22'),
(10, 'aawodawoid', '$2y$10$3JuVgEfwlJLE97DZ3QDLwOG1qzfLYSV6rbloTJe/Xx1VzPItBD15S', 'USUARIO', 'cu@gmail.com', '(12) 32312-1213', 'adwadawda', '32.121.313/2123-12');

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
(9, 3400.00, 2, 2, 1, 1, 'Avant MHEV Diesel', 2021),
(25, 123000.00, 2, 4, 5, 4, '2.0 TITANIUM AWD 16V ', 2018),
(26, 10892.00, 1, 1, 7, 1, '4.0 Avant V8 Twinturbo MHEV Tiptronic', 2021),
(27, 139000.00, 2, 1, 10, 7, '2.4 16v Elite', 2006),
(28, 19900.00, 7, 4, 4, 1, '1.0 16v G3', 1999),
(29, 2120.00, 6, 9, 11, 1, '4.5L V8 Dual-Clutch', 2012),
(31, 1094.00, 6, 1, 12, 1, '6.2L Stingray V8 Targa', 2021),
(32, 0.00, 11, 1, 19, 1, '2.0 16V H4 Boxster PDK', 2026),
(33, 45900.00, 6, 2, 8, 1, '1.3 Manual', 1999),
(37, 21101.00, 7, 9, 25, 1, '3.0 V6 RS', 2004),
(38, 259000.00, 7, 2, 26, 1, '1.0 Hobby ', 1986);

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
  MODIFY `anuncio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
  MODIFY `imagem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de tabela `marca`
--
ALTER TABLE `marca`
  MODIFY `marca_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `modelo`
--
ALTER TABLE `modelo`
  MODIFY `modelo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `veiculo`
--
ALTER TABLE `veiculo`
  MODIFY `veiculo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
