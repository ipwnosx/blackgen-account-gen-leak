-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 22 juil. 2019 à 15:39
-- Version du serveur :  10.3.16-MariaDB
-- Version de PHP :  7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `v3`
--

-- --------------------------------------------------------

--
-- Structure de la table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `accounts_free`
--

CREATE TABLE `accounts_free` (
  `id` int(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `actions`
--

CREATE TABLE `actions` (
  `id` int(64) NOT NULL,
  `admin` varchar(64) NOT NULL,
  `client` varchar(64) NOT NULL,
  `action` varchar(6444) NOT NULL,
  `date` int(21) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `allnotifications`
--

CREATE TABLE `allnotifications` (
  `id` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `icone` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bans`
--

CREATE TABLE `bans` (
  `username` varchar(15) NOT NULL,
  `reason` varchar(1024) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `code`
--

CREATE TABLE `code` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `plan` int(11) NOT NULL,
  `limit_gen` varchar(255) NOT NULL,
  `type_gen` varchar(255) NOT NULL,
  `used` int(11) NOT NULL,
  `date_c` varchar(255) NOT NULL,
  `date_u` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `faq`
--

CREATE TABLE `faq` (
  `id` int(3) NOT NULL,
  `question` varchar(1024) NOT NULL,
  `answer` varchar(5000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`) VALUES
(7, 'Quelles sont les options de paiement disponibles ?', 'Pour l\'instant, nous acceptons Paypal, Bitcoin,Paysafecard'),
(8, 'Est-ce que tous les comptes fonctionnent ?', 'Oui, au moment oÃ¹ nous ajoutons les comptes, tous les comptes fonctionnent. Mais comme c\'est la norme avec tous les gÃ©nÃ©rateurs, les comptes sont partagÃ©s avec les propriÃ©taire et mourront Ã  tout moment, il n\'y a aucun moyen de savoir quand ils cesseront de fonctionner, mais nous faisons de notre mieux pour les tenir Ã  jour.'),
(9, 'C\'est quand le restock fortnite ?', 'Nous ne somme pas des robot et nous fesons notre possible pour restock le plus rapidement que nous pouvons '),
(5, 'Que dois-je faire si un compte ne fonctionne pas ?', 'Si vous en gÃ©nÃ©rez un et qu\'il ne fonctionne pas, signalez le compte et ouvrez un ticket de support pour vous aider. Rappelez-vous, vous devez toujours nous envoyer le mauvais compte que vous obtenez afin de recevoir un remplacement.'),
(1, 'Mon abonnement n\'est pas actif ?', 'Contactez-nous directement via l\'onglet support ou sur notre discord/twitter'),
(2, 'Ã€ quelle frÃ©quence les comptes sont-ils mis Ã  jour ?', 'Les sites les plus populaires sont mis Ã  jour le plus souvent, gÃ©nÃ©ralement plusieurs fois par semaine. D\'autres sites sont moins souvent mis Ã  jour.'),
(3, 'Combien de comptes puis-je gÃ©nÃ©rer par jour ?', 'Tout dÃ©pend du pack que vous choisissez, chaque pack a une limite diffÃ©rente.');

-- --------------------------------------------------------

--
-- Structure de la table `loginlogs`
--

CREATE TABLE `loginlogs` (
  `username` varchar(15) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `date` int(11) NOT NULL,
  `country` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `loginlogs`
--

INSERT INTO `loginlogs` (`username`, `ip`, `date`, `country`) VALUES
('Kirikoo', '::1', 1563800759, 'XX');

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `date` int(11) NOT NULL,
  `visible` int(1) NOT NULL,
  `favori` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `logs_free`
--

CREATE TABLE `logs_free` (
  `id` int(11) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `date` int(11) NOT NULL,
  `visible` int(1) NOT NULL,
  `favori` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `logs_loterie`
--

CREATE TABLE `logs_loterie` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `lot` varchar(255) NOT NULL,
  `date` int(11) NOT NULL,
  `used` int(11) NOT NULL,
  `nb` int(11) NOT NULL,
  `max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `lots`
--

CREATE TABLE `lots` (
  `id_lot` int(11) NOT NULL,
  `nom` varchar(255) CHARACTER SET latin1 NOT NULL,
  `pourcentage` int(10) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lots`
--

INSERT INTO `lots` (`id_lot`, `nom`, `pourcentage`, `type`) VALUES
(1, '1 gÃ©nÃ©ration', 60, 1),
(2, '3 gÃ©nÃ©rations', 16, 1),
(3, '5 gÃ©nÃ©rations', 10, 1),
(4, '10 gÃ©nÃ©rations', 5, 1),
(5, '15 gÃ©nÃ©rations', 3, 1),
(6, 'Grade Basique', 4, 2),
(7, 'Grade Vip', 2, 2),
(8, 'Grade LÃ©gende', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `messageid` int(11) NOT NULL,
  `ticketid` int(11) NOT NULL,
  `content` text NOT NULL,
  `sender` varchar(30) NOT NULL,
  `username` varchar(255) NOT NULL,
  `date` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `news`
--

CREATE TABLE `news` (
  `ID` int(11) NOT NULL,
  `color` varchar(25) NOT NULL,
  `icon` varchar(25) NOT NULL,
  `title` varchar(1024) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `notif`
--

CREATE TABLE `notif` (
  `id` int(11) NOT NULL,
  `id_notif` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `view` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `parrain`
--

CREATE TABLE `parrain` (
  `id` int(11) NOT NULL,
  `pseudo_member` varchar(255) NOT NULL,
  `pseudo_parrain` varchar(255) NOT NULL,
  `plan` varchar(255) NOT NULL,
  `date` int(11) NOT NULL,
  `etat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `partner`
--

CREATE TABLE `partner` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) CHARACTER SET latin1 NOT NULL,
  `description` varchar(255) CHARACTER SET latin1 NOT NULL,
  `lien` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `gif` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `payments`
--

CREATE TABLE `payments` (
  `ID` int(11) NOT NULL,
  `paid` float NOT NULL,
  `plan` int(11) NOT NULL,
  `user` int(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `tid` varchar(255) NOT NULL,
  `date` int(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `plans`
--

CREATE TABLE `plans` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `accounts` longtext DEFAULT NULL,
  `limit` int(11) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `length` int(11) NOT NULL,
  `price` float NOT NULL,
  `private` int(1) NOT NULL,
  `discordid` varchar(40) NOT NULL,
  `color` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `plans`
--

INSERT INTO `plans` (`ID`, `name`, `accounts`, `limit`, `unit`, `length`, `price`, `private`, `discordid`, `color`) VALUES
(21, 'Basique', 'Udemy,OrangeTV,Spotify,Uplay,Mail Access,Crunchyroll,Mega.nz,Wish.com,Hulu,WWE', 2, 'Days', 1, 1, 0, '438438729783181312', 'rgb(80, 172, 52)'),
(22, 'VIP', 'Udemy,OrangeTV,Spotify,Uplay,Mail Access,Crunchyroll,Mega.nz,Wish.com,Hulu,WWE', 6, 'Months', 1, 6, 0, '438438729766404109', 'rgb(253, 230, 6)'),
(23, 'VIP +', 'Napster,Playstation,Leboncoin,Udemy,Mediafire,Spotify,Fortnite,Uplay,Netflix,PornHub,Mail Access,Deezer,Crunchyroll,Minecraft,WWE,OrangeTV,Mega.nz,Origin,Hulu,WWE', 12, 'Months', 3, 15, 0, '438438728701050880', 'rgb(237, 122, 17)'),
(24, 'Elite', 'Napster,Playstation,Leboncoin,Udemy,Mediafire,Spotify,Fortnite,Uplay,Netflix,PornHub,Mail Access,Deezer,Crunchyroll,Minecraft,WWE,OrangeTV,Mega.nz,Origin,Hulu,WWE', 15, 'Months', 4, 20, 0, '496717613443842049', 'rgba(233, 101, 255, 0.96)'),
(25, 'Elite +', 'Napster,Playstation,Leboncoin,Udemy,Mediafire,Spotify,Fortnite,Uplay,Netflix,PornHub,Mail Access,Deezer,Crunchyroll,Minecraft,WWE,OrangeTV,Mega.nz,Origin,Hulu,WWE', 25, 'Months', 5, 25, 0, '438438727405273108', 'rgb(0, 208, 243)'),
(26, 'Staff Black-Gen', 'Napster,Playstation,Leboncoin,Udemy,Mediafire,Spotify,Fortnite,Uplay,Netflix,PornHub,Mail Access,Deezer,Crunchyroll,Minecraft,WWE,OrangeTV,Mega.nz,Origin,Hulu,WWE', 2147483645, 'Years', 99, 999, 1, '438437317284462592', 'rgb(255, 0, 0)'),
(33, 'Starter', 'Udemy,OrangeTV,Spotify,Uplay,Mail Access,Crunchyroll,Mega.nz,Wish.com,Hulu,WWE', 3, 'Days', 3, 3, 0, '501122744168087563', 'rgb(7, 37, 217)'),
(34, 'Premium', 'Napster,Playstation,Leboncoin,Udemy,Mediafire,Spotify,Fortnite,Uplay,Netflix,PornHub,Mail Access,Deezer,Crunchyroll,Minecraft,WWE,OrangeTV,Mega.nz,Origin,Hulu,WWE', 10, 'Months', 2, 10, 0, '501123749353881619', 'rgb(237, 34, 72)'),
(35, 'Legende', 'Napster,Playstation,Leboncoin,Udemy,Mediafire,Spotify,Fortnite,Uplay,Netflix,PornHub,Mail Access,Deezer,Crunchyroll,Minecraft,WWE,OrangeTV,Mega.nz,Origin,Hulu,WWE', 30, 'Months', 6, 30, 0, '501126810097025024', 'rgb(183, 0, 241)');

-- --------------------------------------------------------

--
-- Structure de la table `plans_free`
--

CREATE TABLE `plans_free` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `accounts` longtext DEFAULT NULL,
  `limit` int(11) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `length` int(11) NOT NULL,
  `price` float NOT NULL,
  `private` int(1) NOT NULL,
  `discordid` varchar(40) NOT NULL,
  `color` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `plans_free`
--

INSERT INTO `plans_free` (`ID`, `name`, `accounts`, `limit`, `unit`, `length`, `price`, `private`, `discordid`, `color`) VALUES
(1, 'Générateur gratuit', NULL, 5, '0', 0, 0, 0, '0', '0');

-- --------------------------------------------------------

--
-- Structure de la table `reminder`
--

CREATE TABLE `reminder` (
  `id` int(11) NOT NULL,
  `id_member` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `used` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `report` varchar(644) NOT NULL,
  `date` int(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `report_log`
--

CREATE TABLE `report_log` (
  `ID` int(11) NOT NULL,
  `id_log` int(11) NOT NULL,
  `etat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `sitename` varchar(1024) NOT NULL,
  `description` text NOT NULL,
  `paypal` varchar(50) NOT NULL,
  `bitcoin` varchar(50) NOT NULL,
  `maintaince` varchar(100) NOT NULL,
  `url` varchar(50) NOT NULL,
  `rotation` int(1) NOT NULL DEFAULT 0,
  `testboots` int(1) NOT NULL,
  `skype` varchar(200) NOT NULL,
  `key` varchar(100) NOT NULL,
  `coinpayments` varchar(50) NOT NULL,
  `ipnSecret` varchar(100) NOT NULL,
  `google_site` varchar(644) NOT NULL,
  `google_secret` varchar(644) NOT NULL,
  `btc_address` varchar(64) NOT NULL,
  `secretKey` varchar(50) NOT NULL,
  `gen_free` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `settings`
--

INSERT INTO `settings` (`sitename`, `description`, `paypal`, `bitcoin`, `maintaince`, `url`, `rotation`, `testboots`, `skype`, `key`, `coinpayments`, `ipnSecret`, `google_site`, `google_secret`, `btc_address`, `secretKey`, `gen_free`) VALUES
('Votre-Gen', 'Black-Gen est le meilleur gÃ©nÃ©rateur de qualitÃ© et Ã  faible prix jamais inventÃ©, disposant plus de 40 gÃ©nÃ©rateurs actuellement | netflix, fortnite & more ..', '1', '1', '', 'https://www.black-gen.pw/', 1, 1, 'Kirikoo#2379', 'Kirikoo#2379', 'Votre CoinPayment', 'Votre IPN', '6Ld34a4UAAAAABEFPIojHlvzhhzDqGXXzPB1KsfD', '6Ld34a4UAAAAAFYDo5-X0RuLF3HcxWpKZvrBneG2', '1LuoMcAKB9kTFK8RukKRkj5B8E1cYPtvZK', 'x01AhBQ8Uc-Vivhtvp-j7w', 1);

-- --------------------------------------------------------

--
-- Structure de la table `stats`
--

CREATE TABLE `stats` (
  `id` int(11) NOT NULL,
  `gen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `subject` varchar(1024) NOT NULL,
  `content` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `username` varchar(15) NOT NULL,
  `date` int(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `img` varchar(255) NOT NULL,
  `lien` varchar(2024) NOT NULL,
  `raison` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `type_free`
--

CREATE TABLE `type_free` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `img` varchar(255) NOT NULL,
  `lien` varchar(2024) NOT NULL,
  `raison` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(80) NOT NULL,
  `email` varchar(50) NOT NULL,
  `rank` int(11) NOT NULL DEFAULT 0,
  `membership` int(11) NOT NULL,
  `expire` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `referral` varchar(50) NOT NULL,
  `referralbalance` int(3) NOT NULL DEFAULT 0,
  `testattack` int(1) NOT NULL,
  `activity` int(64) NOT NULL DEFAULT 0,
  `discord` bigint(20) NOT NULL,
  `discordapi` varchar(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID`, `username`, `password`, `email`, `rank`, `membership`, `expire`, `status`, `referral`, `referralbalance`, `testattack`, `activity`, `discord`, `discordapi`) VALUES
(1, 'Kirikoo', 'c7c984aeca59948967d0447a5125329a27d198c6', 'kirikoo@black-gen.pw', 1, 0, 0, 0, '0', 0, 0, 1563802771, 0, '0');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `accounts_free`
--
ALTER TABLE `accounts_free`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `allnotifications`
--
ALTER TABLE `allnotifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `code`
--
ALTER TABLE `code`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `logs_free`
--
ALTER TABLE `logs_free`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `logs_loterie`
--
ALTER TABLE `logs_loterie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id_lot`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageid`);

--
-- Index pour la table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parrain`
--
ALTER TABLE `parrain`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `partner`
--
ALTER TABLE `partner`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `plans_free`
--
ALTER TABLE `plans_free`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `reminder`
--
ALTER TABLE `reminder`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reports`
--
ALTER TABLE `reports`
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `report_log`
--
ALTER TABLE `report_log`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD UNIQUE KEY `key` (`key`),
  ADD KEY `sitename` (`sitename`(767));

--
-- Index pour la table `stats`
--
ALTER TABLE `stats`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `type_free`
--
ALTER TABLE `type_free`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `accounts_free`
--
ALTER TABLE `accounts_free`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `allnotifications`
--
ALTER TABLE `allnotifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `code`
--
ALTER TABLE `code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `logs_free`
--
ALTER TABLE `logs_free`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `logs_loterie`
--
ALTER TABLE `logs_loterie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `lots`
--
ALTER TABLE `lots`
  MODIFY `id_lot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `messageid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `news`
--
ALTER TABLE `news`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `notif`
--
ALTER TABLE `notif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parrain`
--
ALTER TABLE `parrain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `partner`
--
ALTER TABLE `partner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `payments`
--
ALTER TABLE `payments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `plans`
--
ALTER TABLE `plans`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `plans_free`
--
ALTER TABLE `plans_free`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `reminder`
--
ALTER TABLE `reminder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `report_log`
--
ALTER TABLE `report_log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=350;

--
-- AUTO_INCREMENT pour la table `stats`
--
ALTER TABLE `stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_free`
--
ALTER TABLE `type_free`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
