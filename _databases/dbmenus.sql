-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 18 nov. 2021 à 21:50
-- Version du serveur :  5.7.24
-- Version de PHP : 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dbmenus`
--

-- --------------------------------------------------------

--
-- Structure de la table `commands`
--

CREATE TABLE `commands` (
  `commands_id` int(10) UNSIGNED NOT NULL,
  `ingredient` varchar(40) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `quantity_name` varchar(30) NOT NULL,
  `alert_stock` int(10) UNSIGNED NOT NULL,
  `must_buy` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commands`
--

INSERT INTO `commands` (`commands_id`, `ingredient`, `quantity`, `quantity_name`, `alert_stock`, `must_buy`) VALUES
(1, 'flour', 700, 'grams', 300, b'0'),
(2, 'eggs', 15, 'units', 10, b'0'),
(3, 'sugar', 300, 'grams', 200, b'0'),
(4, 'milk', 200, 'centiliters', 50, b'0');

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

CREATE TABLE `stocks` (
  `stocks_id` int(10) UNSIGNED NOT NULL,
  `ingredient` varchar(40) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `quantity_name` varchar(30) NOT NULL,
  `useby_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stocks`
--

INSERT INTO `stocks` (`stocks_id`, `ingredient`, `quantity`, `quantity_name`, `useby_date`) VALUES
(1, 'flour', 300, 'grams', '2023-02-25'),
(2, 'eggs', 15, 'units', '2021-11-26'),
(3, 'sugar', 300, 'grams', '2022-06-24'),
(4, 'milk', 100, 'centiliters', '2021-12-12'),
(5, 'milk', 100, 'centiliters', '2021-12-25'),
(7, 'flour', 400, 'grams', '2023-04-26');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commands`
--
ALTER TABLE `commands`
  ADD PRIMARY KEY (`commands_id`),
  ADD UNIQUE KEY `UNIQUE` (`ingredient`);

--
-- Index pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stocks_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commands`
--
ALTER TABLE `commands`
  MODIFY `commands_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stocks_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
