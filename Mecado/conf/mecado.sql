-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 10 Novembre 2017 à 17:14
-- Version du serveur :  5.1.73
-- Version de PHP :  7.0.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `painteau1u`
--

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `tarif` float NOT NULL,
  `url` varchar(500) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `id_liste` int(11) DEFAULT NULL,
  `reserver` tinyint(1) NOT NULL DEFAULT '0',
  `reserviste` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_liste` (`id_liste`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `item`
--

INSERT INTO `item` (`id`, `nom`, `description`, `tarif`, `url`, `image`, `id_liste`, `reserver`, `reserviste`) VALUES
(3, 'Vélo', 'Vélo decathlon', 200, 'https://www.decathlon.fr/vtt-rockrider-340-gris-26-id_8321326.html?LGWCODE=470648;11737;809&#38;utm_source=google_shopping&#38;utm_term=VTT%20ROCKRIDER%20340%20GRIS%2026&#38;utm_medium=cpc&#38;utm_campaign=ecommerce_shopbot&#38;utm_source=google_shopping&#38;utm_medium=cpc&#38;utm_term=.&#38;utm_campaign=PLA+-+High+Priority&#38;utm_content=shc5hWDV8_dc|pcrid||pkw||pmt||pid|470648&#38;gclid=EAIaIQobChMIs6Csz6a01wIVCWQZCh24SANkEAkYASABEgK11vD_BwE', 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcRSDhJgxghYl0Pjtk1KWN7obmA9rU3aK45dbRTXJCGw1Q2ViAgyQhjTMtl-ufZDZZGOs3lzcMQ&#38;usqp=CAE', 2, 0, NULL),
(4, 'Chapeau', 'Chapeau melon', 46, 'http://www.chapeauxetcasquettes.fr/chapeau-melon-en-laine-feutree-noir-jaxon-and-james-p135060/?gclid=EAIaIQobChMI6LKv6aa01wIVS9wZCh3qVwgREAkYASABEgKC4PD_BwE', 'https://encrypted-tbn2.gstatic.com/shopping?q=tbn:ANd9GcTdBaSslxy-bPaCiweDQwiYt730M1EQ3cezcbAfOYVpB6xcFynTwwnDSPpdWdwVIm2XImkBaaHw&#38;usqp=CAE', 2, 1, 'Léo');

-- --------------------------------------------------------

--
-- Structure de la table `liste`
--

CREATE TABLE IF NOT EXISTS `liste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `date_limite` date NOT NULL,
  `destinataire` varchar(100) NOT NULL,
  `for_other` tinyint(1) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Liste_id_User` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `liste`
--

INSERT INTO `liste` (`id`, `titre`, `description`, `date_limite`, `destinataire`, `for_other`, `id_user`, `url`) VALUES
(2, 'Anniversaire Maxime', 'Anniversaire de maxime', '2031-11-12', 'Maxime', 1, 2, '4d60b2bb5f');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auteur` varchar(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `date_create` date NOT NULL,
  `id_liste` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Message_id_Liste` (`id_liste`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id`, `auteur`, `description`, `type`, `date_create`, `id_liste`) VALUES
(1, 'Gauthier', 'Joyeux anniversaire maxime', 1, '2017-11-10', 2),
(2, 'Léo', 'Je peux prendre le chapeau ?', 1, '2017-11-10', 2),
(3, 'Léo', 'Joyeux anniversaire maxime !', 0, '2017-11-10', 2),
(4, 'Gauthier', 'Bonjour depuis un téléphone', 1, '2017-11-10', 2);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) DEFAULT NULL,
  `prenom` varchar(250) DEFAULT NULL,
  `mail` varchar(250) NOT NULL,
  `mdp` varchar(250) NOT NULL,
  `level` int(255) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `mail`, `mdp`, `level`) VALUES
(2, 'Painteaux', 'Gauthier', 'g.p@gmail.com', '$2y$10$meOBbb1LdnkZy9s1KztHOOcBeLWTjQ7hxW8pDg1Pk/lXOgpyBZB2y', 100),
(3, 'Charles', 'Julien', 'Julien@yopmail.com', '$2y$10$eO/lfFoBLAvoiVcWD3HM7OQe7sgG7/RRcjLzJSJLXi6RzP/6vGloS', 100);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `FK_item_id_liste` FOREIGN KEY (`id_liste`) REFERENCES `liste` (`id`);

--
-- Contraintes pour la table `liste`
--
ALTER TABLE `liste`
  ADD CONSTRAINT `FK_Liste_id_User` FOREIGN KEY (`id_User`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_Message_id_Liste` FOREIGN KEY (`id_Liste`) REFERENCES `liste` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
