-- Adminer 4.8.1 MySQL 8.4.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `Artiste`;
CREATE TABLE `Artiste` (
  `id_artiste` char(36) NOT NULL,
  `nom_artiste` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_artiste`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Billet`;
CREATE TABLE `Billet` (
  `id_billet` char(36) NOT NULL,
  `id_utilisateur` char(36) DEFAULT NULL,
  `id_soiree` char(36) DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  `categorie_tarif` enum('normal','reduit') DEFAULT NULL,
  `date_achat` datetime DEFAULT NULL,
  PRIMARY KEY (`id_billet`),
  KEY `id_utilisateur` (`id_utilisateur`),
  KEY `id_soiree` (`id_soiree`),
  CONSTRAINT `Billet_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `Utilisateur` (`uuid`),
  CONSTRAINT `Billet_ibfk_2` FOREIGN KEY (`id_soiree`) REFERENCES `Soiree` (`id_soiree`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Lieu`;
CREATE TABLE `Lieu` (
  `id_lieu` char(36) NOT NULL,
  `nom_lieu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `adresse` text,
  `places_assises` int DEFAULT NULL,
  `places_debout` int DEFAULT NULL,
  `images` json DEFAULT NULL,
  PRIMARY KEY (`id_lieu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Panier`;
CREATE TABLE `Panier` (
  `id_panier` char(36) NOT NULL,
  `id_utilisateur` char(36) DEFAULT NULL,
  `categorie_tarif` enum('normal','reduit') DEFAULT NULL,
  `date_ajout` datetime DEFAULT CURRENT_TIMESTAMP,
  `etat` enum('en_cours','valider','payer') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'en_cours',
  PRIMARY KEY (`id_panier`),
  KEY `id_utilisateur` (`id_utilisateur`),
  CONSTRAINT `Panier_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `Utilisateur` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Panier_Soiree`;
CREATE TABLE `Panier_Soiree` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_panier` char(36) DEFAULT NULL,
  `id_soiree` char(36) DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  `categorie_tarif` enum('normal','reduit') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_panier` (`id_panier`),
  KEY `id_soiree` (`id_soiree`),
  CONSTRAINT `Panier_Soiree_ibfk_1` FOREIGN KEY (`id_panier`) REFERENCES `Panier` (`id_panier`),
  CONSTRAINT `Panier_Soiree_ibfk_2` FOREIGN KEY (`id_soiree`) REFERENCES `Soiree` (`id_soiree`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Soiree`;
CREATE TABLE `Soiree` (
  `id_soiree` char(36) NOT NULL,
  `nom_soiree` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `horaire_debut` time DEFAULT NULL,
  `id_lieu` char(36) DEFAULT NULL,
  `thematique` int DEFAULT NULL,
  PRIMARY KEY (`id_soiree`),
  KEY `id_lieu` (`id_lieu`),
  CONSTRAINT `Soiree_ibfk_1` FOREIGN KEY (`id_lieu`) REFERENCES `Lieu` (`id_lieu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Spectacle`;
CREATE TABLE `Spectacle` (
  `id_spectacle` char(36) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text,
  `images` json DEFAULT NULL,
  `url_video` varchar(255) DEFAULT NULL,
  `horaire_previsionnel` time DEFAULT NULL,
  `id_soiree` char(36) DEFAULT NULL,
  PRIMARY KEY (`id_spectacle`),
  KEY `id_soiree` (`id_soiree`),
  CONSTRAINT `Spectacle_ibfk_1` FOREIGN KEY (`id_soiree`) REFERENCES `Soiree` (`id_soiree`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Spectacle_Artiste`;
CREATE TABLE `Spectacle_Artiste` (
  `id_spectacle` char(36) NOT NULL,
  `id_artiste` char(36) NOT NULL,
  PRIMARY KEY (`id_spectacle`,`id_artiste`),
  KEY `id_artiste` (`id_artiste`),
  CONSTRAINT `Spectacle_Artiste_ibfk_1` FOREIGN KEY (`id_spectacle`) REFERENCES `Spectacle` (`id_spectacle`),
  CONSTRAINT `Spectacle_Artiste_ibfk_2` FOREIGN KEY (`id_artiste`) REFERENCES `Artiste` (`id_artiste`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Tarif`;
CREATE TABLE `Tarif` (
  `id_tarif` char(36) NOT NULL,
  `id_soiree` char(36) DEFAULT NULL,
  `tarif_normal` decimal(10,2) DEFAULT NULL,
  `tarif_reduit` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_tarif`),
  KEY `id_soiree` (`id_soiree`),
  CONSTRAINT `Tarif_ibfk_1` FOREIGN KEY (`id_soiree`) REFERENCES `Soiree` (`id_soiree`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Thematique`;
CREATE TABLE `Thematique` (
  `id_thematique` char(36) NOT NULL,
  `nom_thematique` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_thematique`),
  UNIQUE KEY `nom_thematique` (`nom_thematique`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


DROP TABLE IF EXISTS `Utilisateur`;
CREATE TABLE `Utilisateur` (
  `nom_utilisateur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `uuid` char(36) NOT NULL,
  `role` int DEFAULT '10',
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

