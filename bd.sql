-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 18-Ago-2018 às 19:19
-- Versão do servidor: 5.7.21-log
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `classificados`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `anuncios`
--

CREATE TABLE `anuncios` (
  `id_anuncio` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `titulo` varchar(65) DEFAULT NULL,
  `descricao` text,
  `valor` double(9,2) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `anuncios_imagens`
--

CREATE TABLE `anuncios_imagens` (
  `id_anuncio_img` int(11) NOT NULL,
  `anuncio_id` int(11) NOT NULL,
  `url` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id_categorias` int(11) NOT NULL,
  `nome` varchar(65) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(65) DEFAULT NULL,
  `email` varchar(65) DEFAULT NULL,
  `senha` varchar(32) DEFAULT NULL,
  `telefone` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `senha`, `telefone`) VALUES
(1, 'Paulo da Silva', 'paulosilva@email.com', '202cb962ac59075b964b07152d234b70', '(11) 99988-7766'),
(2, 'Maria Rita', 'mariarita@email.com', '202cb962ac59075b964b07152d234b70', '(12) 88765-9933');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`id_anuncio`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indexes for table `anuncios_imagens`
--
ALTER TABLE `anuncios_imagens`
  ADD PRIMARY KEY (`id_anuncio_img`),
  ADD KEY `anuncio_id` (`anuncio_id`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categorias`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anuncios`
--
ALTER TABLE `anuncios`
  MODIFY `id_anuncio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `anuncios_imagens`
--
ALTER TABLE `anuncios_imagens`
  MODIFY `id_anuncio_img` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categorias` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `anuncios`
--
ALTER TABLE `anuncios`
  ADD CONSTRAINT `anuncios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `anuncios_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id_categorias`);

--
-- Limitadores para a tabela `anuncios_imagens`
--
ALTER TABLE `anuncios_imagens`
  ADD CONSTRAINT `anuncios_imagens_ibfk_1` FOREIGN KEY (`anuncio_id`) REFERENCES `anuncios` (`id_anuncio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
