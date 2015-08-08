-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 20/07/2012 às 10:33:39
-- Versão do Servidor: 5.5.25a
-- Versão do PHP: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `lliure3`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `ll_admin`
--

CREATE TABLE IF NOT EXISTS `ll_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(200) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `email` varchar(256) DEFAULT NULL,
  `twitter` varchar(50) DEFAULT NULL,
  `foto` varchar(256) DEFAULT NULL,
  `grupo` varchar(10) NOT NULL DEFAULT 'user',
  `themer` varchar(50) DEFAULT 'default',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `ll_admin`
--

INSERT INTO `ll_admin` (`id`, `login`, `senha`, `nome`, `email`, `twitter`, `foto`, `grupo`, `themer`) VALUES
(1, 'admin', '1a84dec0b04a7631fada69b7e8f60bbe', 'Admin', NULL, NULL, NULL, 'dev', 'default');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ll_desktop`
--

CREATE TABLE IF NOT EXISTS `ll_desktop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `link` varchar(200) NOT NULL,
  `imagem` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ll_plugins`
--

CREATE TABLE IF NOT EXISTS `ll_plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `pasta` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ll_start`
--

CREATE TABLE IF NOT EXISTS `ll_start` (
  `idPlug` int(11) NOT NULL,
  PRIMARY KEY (`idPlug`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
