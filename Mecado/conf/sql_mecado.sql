-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           5.7.19 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Export de la structure de la table mecado. item
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `tarif` float NOT NULL,
  `url` varchar(500) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `id_liste` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_liste` (`id_liste`),
  CONSTRAINT `FK_item_id_liste` FOREIGN KEY (`id_liste`) REFERENCES `liste` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Export de données de la table mecado.item : ~2 rows (environ)
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` (`id`, `nom`, `description`, `tarif`, `url`, `image`, `id_liste`) VALUES
	(1, 'vélo', 'vélo pas ouf', 133, 'https://www.groupon.fr/deals/velo-pliable?deal_option=b32490b9-abd2-4385-9a3e-d32c0c3dcb07&utm_medium=cpc&utm_source=google&utm_campaign=fr_dt_sea_ggl_txt_tim_pads_cbp_chp_nbr_target*_adposition*1o20_prodtarget*266424665183_adtype*pla_productpartitionid*266424665183_campaignid*689081234_adgroupid*34422614534&mr:referralID=b1ca6627-c468-11e7-a79c-005056941669&gclid=Cj0KCQiA84rQBRDCARIsAPO8RFz8SAbUlJnJAuqtAXJv_awriPb0EUjHX98xionvpvZz7CvBdFVsa-gaAgFpEALw_wcB', 'https://media.alltricks.com/medium/58204019864a6.jpg', 1),
	(2, 'poèle', 'poèle pour taper', 50, 'https://www.boulanger.com/ref/8002681?xtor=SEC-2116-GOO&xts=171153&origin=pla&kwd=&gclid=Cj0KCQiA84rQBRDCARIsAPO8RFz2ejQwmwKOvsjqyD2u6ndEs99VD9tSk4MjekcQgTCVI0yOsWFm4rsaAtcrEALw_wcB&gclsrc=aw.ds', 'https://www.videlice.com/525-thickbox_default/poele-en-tole-d-acier-la-lyonnaise-de-buyer.jpg', 1);
/*!40000 ALTER TABLE `item` ENABLE KEYS */;

-- Export de la structure de la table mecado. liste
CREATE TABLE IF NOT EXISTS `liste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `date_limite` date NOT NULL,
  `destinataire` varchar(100) NOT NULL,
  `for_him` tinyint(1) NOT NULL,
  `id_User` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Liste_id_User` (`id_User`),
  CONSTRAINT `FK_Liste_id_User` FOREIGN KEY (`id_User`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Export de données de la table mecado.liste : ~1 rows (environ)
/*!40000 ALTER TABLE `liste` DISABLE KEYS */;
INSERT INTO `liste` (`id`, `titre`, `description`, `date_limite`, `destinataire`, `for_him`, `id_User`, `url`) VALUES
	(1, 'Anniversaire trop bien!', 'bjour cette liste est pour s\'organiser pour l\'anniversaire de ce schlague ', '2017-11-30', 'Sarah', 0, 1, 'http://localhost/atelierprojet1/Mecado/main.php/affichagelist/');
/*!40000 ALTER TABLE `liste` ENABLE KEYS */;

-- Export de la structure de la table mecado. message
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auteur` varchar(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `date_create` date NOT NULL,
  `id_Liste` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Message_id_Liste` (`id_Liste`),
  CONSTRAINT `FK_Message_id_Liste` FOREIGN KEY (`id_Liste`) REFERENCES `liste` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Export de données de la table mecado.message : ~0 rows (environ)
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;

-- Export de la structure de la table mecado. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(250) DEFAULT NULL,
  `prenom` varchar(250) DEFAULT NULL,
  `mail` varchar(250) NOT NULL,
  `mdp` varchar(250) NOT NULL,
  `level` int(255) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Export de données de la table mecado.user : ~1 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `nom`, `prenom`, `mail`, `mdp`, `level`) VALUES
	(1, 'pleure', 'jean', 'jean_pleure@gmail.com', '$2y$10$jWnt5g43L6Yc5TmjbgArputJyvbbmyyKLQWbxV7Qt/YwFi9XJfh4u', 100);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
