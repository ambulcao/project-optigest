-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Maio-2024 às 12:09
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `optigest`
--
CREATE DATABASE IF NOT EXISTS `optigest` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `optigest`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `job` varchar(255) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `admission_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Extraindo dados da tabela `employees`
--

INSERT INTO `employees` VALUES(1, 'Maria Silva', 30, 'Desenvolvedora', 5000.00, '2024-01-01');
INSERT INTO `employees` VALUES(2, 'João Pedro', 25, 'Analista de Sistemas', 3800.50, '2023-05-15');
INSERT INTO `employees` VALUES(3, 'Ana Souza', 42, 'Gerente de Projetos', 7200.00, '2022-12-08');
INSERT INTO `employees` VALUES(4, 'Carlos Oliveira', 38, 'Engenheiro de Software', 6500.75, '2021-09-21');
INSERT INTO `employees` VALUES(5, 'Beatriz Santos', 28, 'Designer Gráfica', 4000.00, '2024-03-10');
INSERT INTO `employees` VALUES(6, 'Miguel Ferreira', 35, 'Analista de Dados', 4800.25, '2023-07-02');
INSERT INTO `employees` VALUES(7, 'Sofia Costa', 22, 'Estagiária de Marketing', 2500.00, '2024-04-17');
INSERT INTO `employees` VALUES(8, 'Daniel Mendes', 40, 'Arquiteto de Software', 8000.00, '2022-10-26');
INSERT INTO `employees` VALUES(9, 'Gabriela Pereira', 32, 'QA Tester', 4200.10, '2023-08-19');
INSERT INTO `employees` VALUES(10, 'Rafael Almeida', 27, 'Suporte Técnico', 3500.00, '2024-02-05');
INSERT INTO `employees` VALUES(11, 'Vasco Santos', 30, 'DBA', 5600.00, '2024-02-12');
INSERT INTO `employees` VALUES(13, 'Joana Gomes', 24, 'Designer Produtos', 4300.00, '2024-02-05');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `id_employees` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `delivery_date` date NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Extraindo dados da tabela `projects`
--

INSERT INTO `projects` VALUES(1, 1, 'Desenvolvimento de novo sistema de vendas', 12000.00, 'Em Andamento', '2024-12-15', '2024-05-13 07:53:31');
INSERT INTO `projects` VALUES(2, 2, 'Migração de banco de dados para cloud', 8500.20, 'Planejado', '2025-02-28', '2024-05-13 07:53:31');
INSERT INTO `projects` VALUES(3, 3, 'Implementação de novo CRM', 15000.50, 'Em Andamento', '2024-11-30', '2024-05-13 07:53:31');
INSERT INTO `projects` VALUES(4, 4, 'Redesign do website da empresa', 7000.00, 'Concluído', '2024-04-10', '2024-05-13 07:53:31');
INSERT INTO `projects` VALUES(5, 5, 'Desenvolvimento de aplicativo mobile', 10500.75, 'Em Andamento', '2025-01-12', '2024-05-13 07:53:31');
INSERT INTO `projects` VALUES(6, 6, 'Análise de dados de marketing', 4200.00, 'Concluído', '2024-03-25', '2024-05-13 07:53:31');
INSERT INTO `projects` VALUES(7, 7, 'Criação de campanha de marketing digital', 3800.50, 'Planejado', '2024-06-08', '2024-05-13 07:53:31');
INSERT INTO `projects` VALUES(8, 8, 'Implementação de sistema de segurança', 9000.00, 'Em Andamento', '2024-10-20', '2024-05-13 07:53:31');
INSERT INTO `projects` VALUES(9, 9, 'Desenvolvimento de chatbot de atendimento', 6000.25, 'Planejado', '2025-03-05', '2024-05-13 07:53:31');
INSERT INTO `projects` VALUES(10, 10, 'Manutenção corretiva do sistema ERP', 5500.10, 'Concluído', '2024-05-15', '2024-05-13 07:53:31');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_employee` (`id_employees`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`id_employees`) REFERENCES `employees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
