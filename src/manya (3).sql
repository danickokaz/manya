-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 24 mars 2025 à 08:36
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `manya`
--

-- --------------------------------------------------------

--
-- Structure de la table `etat_civil`
--

CREATE TABLE `etat_civil` (
  `id` int(1) NOT NULL,
  `libelle_etat_civil` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etat_civil`
--

INSERT INTO `etat_civil` (`id`, `libelle_etat_civil`) VALUES
(1, 'Célibataire'),
(2, 'Marié(e)'),
(3, 'Veuf(ve)'),
(4, 'Divorcé(e)');

-- --------------------------------------------------------

--
-- Structure de la table `etat_etudiant`
--

CREATE TABLE `etat_etudiant` (
  `id` int(1) NOT NULL,
  `libelle_etat_etudiant` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etat_etudiant`
--

INSERT INTO `etat_etudiant` (`id`, `libelle_etat_etudiant`) VALUES
(1, 'Non validé(e)'),
(2, 'Validé(e)'),
(3, 'Dossiers validés');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `id` bigint(20) NOT NULL,
  `matricule` varchar(15) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `postnom` varchar(50) DEFAULT NULL,
  `genre` int(1) NOT NULL,
  `adresse_physique` text DEFAULT NULL,
  `date_naissance` date NOT NULL,
  `lieu_naissance` varchar(50) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `id_type_inscription` int(11) NOT NULL,
  `id_etat_civile` int(11) NOT NULL,
  `id_nationalite` int(11) NOT NULL,
  `id_etat_etudiant` int(1) NOT NULL,
  `id_inscription` int(11) DEFAULT NULL,
  `image_photo` varchar(30) DEFAULT 'default.png',
  `motdepasse` varchar(255) NOT NULL DEFAULT '7c222fb2927d828af22f592134e8932480637c0d',
  `date_enregistrement` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`id`, `matricule`, `prenom`, `nom`, `postnom`, `genre`, `adresse_physique`, `date_naissance`, `lieu_naissance`, `telephone`, `id_type_inscription`, `id_etat_civile`, `id_nationalite`, `id_etat_etudiant`, `id_inscription`, `image_photo`, `motdepasse`, `date_enregistrement`) VALUES
(1, 'JGM0000001', 'DAN', 'KAZADI', 'KAPENGA', 2, '68, gemena, C/KASA-VUBU', '1999-09-05', 'KINSHASA', '0974788162', 2, 1, 1, 2, 2, 'default.png', '7c222fb2927d828af22f592134e8932480637c0d', '2025-03-22'),
(2, 'JGM0000002', 'JEMIMA', 'KAZADI', 'KIBUNDULU', 1, '68, gemena, C/KASA-VUBU', '2003-12-16', 'KINSHASA', '0974788162', 1, 1, 1, 2, 2, 'default.png', '7c222fb2927d828af22f592134e8932480637c0d', '2025-03-22'),
(3, 'JGM0000003', 'DAVID', 'KAZADI', 'MUTAMBA', 2, '68, gemena, C/KASA-VUBU', '2002-05-31', 'KINSHASA', '0978517530', 1, 1, 1, 2, 2, 'default.png', '7c222fb2927d828af22f592134e8932480637c0d', '2025-03-22'),
(4, 'JGM0000004', 'KEVIN', 'KAZADI', 'KAZADI', 2, '68, gemena, C/KASA-VUBU', '1998-04-30', 'KINSHASA', '0825453982', 2, 1, 1, 2, 2, 'default.png', '7c222fb2927d828af22f592134e8932480637c0d', '2025-03-22');

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

CREATE TABLE `genre` (
  `id` int(1) NOT NULL,
  `libelle_genre` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id`, `libelle_genre`) VALUES
(1, 'F'),
(2, 'M');

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `id` int(11) NOT NULL,
  `libelle_inscription` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id`, `libelle_inscription`) VALUES
(1, '2023-2024'),
(2, '2024-2025');

-- --------------------------------------------------------

--
-- Structure de la table `nationalite`
--

CREATE TABLE `nationalite` (
  `id` int(3) NOT NULL,
  `libelle_nationalite` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `nationalite`
--

INSERT INTO `nationalite` (`id`, `libelle_nationalite`) VALUES
(1, 'Congolaise');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(2) NOT NULL,
  `libelle_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `libelle_role`) VALUES
(1, 'Administrateur'),
(2, 'Professeur'),
(3, 'Caissier/ère');

-- --------------------------------------------------------

--
-- Structure de la table `type_inscription`
--

CREATE TABLE `type_inscription` (
  `id` int(1) NOT NULL,
  `libelle_type_inscription` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_inscription`
--

INSERT INTO `type_inscription` (`id`, `libelle_type_inscription`) VALUES
(1, 'Étudiant(e) ordinaire'),
(2, 'Fonctionnaire de l\'État');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `matricule` varchar(15) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `motdepasse` varchar(100) NOT NULL,
  `id_role` int(2) NOT NULL,
  `token` varchar(100) NOT NULL,
  `image_profile` varchar(100) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `matricule`, `pseudo`, `motdepasse`, `id_role`, `token`, `image_profile`) VALUES
(1, '1515101', 'Dan KAZADI', '7c222fb2927d828af22f592134e8932480637c0d', 1, 'a7b9f5c3256d2c8058fc5718f68e069f43f672a8', 'dafault.webp');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `etat_civil`
--
ALTER TABLE `etat_civil`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `etat_etudiant`
--
ALTER TABLE `etat_etudiant`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matricule` (`matricule`),
  ADD KEY `id` (`id`),
  ADD KEY `id_nationalite` (`id_nationalite`),
  ADD KEY `id_2` (`id`),
  ADD KEY `id_etat_civile` (`id_etat_civile`),
  ADD KEY `id_etat_etudiant` (`id_etat_etudiant`),
  ADD KEY `id_type_inscription` (`id_type_inscription`),
  ADD KEY `genre` (`genre`),
  ADD KEY `id_inscription` (`id_inscription`);

--
-- Index pour la table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `nationalite`
--
ALTER TABLE `nationalite`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_inscription`
--
ALTER TABLE `type_inscription`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `etat_civil`
--
ALTER TABLE `etat_civil`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `etat_etudiant`
--
ALTER TABLE `etat_etudiant`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `nationalite`
--
ALTER TABLE `nationalite`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `type_inscription`
--
ALTER TABLE `type_inscription`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `etudiant_ibfk_1` FOREIGN KEY (`id_etat_civile`) REFERENCES `etat_civil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `etudiant_ibfk_2` FOREIGN KEY (`id_etat_etudiant`) REFERENCES `etat_etudiant` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `etudiant_ibfk_3` FOREIGN KEY (`id_nationalite`) REFERENCES `nationalite` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `etudiant_ibfk_4` FOREIGN KEY (`id_type_inscription`) REFERENCES `type_inscription` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `etudiant_ibfk_5` FOREIGN KEY (`genre`) REFERENCES `genre` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `etudiant_ibfk_6` FOREIGN KEY (`id_inscription`) REFERENCES `inscription` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
