-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 24 nov. 2026 à 14:11
-- Version du serveur : 10.11.16-MariaDB
-- Version de PHP : 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `touche-pas-au-klaxon`
--

--
-- Déchargement des données de la table `agency`
--

INSERT INTO `agency` (`id`, `name`) VALUES
(1, 'Paris'),
(2, 'Lyon'),
(3, 'Marseille'),
(4, 'Toulouse'),
(5, 'Nice'),
(6, 'Nantes'),
(7, 'Strasbourg'),
(8, 'Montpellier'),
(9, 'Bordeaux'),
(10, 'Lille'),
(11, 'Rennes'),
(12, 'Reims');

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `phone`, `email`, `password`, `admin`) VALUES
(1, 'Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', '$2y$12$ov2KmNA0f5E/33SKlzxiMOFcolYG1qhFxMI3B1a2sGcRRXmF0bA.e', 0),
(2, 'Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', '1234', 0),
(3, 'Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', '1234', 0),
(4, 'Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', '1234', 0),
(5, 'Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', '1234', 0),
(6, 'Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', '1234', 0),
(7, 'Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', '1234', 0),
(8, 'Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', '1234', 0),
(9, 'Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', '1234', 0),
(10, 'Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', '1234', 0),
(11, 'Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', '1234', 0),
(12, 'Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', '1234', 0),
(13, 'Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', '1234', 0),
(14, 'Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', '1234', 0),
(15, 'Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', '1234', 0),
(16, 'Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', '1234', 0),
(17, 'Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', '1234', 0),
(18, 'Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', '1234', 0),
(19, 'Masson', 'Julie', '0733445566', 'julie.masson@email.fr', '1234', 0),
(20, 'Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', '1234', 0),
(21, 'Administrateur', '', '0000000000', 'admin@email.fr', '$2y$12$BZDbUyzGeUdZNGEfNJ6c2O4lVhGovgY9F6oZuTq61F7jbyhYarmrK', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
