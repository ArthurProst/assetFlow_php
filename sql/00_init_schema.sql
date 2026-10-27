CREATE DATABASE IF NOT EXISTS `assetflow_db`
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE `assetflow_db`;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `maintenance_logs`;
DROP TABLE IF EXISTS `assignments`;
DROP TABLE IF EXISTS `assets`;
DROP TABLE IF EXISTS `users`;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `matricule` VARCHAR(20) NOT NULL UNIQUE,
  `nom` VARCHAR(100) NOT NULL,
  `prenom` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `role` ENUM('admin', 'technicien', 'collaborateur') NOT NULL DEFAULT 'collaborateur',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `assets` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `code_inventaire` VARCHAR(50) NOT NULL UNIQUE,
  `designation` VARCHAR(150) NOT NULL,
  `type` ENUM('laptop', 'ecran', 'smartphone', 'accessoire') NOT NULL,
  `statut` ENUM('disponible', 'attribue', 'maintenance', 'rebut') NOT NULL DEFAULT 'disponible',
  `valeur_achat` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `date_achat` DATE NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `assignments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `asset_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `date_debut` DATE NOT NULL,
  `date_fin_prevue` DATE NOT NULL,
  `date_restitution` DATE NULL DEFAULT NULL,
  `etat_restitution` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_assignments_asset` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_assignments_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `maintenance_logs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `asset_id` INT NOT NULL,
  `date_declaration` DATE NOT NULL,
  `type_panne` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `cout_reparation` DECIMAL(10,2) NULL DEFAULT NULL,
  `statut_ticket` ENUM('ouvert', 'en_cours', 'resolu') NOT NULL DEFAULT 'ouvert',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_maintenance_asset` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Fixtures Users
INSERT INTO `users` (`id`, `matricule`, `nom`, `prenom`, `email`, `role`) VALUES
(1, 'USR-001', 'Dupont', 'Jean', 'jean.dupont@assetflow.local', 'admin'),
(2, 'USR-002', 'Martin', 'Sophie', 'sophie.martin@assetflow.local', 'technicien'),
(3, 'USR-003', 'Bernard', 'Lucas', 'lucas.bernard@assetflow.local', 'technicien'),
(4, 'USR-004', 'Leroy', 'Camille', 'camille.leroy@assetflow.local', 'collaborateur'),
(5, 'USR-005', 'Petit', 'Thomas', 'thomas.petit@assetflow.local', 'collaborateur');

-- Fixtures Assets (Codes normés regex AST-[0-9]{5})
INSERT INTO `assets` (`id`, `code_inventaire`, `designation`, `type`, `statut`, `valeur_achat`, `date_achat`) VALUES
(1, 'AST-00001', 'Dell XPS 15 (i7, 32 Go RAM, 1 To SSD)', 'laptop', 'attribue', 1850.00, '2025-01-15'),
(2, 'AST-00002', 'Apple MacBook Pro 14" M3 (18 Go, 512 Go)', 'laptop', 'attribue', 2200.00, '2025-02-10'),
(3, 'AST-00003', 'Lenovo ThinkPad T14 Gen 4 (Ryzen 7, 16 Go)', 'laptop', 'disponible', 1350.00, '2025-09-01'),
(4, 'AST-00004', 'Dell UltraSharp U2723QE 27" 4K USB-C Hub', 'ecran', 'attribue', 420.00, '2025-11-20'),
(5, 'AST-00005', 'Iiyama ProLite XUB2492HSU 24" Full HD', 'ecran', 'disponible', 160.00, '2026-03-05'),
(6, 'AST-00006', 'Samsung Galaxy S23 Entreprise 128 Go', 'smartphone', 'maintenance', 850.00, '2025-06-12'),
(7, 'AST-00007', 'Station d accueil Thunderbolt 4 CalDigit TS4', 'accessoire', 'disponible', 230.00, '2026-01-20'),
(8, 'AST-00008', 'HP EliteBook 840 G5 (i5 8e gen, 8 Go)', 'laptop', 'rebut', 1100.00, '2022-04-10');

-- Fixtures Assignments (1 prêt normal, 1 prêt en retard critique, 1 prêt clôturé)
INSERT INTO `assignments` (`id`, `asset_id`, `user_id`, `date_debut`, `date_fin_prevue`, `date_restitution`, `etat_restitution`) VALUES
(1, 1, 4, '2026-09-01', '2026-12-31', NULL, NULL),
(2, 2, 5, '2026-09-15', '2026-10-15', NULL, NULL),
(3, 4, 4, '2026-08-01', '2026-09-30', '2026-09-28', 'Matériel rendu complet avec câbles, état impeccable.');

-- Fixtures Maintenance
INSERT INTO `maintenance_logs` (`id`, `asset_id`, `date_declaration`, `type_panne`, `description`, `cout_reparation`, `statut_ticket`) VALUES
(1, 6, '2026-10-10', 'Casse écran / Chute', 'Dalle tactile fissurée suite à une chute en déplacement professionnel. Devis réparateur agréé validé.', 180.00, 'en_cours'),
(2, 8, '2026-02-10', 'Carte mère HS', 'Court-circuit interne au démarrage. Appareil amorti, non rentable à réparer -> Déclassé au rebut.', 0.00, 'resolu');