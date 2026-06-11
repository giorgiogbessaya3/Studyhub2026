-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 09 juin 2026 à 13:34
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `studyhub1`
--

-- --------------------------------------------------------

--
-- Structure de la table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `status` enum('published','draft') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chapitres`
--

CREATE TABLE `chapitres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `classe_id` bigint(20) UNSIGNED NOT NULL,
  `matiere_id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `ordre` int(11) NOT NULL DEFAULT 0,
  `statut` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chapitres`
--

INSERT INTO `chapitres` (`id`, `classe_id`, `matiere_id`, `titre`, `slug`, `description`, `ordre`, `statut`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'Calcul littéral', 'calcul-litteral', 'Développement, factorisation et équations', 1, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(2, 4, 1, 'Fonctions affines', 'fonctions-affines', 'Représentation graphique et variations', 2, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(3, 4, 1, 'Théorème de Thalès', 'theoreme-de-thales', 'Configuration et démonstration', 3, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(4, 4, 1, 'Trigonométrie', 'trigonometrie', 'Cosinus, sinus et tangente', 4, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(5, 4, 1, 'Statistiques', 'statistiques', 'Moyenne, médiane et étendue', 5, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(6, 4, 2, 'Le récit fantastique', 'le-recit-fantastique', 'Analyse du genre fantastique', 1, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(7, 4, 2, 'La poésie engagée', 'la-poesie-engagee', 'Étude des poèmes engagés', 2, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(8, 4, 2, 'L\'argumentation', 'largumentation', 'Techniques et structure argumentative', 3, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(9, 4, 2, 'Le théâtre classique', 'le-theatre-classique', 'Molière et la comédie de caractère', 4, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(10, 4, 3, 'Circuits électriques', 'circuits-electriques', 'Loi d\'Ohm et circuits', 1, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(11, 4, 3, 'La lumière', 'la-lumiere', 'Propagation et réfraction', 2, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(12, 4, 3, 'Réactions chimiques', 'reactions-chimiques', 'Transformation de la matière', 3, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(13, 4, 3, 'Le mouvement', 'le-mouvement', 'Vitesse et trajectoire', 4, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(14, 4, 4, 'La photosynthèse', 'la-photosynthese', 'Production de matière par les plantes', 1, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(15, 4, 4, 'Le système nerveux', 'le-systeme-nerveux', 'De la réception à la réponse', 2, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(16, 4, 4, 'La tectonique des plaques', 'la-tectonique-des-plaques', 'Dérive des continents', 3, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(17, 4, 5, 'Daily routines', 'daily-routines', 'Present simple and adverbs', 1, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(18, 4, 5, 'Future plans', 'future-plans', 'Be going to and will', 2, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(19, 4, 5, 'Past experiences', 'past-experiences', 'Present perfect simple', 3, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(20, 4, 6, 'La Révolution française', 'la-revolution-francaise', '1789-1799 : de l\'Ancien Régime à l\'Empire', 1, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(21, 4, 6, 'La Seconde Guerre mondiale', 'la-seconde-guerre-mondiale', '1939-1945 : conflit mondial', 2, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(22, 4, 6, 'Les dynamiques territoriales', 'les-dynamiques-territoriales', 'Aménagement durable', 3, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(23, 7, 1, 'Fonction logarithme Neperien', 'fonction-logarithme-neperien', NULL, 6, 1, '2026-05-29 17:49:34', '2026-05-29 17:49:34'),
(24, 7, 1, 'Primitives', 'primitives', NULL, 7, 1, '2026-05-29 17:59:23', '2026-05-29 17:59:23');

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `cycle` enum('college','lycee') NOT NULL,
  `description` text DEFAULT NULL,
  `ordre` int(11) NOT NULL DEFAULT 0,
  `statut` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`id`, `nom`, `cycle`, `description`, `ordre`, `statut`, `created_at`, `updated_at`) VALUES
(1, '6ème', 'college', 'Cycle d\'adaptation', 1, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(2, '5ème', 'college', 'Cycle central', 2, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(3, '4ème', 'college', 'Cycle central', 3, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(4, '3ème', 'college', 'Diplôme du Brevet', 4, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(5, 'Seconde', 'lycee', 'Classe de détermination', 5, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(6, 'Première', 'lycee', 'Première année du cycle terminal', 6, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(7, 'Terminale', 'lycee', 'Diplôme du Baccalauréat', 7, 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(8, 'Terminale D', 'lycee', 'Diplôme du Baccalauréat', 0, 1, '2026-05-29 18:33:53', '2026-05-29 18:35:39'),
(9, 'Terminale C', 'lycee', 'Diplôme du Baccalauréat', 0, 1, '2026-05-29 18:38:00', '2026-05-29 18:38:00'),
(10, 'Terminale A', 'lycee', 'Diplôme du Baccalauréat', 0, 1, '2026-05-29 18:38:20', '2026-05-29 18:38:20'),
(11, 'Terminale S', 'lycee', 'Diplôme du Baccalauréat', 0, 1, '2026-05-29 18:39:45', '2026-05-29 18:39:45'),
(12, 'Terminale B', 'lycee', 'Diplôme du Baccalauréat', 0, 1, '2026-05-29 18:40:10', '2026-05-29 18:40:10');

-- --------------------------------------------------------

--
-- Structure de la table `classe_matiere`
--

CREATE TABLE `classe_matiere` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `classe_id` bigint(20) UNSIGNED NOT NULL,
  `matiere_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classe_matiere`
--

INSERT INTO `classe_matiere` (`id`, `classe_id`, `matiere_id`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '2026-05-29 17:48:27', '2026-05-29 17:48:27'),
(2, 2, 5, '2026-05-29 17:48:27', '2026-05-29 17:48:27'),
(3, 3, 5, '2026-05-29 17:48:27', '2026-05-29 17:48:27'),
(4, 4, 5, '2026-05-29 17:48:27', '2026-05-29 17:48:27'),
(5, 5, 5, '2026-05-29 17:48:27', '2026-05-29 17:48:27'),
(6, 6, 5, '2026-05-29 17:48:27', '2026-05-29 17:48:27'),
(7, 7, 5, '2026-05-29 17:48:27', '2026-05-29 17:48:27'),
(8, 1, 1, '2026-05-29 17:48:54', '2026-05-29 17:48:54'),
(9, 2, 1, '2026-05-29 17:48:54', '2026-05-29 17:48:54'),
(10, 3, 1, '2026-05-29 17:48:54', '2026-05-29 17:48:54'),
(11, 4, 1, '2026-05-29 17:48:54', '2026-05-29 17:48:54'),
(12, 5, 1, '2026-05-29 17:48:54', '2026-05-29 17:48:54'),
(13, 6, 1, '2026-05-29 17:48:54', '2026-05-29 17:48:54'),
(14, 7, 1, '2026-05-29 17:48:54', '2026-05-29 17:48:54');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `lu` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('new','read','replied','archived') NOT NULL DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contenus`
--

CREATE TABLE `contenus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chapitre_id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `resume` longtext NOT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `exercices` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`exercices`)),
  `ordre` int(11) NOT NULL DEFAULT 0,
  `statut` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `corrections`
--

CREATE TABLE `corrections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `epreuve_id` bigint(20) UNSIGNED NOT NULL,
  `fichier` varchar(255) DEFAULT NULL,
  `nom_fichier_original` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `epreuves`
--

CREATE TABLE `epreuves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type_epreuve_id` bigint(20) UNSIGNED NOT NULL,
  `fichier` varchar(255) DEFAULT NULL,
  `nom_fichier_original` varchar(255) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `bareme` int(11) DEFAULT NULL,
  `statut` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `epreuves`
--

INSERT INTO `epreuves` (`id`, `titre`, `slug`, `description`, `type_epreuve_id`, `fichier`, `nom_fichier_original`, `annee`, `duree`, `bareme`, `statut`, `created_at`, `updated_at`) VALUES
(1, 'DEVOIRS SURVEILLE', 'devoirs-surveille-anyt0', 'DEUXIEME  SERIE DE DEVOIRS SURVEILLES DU PREMIER SEMESTRE CEG ZONGO', 1, 'epreuves/BsnwGxrOBILn9LgpDaOTIK2bX3o9yTqNZHpqYDca.docx', '2D1S TLED CEG ZONGO 23-24 ER.docx', 2024, 240, 21, 1, '2026-05-29 18:11:05', '2026-05-29 18:22:35'),
(2, 'DEVOIR SURVEILLE', 'devoir-surveille-pa0sy', '1er DEVOIR SURVEILLE DU 1 er SEMESTRE CEG ZONGO PARAKOU', 1, 'epreuves/dytwUGvhPqgK5g1frwEdBDWISVY1a4xSvWcuCZWI.docx', '20201209_DS_8_790_2020-2021_86-17-24-28-39-114-30-64-31-26-32-33-65-34-27-35-36-66-37-25_.docx', 2020, NULL, NULL, 1, '2026-05-29 18:22:20', '2026-05-29 18:23:12'),
(3, 'Devoirs surveillés', 'devoirs-surveilles-iitpp', 'Première série des devoirs surveillés du premier semestre Prytanée Militaire de Bembèrèkè', 1, 'epreuves/DlCRAGXvh9hgo6ERbdj2INvetBbkkki1PH9JlZpX.pdf', '20210101_DS_3_964_2020-2021_35-36-37-25_.pdf', 2020, NULL, NULL, 1, '2026-05-29 18:30:34', '2026-05-29 18:30:34'),
(4, 'DEVOIR SURVEILLE', 'devoir-surveille-xkzmc', 'DEUXIEME SERIE DES EVALUATIONS SOMMATIVES DU PREMIER SEMESTRE CEG TANKPE', 1, 'epreuves/be6RAmR0YVXrXh79xKxXZUnKZQDgMUSmjmibUXcq.pdf', '20210118_DS_1_341_2020-2021_86-17-24-28-39-30-64-31-26-33-65-34-27-35-36-66-37-25_.pdf', 2026, NULL, NULL, 1, '2026-05-29 18:46:03', '2026-05-29 18:46:03');

-- --------------------------------------------------------

--
-- Structure de la table `epreuve_classe`
--

CREATE TABLE `epreuve_classe` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `epreuve_id` bigint(20) UNSIGNED NOT NULL,
  `classe_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `epreuve_classe`
--

INSERT INTO `epreuve_classe` (`id`, `epreuve_id`, `classe_id`, `created_at`, `updated_at`) VALUES
(1, 1, 7, '2026-05-29 18:11:05', '2026-05-29 18:11:05'),
(2, 2, 4, '2026-05-29 18:22:20', '2026-05-29 18:22:20'),
(3, 2, 3, '2026-05-29 18:22:20', '2026-05-29 18:22:20'),
(4, 2, 2, '2026-05-29 18:22:20', '2026-05-29 18:22:20'),
(5, 2, 1, '2026-05-29 18:22:20', '2026-05-29 18:22:20'),
(6, 2, 6, '2026-05-29 18:22:20', '2026-05-29 18:22:20'),
(7, 2, 5, '2026-05-29 18:22:20', '2026-05-29 18:22:20'),
(8, 2, 7, '2026-05-29 18:22:20', '2026-05-29 18:22:20'),
(9, 3, 7, '2026-05-29 18:30:34', '2026-05-29 18:30:34'),
(10, 4, 4, '2026-05-29 18:46:03', '2026-05-29 18:46:03'),
(11, 4, 3, '2026-05-29 18:46:03', '2026-05-29 18:46:03'),
(12, 4, 2, '2026-05-29 18:46:03', '2026-05-29 18:46:03'),
(13, 4, 1, '2026-05-29 18:46:03', '2026-05-29 18:46:03'),
(14, 4, 6, '2026-05-29 18:46:03', '2026-05-29 18:46:03'),
(15, 4, 5, '2026-05-29 18:46:03', '2026-05-29 18:46:03'),
(16, 4, 7, '2026-05-29 18:46:03', '2026-05-29 18:46:03'),
(17, 4, 10, '2026-05-29 18:46:03', '2026-05-29 18:46:03'),
(18, 4, 12, '2026-05-29 18:46:03', '2026-05-29 18:46:03'),
(19, 4, 9, '2026-05-29 18:46:03', '2026-05-29 18:46:03'),
(20, 4, 8, '2026-05-29 18:46:03', '2026-05-29 18:46:03'),
(21, 4, 11, '2026-05-29 18:46:03', '2026-05-29 18:46:03');

-- --------------------------------------------------------

--
-- Structure de la table `epreuve_matiere`
--

CREATE TABLE `epreuve_matiere` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `epreuve_id` bigint(20) UNSIGNED NOT NULL,
  `matiere_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `epreuve_matiere`
--

INSERT INTO `epreuve_matiere` (`id`, `epreuve_id`, `matiere_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2026-05-29 18:11:05', '2026-05-29 18:11:05'),
(2, 2, 6, '2026-05-29 18:22:20', '2026-05-29 18:22:20'),
(3, 3, 2, '2026-05-29 18:30:34', '2026-05-29 18:30:34'),
(4, 4, 1, '2026-05-29 18:46:03', '2026-05-29 18:46:03');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

CREATE TABLE `matieres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `couleur` varchar(255) NOT NULL DEFAULT '#2563eb',
  `icone` varchar(255) NOT NULL DEFAULT 'ti-book',
  `statut` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `matieres`
--

INSERT INTO `matieres` (`id`, `nom`, `code`, `description`, `image`, `couleur`, `icone`, `statut`, `created_at`, `updated_at`) VALUES
(1, 'Mathématiques', 'MATH', 'Algèbre, géométrie, analyse et probabilités', NULL, '#2563eb', 'ti-calculator', 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(2, 'Français', 'FR', 'Littérature, grammaire et expression écrite', NULL, '#9333ea', 'ti-book', 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(3, 'Physique-Chimie', 'PC', 'Mécanique, électricité, chimie organique et minérale', NULL, '#10b981', 'ti-flask', 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(4, 'SVT', 'SVT', 'Sciences de la vie et de la Terre', NULL, '#059669', 'ti-leaf', 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(5, 'Anglais', 'ANG', 'Langue anglaise et culture anglo-saxonne', NULL, '#f59e0b', 'ti-language', 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(6, 'Histoire-Géographie', 'HG', 'Histoire du monde et géographie physique et humaine', NULL, '#d97706', 'ti-globe', 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(7, 'Philosophie', 'PHILO', 'Introduction à la philosophie et aux grands penseurs', NULL, '#64748b', 'ti-bulb', 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(8, 'SES', 'SES', 'Sciences économiques et sociales', NULL, '#ec4899', 'ti-chart-bar', 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2022_11_17_210533_add_details_to_users_table', 1),
(7, '2022_11_24_153520_create_sliders_table', 1),
(8, '2022_12_07_195805_create_user_details_table', 1),
(9, '2025_10_24_112538_create_blogs_table', 1),
(10, '2025_10_24_163223_create_settings_table', 1),
(11, '2025_10_24_171013_create_contacts_table', 1),
(12, '2026_03_06_113342_create_classes_table', 1),
(13, '2026_03_06_121122_create_matieres_table', 1),
(14, '2026_03_06_140151_create_type_epreuves_table', 1),
(15, '2026_03_06_143343_create_epreuves_table', 1),
(16, '2026_03_06_143428_create_corrections_table', 1),
(17, '2026_03_06_163544_create_chapitres_table', 1),
(18, '2026_03_07_075751_create_contenus_table', 1),
(19, '2026_03_09_085931_add_statut_to_contenus_table', 1),
(20, '2026_03_12_121228_create_questions_table', 1),
(21, '2026_03_12_121311_create_reponses_table', 1),
(22, '2026_03_12_174048_create_quizzes_table', 1),
(23, '2026_03_12_174117_create_quiz_questions_table', 1),
(24, '2026_03_12_174138_create_quiz_resultats_table', 1),
(25, '2026_03_13_133738_add_avatar_to_users_table', 1),
(26, '2026_03_16_080353_add_lu_to_contacts_table', 1),
(27, '2026_05_18_165627_create_epreuve_classe_table', 1),
(28, '2026_05_18_165701_create_epreuve_matiere_table', 1),
(29, '2026_05_18_165750_remove_classe_matiere_from_epreuves_table', 1),
(30, '2026_05_18_180250_add_slug_to_classes_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `classe_id` bigint(20) UNSIGNED NOT NULL,
  `matiere_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `statut` enum('en_attente','publiee','resolue','fermee') NOT NULL DEFAULT 'en_attente',
  `views` int(11) NOT NULL DEFAULT 0,
  `reponses_count` int(11) NOT NULL DEFAULT 0,
  `derniere_reponse_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `classe_id` bigint(20) UNSIGNED NOT NULL,
  `matiere_id` bigint(20) UNSIGNED NOT NULL,
  `chapitre_id` bigint(20) UNSIGNED DEFAULT NULL,
  `duree` int(11) NOT NULL DEFAULT 30,
  `nombre_questions` int(11) NOT NULL DEFAULT 0,
  `score_passer` int(11) NOT NULL DEFAULT 50,
  `statut` enum('brouillon','publie','archive') NOT NULL DEFAULT 'brouillon',
  `image` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) NOT NULL,
  `type` enum('qcm','texte','vrai_faux') NOT NULL DEFAULT 'qcm',
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `bonne_reponse` text NOT NULL,
  `points` int(11) NOT NULL DEFAULT 1,
  `explication` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `ordre` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_resultats`
--

CREATE TABLE `quiz_resultats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `score` int(11) NOT NULL DEFAULT 0,
  `reponses` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`reponses`)),
  `temps_ecoule` int(11) NOT NULL DEFAULT 0,
  `termine_le` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

CREATE TABLE `reponses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contenu` text NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `statut` enum('en_attente','approuvee','rejetee') NOT NULL DEFAULT 'en_attente',
  `est_solution` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) NOT NULL DEFAULT 'Kounde Avocats',
  `site_description` text DEFAULT NULL,
  `site_email` varchar(255) NOT NULL DEFAULT 'contact@kounde-avocats.com',
  `site_phone` varchar(255) NOT NULL DEFAULT '+33 6 66 69 00 80',
  `site_address` text NOT NULL DEFAULT '123 Rue de la Loi, 31000 Toulouse',
  `working_hours` varchar(255) NOT NULL DEFAULT 'Lun - Sam: 9h - 18h',
  `contact_email` varchar(255) NOT NULL DEFAULT 'contact@kounde-avocats.com',
  `contact_phone` varchar(255) NOT NULL DEFAULT '+33 6 66 69 00 80',
  `contact_address` text NOT NULL DEFAULT '123 Rue de la Loi, 31000 Toulouse',
  `contact_map_url` varchar(255) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `google_analytics` text DEFAULT NULL,
  `footer_description` text DEFAULT NULL,
  `footer_copyright` varchar(255) NOT NULL DEFAULT '© 2025 Kounde Avocats - Tous droits réservés',
  `newsletter_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `site_logo` varchar(255) DEFAULT NULL,
  `site_favicon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0' COMMENT '1=hidden,0=visible',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_epreuves`
--

CREATE TABLE `type_epreuves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `icone` varchar(255) DEFAULT NULL,
  `statut` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_epreuves`
--

INSERT INTO `type_epreuves` (`id`, `nom`, `slug`, `description`, `icone`, `statut`, `created_at`, `updated_at`) VALUES
(1, 'Devoir', 'devoir', 'Évaluation écrite ou pratique portant sur une partie du programme.', 'ti-file-text', 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(2, 'Interrogation', 'interrogation', 'Courte évaluation souvent inopinée, portant sur une notion spécifique.', 'ti-checklist', 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(3, 'Examen blanc', 'examen-blanc', 'Simulation d\'examen dans des conditions réelles pour préparer l\'épreuve officielle.', 'ti-edit', 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57'),
(4, 'Révision', 'revision', 'Exercices et supports destinés à consolider les connaissances.', 'ti-book', 1, '2026-05-29 17:40:57', '2026-05-29 17:40:57');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_as` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=user, 1=admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `bio`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_as`) VALUES
(1, 'Giorgio GBESSAYA', 'giorgiogbessaya33@gmail.com', 'avatars/cs9Vm78vkJdp4coKhOKCt70NjO1zMKBpGQ8F5Ti1.jpg', NULL, NULL, '$2y$10$eOVSKSBcDIKGupXMxkRt3u3HlODLNeC2m0LTBfmhcLQ0wT26ONnpi', NULL, '2026-05-29 17:43:11', '2026-06-03 19:28:05', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chapitres`
--
ALTER TABLE `chapitres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chapitres_classe_id_matiere_id_titre_unique` (`classe_id`,`matiere_id`,`titre`),
  ADD UNIQUE KEY `chapitres_slug_unique` (`slug`),
  ADD KEY `chapitres_matiere_id_foreign` (`matiere_id`);

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `classes_nom_unique` (`nom`);

--
-- Index pour la table `classe_matiere`
--
ALTER TABLE `classe_matiere`
  ADD PRIMARY KEY (`id`),
  ADD KEY `classe_matiere_classe_id_foreign` (`classe_id`),
  ADD KEY `classe_matiere_matiere_id_foreign` (`matiere_id`);

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contenus`
--
ALTER TABLE `contenus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contenus_chapitre_id_foreign` (`chapitre_id`);

--
-- Index pour la table `corrections`
--
ALTER TABLE `corrections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `corrections_epreuve_id_unique` (`epreuve_id`);

--
-- Index pour la table `epreuves`
--
ALTER TABLE `epreuves`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `epreuves_slug_unique` (`slug`),
  ADD KEY `epreuves_classe_id_matiere_id_type_epreuve_id_index` (`type_epreuve_id`);

--
-- Index pour la table `epreuve_classe`
--
ALTER TABLE `epreuve_classe`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `epreuve_classe_epreuve_id_classe_id_unique` (`epreuve_id`,`classe_id`),
  ADD KEY `epreuve_classe_classe_id_foreign` (`classe_id`);

--
-- Index pour la table `epreuve_matiere`
--
ALTER TABLE `epreuve_matiere`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `epreuve_matiere_epreuve_id_matiere_id_unique` (`epreuve_id`,`matiere_id`),
  ADD KEY `epreuve_matiere_matiere_id_foreign` (`matiere_id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `matieres`
--
ALTER TABLE `matieres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matieres_code_unique` (`code`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_matiere_id_foreign` (`matiere_id`),
  ADD KEY `questions_user_id_foreign` (`user_id`),
  ADD KEY `questions_statut_created_at_index` (`statut`,`created_at`),
  ADD KEY `questions_classe_id_matiere_id_index` (`classe_id`,`matiere_id`);

--
-- Index pour la table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quizzes_matiere_id_foreign` (`matiere_id`),
  ADD KEY `quizzes_chapitre_id_foreign` (`chapitre_id`),
  ADD KEY `quizzes_created_by_foreign` (`created_by`),
  ADD KEY `quizzes_classe_id_matiere_id_index` (`classe_id`,`matiere_id`),
  ADD KEY `quizzes_statut_index` (`statut`);

--
-- Index pour la table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_questions_quiz_id_ordre_index` (`quiz_id`,`ordre`);

--
-- Index pour la table `quiz_resultats`
--
ALTER TABLE `quiz_resultats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_resultats_user_id_foreign` (`user_id`),
  ADD KEY `quiz_resultats_quiz_id_user_id_index` (`quiz_id`,`user_id`);

--
-- Index pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reponses_question_id_foreign` (`question_id`),
  ADD KEY `reponses_user_id_foreign` (`user_id`),
  ADD KEY `reponses_statut_question_id_index` (`statut`,`question_id`);

--
-- Index pour la table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `type_epreuves`
--
ALTER TABLE `type_epreuves`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_epreuves_nom_unique` (`nom`),
  ADD UNIQUE KEY `type_epreuves_slug_unique` (`slug`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_details_user_id_unique` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `chapitres`
--
ALTER TABLE `chapitres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `classe_matiere`
--
ALTER TABLE `classe_matiere`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `contenus`
--
ALTER TABLE `contenus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `corrections`
--
ALTER TABLE `corrections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `epreuves`
--
ALTER TABLE `epreuves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `epreuve_classe`
--
ALTER TABLE `epreuve_classe`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `epreuve_matiere`
--
ALTER TABLE `epreuve_matiere`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `matieres`
--
ALTER TABLE `matieres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `quiz_resultats`
--
ALTER TABLE `quiz_resultats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reponses`
--
ALTER TABLE `reponses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_epreuves`
--
ALTER TABLE `type_epreuves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chapitres`
--
ALTER TABLE `chapitres`
  ADD CONSTRAINT `chapitres_classe_id_foreign` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chapitres_matiere_id_foreign` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `classe_matiere`
--
ALTER TABLE `classe_matiere`
  ADD CONSTRAINT `classe_matiere_classe_id_foreign` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `classe_matiere_matiere_id_foreign` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `contenus`
--
ALTER TABLE `contenus`
  ADD CONSTRAINT `contenus_chapitre_id_foreign` FOREIGN KEY (`chapitre_id`) REFERENCES `chapitres` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `corrections`
--
ALTER TABLE `corrections`
  ADD CONSTRAINT `corrections_epreuve_id_foreign` FOREIGN KEY (`epreuve_id`) REFERENCES `epreuves` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `epreuves`
--
ALTER TABLE `epreuves`
  ADD CONSTRAINT `epreuves_type_epreuve_id_foreign` FOREIGN KEY (`type_epreuve_id`) REFERENCES `type_epreuves` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `epreuve_classe`
--
ALTER TABLE `epreuve_classe`
  ADD CONSTRAINT `epreuve_classe_classe_id_foreign` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `epreuve_classe_epreuve_id_foreign` FOREIGN KEY (`epreuve_id`) REFERENCES `epreuves` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `epreuve_matiere`
--
ALTER TABLE `epreuve_matiere`
  ADD CONSTRAINT `epreuve_matiere_epreuve_id_foreign` FOREIGN KEY (`epreuve_id`) REFERENCES `epreuves` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `epreuve_matiere_matiere_id_foreign` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_classe_id_foreign` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `questions_matiere_id_foreign` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `questions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_chapitre_id_foreign` FOREIGN KEY (`chapitre_id`) REFERENCES `chapitres` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `quizzes_classe_id_foreign` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quizzes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `quizzes_matiere_id_foreign` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `quiz_resultats`
--
ALTER TABLE `quiz_resultats`
  ADD CONSTRAINT `quiz_resultats_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_resultats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD CONSTRAINT `reponses_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reponses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
