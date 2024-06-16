-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 15 Juin 2024 à 17:33
-- Version du serveur :  5.6.20
-- Version de PHP :  5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `sae23`
--

-- --------------------------------------------------------

--
-- Structure de la table `Administration`
--

CREATE TABLE IF NOT EXISTS `Administration` (
  `login` varchar(30) NOT NULL,
  `mdp` varchar(30) NOT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Administration`
--

INSERT INTO `Administration` (`login`, `mdp`, `role`) VALUES
('root', 'passroot', 'admin'),
('ferrigno', 'ferrigno23', 'gestionnaire');

-- --------------------------------------------------------

--
-- Structure de la table `batiment`
--

CREATE TABLE IF NOT EXISTS `batiment` (
  `ID_unique` varchar(1) NOT NULL,
  `nom` varchar(15) NOT NULL,
  `login` varchar(10) NOT NULL,
  `mot de passe` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `batiment`
--

INSERT INTO `batiment` (`ID_unique`, `nom`, `login`, `mot de passe`) VALUES
('B', 'Informatique', 'login', 'mdp'),
('E', 'RT', 'login', 'mdp');

-- --------------------------------------------------------

--
-- Structure de la table `Capteurs`
--

CREATE TABLE IF NOT EXISTS `Capteurs` (
  `nom_capteur` varchar(15) NOT NULL,
  `type` varchar(11) NOT NULL,
  `unite` varchar(5) NOT NULL,
  `nom_salle` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Capteurs`
--

INSERT INTO `Capteurs` (`nom_capteur`, `type`, `unite`, `nom_salle`) VALUES
('co2B103', 'co2', 'ppm', 'B103'),
('co2E208', 'co2', 'ppm', 'E208'),
('temperatureB103', 'temperature', '°C', 'B103'),
('temperatureE208', 'temperature', '°C', 'E208');

-- --------------------------------------------------------

--
-- Structure de la table `Mesures`
--

CREATE TABLE IF NOT EXISTS `Mesures` (
`ID_unique` int(11) NOT NULL,
  `date` date NOT NULL,
  `horaire` time NOT NULL,
  `valeur` float NOT NULL,
  `nom_capteur` varchar(15) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=124 ;

--
-- Contenu de la table `Mesures`
--

INSERT INTO `Mesures` (`ID_unique`, `date`, `horaire`, `valeur`, `nom_capteur`) VALUES
(44, '2024-06-13', '18:25:30', 25.5, 'temperatureE208'),
(45, '2024-06-13', '18:25:30', 485, 'co2E208'),
(46, '2024-06-13', '18:28:01', 24.4, 'temperatureB103'),
(47, '2024-06-13', '18:28:01', 1885, 'co2B103'),
(48, '2024-06-14', '08:05:30', 23.5, 'temperatureE208'),
(49, '2024-06-14', '08:05:30', 444, 'co2E208'),
(50, '2024-06-14', '08:05:30', 23.5, 'temperatureE208'),
(51, '2024-06-14', '08:05:30', 444, 'co2E208'),
(52, '2024-06-14', '08:05:30', 444, 'co2E208'),
(53, '2024-06-14', '08:05:30', 23.5, 'temperatureE208'),
(54, '2024-06-14', '08:08:00', 1741, 'co2B103'),
(55, '2024-06-14', '08:08:00', 23, 'temperatureB103'),
(56, '2024-06-14', '08:08:00', 1741, 'co2B103'),
(57, '2024-06-14', '08:08:00', 23, 'temperatureB103'),
(58, '2024-06-14', '08:08:00', 23, 'temperatureB103'),
(59, '2024-06-14', '08:08:00', 1741, 'co2B103'),
(60, '2024-06-14', '08:15:30', 23.4, 'temperatureE208'),
(61, '2024-06-14', '08:15:30', 468, 'co2E208'),
(62, '2024-06-14', '08:18:00', 1734, 'co2B103'),
(63, '2024-06-14', '08:18:00', 23, 'temperatureB103'),
(64, '2024-06-14', '08:25:30', 473, 'co2E208'),
(65, '2024-06-14', '08:25:30', 23.5, 'temperatureE208'),
(66, '2024-06-14', '08:28:00', 1734, 'co2B103'),
(67, '2024-06-14', '08:28:00', 23, 'temperatureB103'),
(68, '2024-06-14', '08:35:30', 494, 'co2E208'),
(69, '2024-06-14', '08:35:30', 23.4, 'temperatureE208'),
(70, '2024-06-14', '08:38:00', 1739, 'co2B103'),
(71, '2024-06-14', '08:38:00', 23, 'temperatureB103'),
(72, '2024-06-14', '08:45:30', 23.3, 'temperatureE208'),
(73, '2024-06-14', '08:45:30', 481, 'co2E208'),
(74, '2024-06-14', '08:48:01', 1739, 'co2B103'),
(75, '2024-06-14', '08:48:01', 23, 'temperatureB103'),
(76, '2024-06-14', '08:55:31', 491, 'co2E208'),
(77, '2024-06-14', '08:55:31', 23.3, 'temperatureE208'),
(78, '2024-06-14', '08:58:01', 1745, 'co2B103'),
(79, '2024-06-14', '08:58:01', 23, 'temperatureB103'),
(80, '2024-06-14', '09:05:30', 23.3, 'temperatureE208'),
(81, '2024-06-14', '09:05:30', 487, 'co2E208'),
(82, '2024-06-14', '09:08:01', 23, 'temperatureB103'),
(83, '2024-06-14', '09:08:01', 1741, 'co2B103'),
(84, '2024-06-14', '09:15:30', 480, 'co2E208'),
(85, '2024-06-14', '09:15:30', 23, 'temperatureE208'),
(86, '2024-06-14', '09:18:00', 23, 'temperatureB103'),
(87, '2024-06-14', '09:18:00', 1747, 'co2B103'),
(88, '2024-06-14', '09:25:30', 23, 'temperatureE208'),
(89, '2024-06-14', '09:25:30', 481, 'co2E208'),
(90, '2024-06-14', '09:35:31', 475, 'co2E208'),
(91, '2024-06-14', '09:35:31', 23, 'temperatureE208'),
(92, '2024-06-14', '09:38:01', 1766, 'co2B103'),
(93, '2024-06-14', '09:38:01', 23, 'temperatureB103'),
(94, '2024-06-14', '09:45:30', 471, 'co2E208'),
(95, '2024-06-14', '09:45:30', 23, 'temperatureE208'),
(96, '2024-06-14', '09:48:01', 23.1, 'temperatureB103'),
(97, '2024-06-14', '09:48:01', 1998, 'co2B103'),
(98, '2024-06-14', '10:10:04', 0, 'temperatureB103'),
(99, '2024-06-14', '10:10:04', 0, 'temperatureE208'),
(100, '2024-06-14', '10:10:04', 0, 'co2E208'),
(101, '2024-06-14', '10:10:04', 0, 'co2B103'),
(102, '2024-06-14', '10:35:30', 461, 'co2E208'),
(103, '2024-06-14', '10:35:30', 23.2, 'temperatureE208'),
(104, '2024-06-14', '10:38:02', 2659, 'co2B103'),
(105, '2024-06-14', '10:38:02', 23.9, 'temperatureB103'),
(106, '2024-06-14', '10:45:31', 451, 'co2E208'),
(107, '2024-06-14', '10:45:31', 23.3, 'temperatureE208'),
(108, '2024-06-14', '10:48:02', 2801, 'co2B103'),
(109, '2024-06-14', '10:48:02', 24.1, 'temperatureB103'),
(110, '2024-06-14', '10:55:30', 23.5, 'temperatureE208'),
(111, '2024-06-14', '10:55:30', 456, 'co2E208'),
(112, '2024-06-14', '11:05:30', 486, 'co2E208'),
(113, '2024-06-14', '11:05:30', 23.6, 'temperatureE208'),
(114, '2024-06-14', '11:08:01', 24.3, 'temperatureB103'),
(115, '2024-06-14', '11:08:01', 2852, 'co2B103'),
(116, '2024-06-14', '11:08:01', 2852, 'co2B103'),
(117, '2024-06-14', '11:08:01', 24.3, 'temperatureB103'),
(118, '2024-06-14', '11:15:30', 482, 'co2E208'),
(119, '2024-06-14', '11:15:30', 23.9, 'temperatureE208'),
(120, '2024-06-15', '15:35:31', 418, 'co2E208'),
(121, '2024-06-15', '15:35:31', 26, 'temperatureE208'),
(122, '2024-06-15', '15:38:00', 1652, 'co2B103'),
(123, '2024-06-15', '15:38:00', 24.1, 'temperatureB103');

-- --------------------------------------------------------

--
-- Structure de la table `Salle`
--

CREATE TABLE IF NOT EXISTS `Salle` (
  `nom_salle` varchar(4) NOT NULL,
  `type` varchar(2) NOT NULL,
  `capacite` decimal(2,0) NOT NULL,
  `ID_unique` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Salle`
--

INSERT INTO `Salle` (`nom_salle`, `type`, `capacite`, `ID_unique`) VALUES
('B103', 'TD', '32', 'B'),
('E208', 'TP', '14', 'E');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `batiment`
--
ALTER TABLE `batiment`
 ADD PRIMARY KEY (`ID_unique`), ADD KEY `ID_unique` (`ID_unique`);

--
-- Index pour la table `Capteurs`
--
ALTER TABLE `Capteurs`
 ADD PRIMARY KEY (`nom_capteur`), ADD KEY `nom_salle` (`nom_salle`);

--
-- Index pour la table `Mesures`
--
ALTER TABLE `Mesures`
 ADD PRIMARY KEY (`ID_unique`), ADD KEY `nom_capteur` (`nom_capteur`);

--
-- Index pour la table `Salle`
--
ALTER TABLE `Salle`
 ADD PRIMARY KEY (`nom_salle`), ADD KEY `ID_unique` (`ID_unique`), ADD KEY `ID_unique_2` (`ID_unique`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Mesures`
--
ALTER TABLE `Mesures`
MODIFY `ID_unique` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=124;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Capteurs`
--
ALTER TABLE `Capteurs`
ADD CONSTRAINT `Installer` FOREIGN KEY (`nom_salle`) REFERENCES `Salle` (`nom_salle`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Mesures`
--
ALTER TABLE `Mesures`
ADD CONSTRAINT `Générer` FOREIGN KEY (`nom_capteur`) REFERENCES `Capteurs` (`nom_capteur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `Salle`
--
ALTER TABLE `Salle`
ADD CONSTRAINT `Appartenir` FOREIGN KEY (`ID_unique`) REFERENCES `batiment` (`ID_unique`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
