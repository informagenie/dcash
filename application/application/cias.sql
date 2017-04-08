-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 13 Mars 2017 à 07:22
-- Version du serveur :  5.6.26
-- Version de PHP :  5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cias`
--

-- --------------------------------------------------------

--
-- Structure de la table `providers`
--

CREATE TABLE IF NOT EXISTS `providers` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `shortcode` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `providers`
--

INSERT INTO `providers` (`id`, `nom`, `libelle`, `provider`, `shortcode`) VALUES
(1, 'mpesa', 'm-pesa', 'Vodacom', '*1222#'),
(2, 'orange_money', 'orange money', 'Orange', '*44444#'),
(3, 'airtel_money', 'Airtel Money', 'Airtel', '*501#');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_devise`
--

CREATE TABLE IF NOT EXISTS `tbl_devise` (
  `id` int(11) NOT NULL,
  `short_label` varchar(11) NOT NULL,
  `long_label` varchar(255) NOT NULL,
  `alias_label` varchar(20) NOT NULL,
  `taux` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tbl_devise`
--

INSERT INTO `tbl_devise` (`id`, `short_label`, `long_label`, `alias_label`, `taux`) VALUES
(1, 'CDF', 'Franc congolais', 'FC', 1300);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_items`
--

CREATE TABLE IF NOT EXISTS `tbl_items` (
  `itemId` int(11) NOT NULL,
  `itemHeader` varchar(512) NOT NULL COMMENT 'Heading',
  `itemSub` varchar(1021) NOT NULL COMMENT 'sub heading',
  `itemDesc` text COMMENT 'content or description',
  `itemImage` varchar(80) DEFAULT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `tbl_items`
--

INSERT INTO `tbl_items` (`itemId`, `itemHeader`, `itemSub`, `itemDesc`, `itemImage`, `isDeleted`, `createdBy`, `createdDtm`, `updatedDtm`, `updatedBy`) VALUES
(1, 'jquery.validation.js', 'Contribution towards jquery.validation.js', 'jquery.validation.js is the client side javascript validation library authored by Jörn Zaefferer hosted on github for us and we are trying to contribute to it. Working on localization now', 'validation.png', 0, 1, '2015-09-02 00:00:00', NULL, NULL),
(2, 'CodeIgniter User Management', 'Demo for user management system', 'This the demo of User Management System (Admin Panel) using CodeIgniter PHP MVC Framework and AdminLTE bootstrap theme. You can download the code from the repository or forked it to contribute. Usage and installation instructions are provided in ReadMe.MD', 'cias.png', 0, 1, '2015-09-02 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_paiement`
--

CREATE TABLE IF NOT EXISTS `tbl_paiement` (
  `id` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `devise` varchar(10) NOT NULL,
  `options` text NOT NULL,
  `reference` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `provider` int(11) NOT NULL,
  `date_paiement` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tbl_paiement`
--

INSERT INTO `tbl_paiement` (`id`, `client`, `montant`, `devise`, `options`, `reference`, `status`, `provider`, `date_paiement`) VALUES
(1, 4, 500, 'FC', 'a:2:{s:5:"order";s:1:"1";s:5:"email";s:20:"mercingoma@gmail.com";}', '5222547', 3, 0, '0000-00-00 00:00:00'),
(2, 1, 500, 'FC', 'a:3:{s:5:"order";s:1:"4";s:5:"email";s:20:"mercingoma@gmail.com";s:11:"nom_produit";s:21:"Samsung Galaxy note 3";}', '4566878', 1, 0, '0000-00-00 00:00:00'),
(3, 4, 50, 'USD', 'a:3:{s:8:"commande";s:2:"67";s:12:"email_client";s:20:"mercingoma@gmail.com";s:12:"nom_commande";s:21:"Samsung Galaxy note 3";}', '555454', 4, 0, '0000-00-00 00:00:00'),
(6, 4, 50, 'USD', 'a:3:{s:8:"commande";s:2:"67";s:12:"email_client";s:20:"mercingoma@gmail.com";s:12:"nom_commande";s:21:"Samsung Galaxy note 3";}', '5647892', 2, 0, '0000-00-00 00:00:00'),
(8, 4, 50, 'USD', 'a:3:{s:8:"commande";s:2:"67";s:12:"email_client";s:20:"mercingoma@gmail.com";s:12:"nom_commande";s:21:"Samsung Galaxy note 3";}', '5647784', 2, 0, '0000-00-00 00:00:00'),
(9, 4, 50, 'USD', 'a:3:{s:8:"commande";s:2:"67";s:12:"email_client";s:20:"mercingoma@gmail.com";s:12:"nom_commande";s:21:"Samsung Galaxy note 3";}', '897453', 1, 1, '0000-00-00 00:00:00'),
(10, 4, 50, 'USD', 'a:3:{s:8:"commande";s:2:"67";s:12:"email_client";s:20:"mercingoma@gmail.com";s:12:"nom_commande";s:21:"Samsung Galaxy note 3";}', '4895625', 1, 1, '0000-00-00 00:00:00'),
(11, 4, 50, 'USD', 'a:3:{s:8:"commande";s:2:"67";s:12:"email_client";s:20:"mercingoma@gmail.com";s:12:"nom_commande";s:21:"Samsung Galaxy note 3";}', '5889644', 1, 2, '0000-00-00 00:00:00'),
(12, 4, 50, 'USD', 'a:3:{s:8:"commande";s:2:"67";s:12:"email_client";s:20:"mercingoma@gmail.com";s:12:"nom_commande";s:21:"Samsung Galaxy note 3";}', '566654', 1, 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_roles`
--

CREATE TABLE IF NOT EXISTS `tbl_roles` (
  `roleId` tinyint(4) NOT NULL COMMENT 'role id',
  `role` varchar(50) NOT NULL COMMENT 'role text'
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `tbl_roles`
--

INSERT INTO `tbl_roles` (`roleId`, `role`) VALUES
(1, 'System Administrator'),
(2, 'Manager'),
(3, 'Employee'),
(4, 'vendeur');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `userId` int(11) NOT NULL,
  `email` varchar(128) NOT NULL COMMENT 'login email',
  `password` varchar(128) NOT NULL COMMENT 'hashed login password',
  `name` varchar(128) DEFAULT NULL COMMENT 'full name of user',
  `mobile` varchar(20) DEFAULT NULL,
  `roleId` tinyint(4) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0',
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `tbl_users`
--

INSERT INTO `tbl_users` (`userId`, `email`, `password`, `name`, `mobile`, `roleId`, `isDeleted`, `createdBy`, `createdDtm`, `updatedBy`, `updatedDtm`) VALUES
(1, 'admin@codeinsect.com', '$2y$10$tOKen0Z5FkOr7IV/BOV.Q.LRLplMcU8AKzf33XMLubNHsgJFz4Iiq', 'System Administrator', '9890098900', 1, 0, 0, '2015-07-01 18:56:49', 1, '2017-03-11 07:59:29'),
(2, 'manager@codeinsect.com', '$2y$10$quODe6vkNma30rcxbAHbYuKYAZQqUaflBgc4YpV9/90ywd.5Koklm', 'Manager', '9890098900', 2, 0, 1, '2016-12-09 17:49:56', NULL, NULL),
(3, 'employee@codeinsect.com', '$2y$10$M3ttjnzOV2lZSigBtP0NxuCtKRte70nc8TY5vIczYAQvfG/8syRze', 'Employee', '9890098900', 3, 0, 1, '2016-12-09 17:50:22', NULL, NULL),
(4, 'mercingoma@gmail.com', '$2y$10$bu2URZR/Sz5.RX7EBobEieGzzPE8ULvKq.lhFqDklnFVTzKqHgbbW', 'Mbungu Ngoma', '0811695872', 4, 0, 1, '2017-03-11 10:44:23', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_users_infos`
--

CREATE TABLE IF NOT EXISTS `tbl_users_infos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `info_name` varchar(255) NOT NULL,
  `info_value` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `tbl_users_infos`
--

INSERT INTO `tbl_users_infos` (`id`, `user_id`, `info_name`, `info_value`) VALUES
(1, 4, 'mpesa', '0824109491'),
(2, 4, 'orange_money', '0897641497');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom` (`nom`);

--
-- Index pour la table `tbl_devise`
--
ALTER TABLE `tbl_devise`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD PRIMARY KEY (`itemId`);

--
-- Index pour la table `tbl_paiement`
--
ALTER TABLE `tbl_paiement`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_paiement_reference_uindex` (`reference`);

--
-- Index pour la table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`roleId`);

--
-- Index pour la table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `tbl_users_infos`
--
ALTER TABLE `tbl_users_infos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `info_name` (`info_name`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `tbl_devise`
--
ALTER TABLE `tbl_devise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `tbl_items`
--
ALTER TABLE `tbl_items`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `tbl_paiement`
--
ALTER TABLE `tbl_paiement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `roleId` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'role id',AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `tbl_users_infos`
--
ALTER TABLE `tbl_users_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
