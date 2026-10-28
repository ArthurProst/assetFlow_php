# AssetFlow — Gestion de Parc Informatique
> **Atelier de Professionnalisation BTS SIO option SLAM**  
> Socle MVC 3-tiers en **PHP 8 Vanilla** sans framework lourd, modulaire et prêt à l'emploi.

---

## 1. Présentation du projet

**AssetFlow** est une application web d'entreprise dédiée à la gestion d'un parc informatique (ordinateurs portables, écrans, smartphones, accessoires). Elle permet d'assurer le suivi des affectations aux collaborateurs, la gestion du cycle de vie du matériel, le support/maintenance et le pilotage financier des investissements.

Ce projet sert de fil conducteur pour un atelier de professionnalisation **BTS SIO SLAM**, permettant aux étudiants de développer 8 modules métiers tout en appliquant les bonnes pratiques de génie logiciel :
* Architecture MVC / 3-tiers claire et lisible
* Séparation stricte des responsabilités (Contrôleurs, Modèles, Vues)
* Sensibilisation aux vulnérabilités courantes (OWASP Top 10 : Injections SQL, Failles XSS)
* Base de données relationnelle normalisée avec clés étrangères et contraintes d'intégrité

---

## 2. Arborescence du Projet

```text
assetflow/
├── config/
│   ├── config.php          # Constantes globales (BASE_URL, DB_*, helper e())
│   └── database.php        # Connexion Singleton PDO (UTF-8, exceptions, fetch associatif)
├── sql/
│   ├── 00_init_schema.sql  # Schéma SQL (4 tables) + jeux d'essais réalistes
│   └── migrations/         # Guide d'évolution du schéma
│       ├── .gitkeep
│       └── 01_example_add_field.sql.example # Exemple d'ALTER TABLE commenté
├── app/
│   ├── Controllers/
│   │   ├── BaseController.php  # render($view, $data) et redirect($url)
│   │   └── HomeController.php  # Dashboard des 8 modules & vue du parc
│   ├── Models/
│   │   ├── BaseModel.php       # Instance PDO partagée via Singleton
│   │   └── Asset.php           # Modèle avec requêtes préparées PDO (CRUD, KPIs)
│   └── Views/
│       ├── layouts/
│       │   ├── header.php      # En-tête HTML, navigation & Tailwind CDN
│       │   └── footer.php      # Pied de page sobre
│       ├── home/
│       │   └── index.php       # Tableau de bord récapitulatif des 8 modules
│       └── assets/
│           └── index.php       # Consultation du parc avec badges et filtres
├── public/
│   ├── index.php           # Front Controller unique + autoloader PSR-4 natif
│   └── assets/             # Fichiers CSS / JS statiques
├── .gitignore              # Exclusion des configs locales et fichiers sensibles
└── README.md               # Guide d'installation et de démarrage
```

---

## 3. Guide de Démarrage Rapide

### Prérequis
* **PHP 8.1 ou supérieur** avec extensions `pdo` et `pdo_mysql` activées
* **MySQL 8.0+** ou **MariaDB 10.4+** (via XAMPP, WampServer, Laragon ou Docker)

### Étape 1 : Récupérer le projet
```bash
git clone <url-du-depot> assetflow
cd assetflow
```

### Étape 2 : Importer la base de données
Importez le script SQL initial `sql/00_init_schema.sql` dans votre serveur de base de données :

**En ligne de commande :**
```bash
mysql -u root -p < sql/00_init_schema.sql
```
*Ou via l'interface graphique **phpMyAdmin** : Onglet "Importer" > choisir `sql/00_init_schema.sql`.*

Ce script crée la base `assetflow_db`, génère les 4 tables relationnelles et injecte :
* **5 utilisateurs** (admin, techniciens, collaborateurs)
* **8 équipements** avec statuts variés (disponible, attribué, maintenance, rebut)
* **3 affectations** (dont une avec date de fin dépassée pour tester les alertes retards)
* **2 tickets d'intervention** de maintenance

### Étape 3 : Ajuster la configuration (si nécessaire)
Par défaut, `config/config.php` se connecte sur `127.0.0.1:3306`, utilisateur `root`, sans mot de passe.  
Si votre environnement local utilise des identifiants différents (ex: MAMP avec `root`/`root`), créez un fichier `config/config.local.php` :
```php
<?php
// config/config.local.php
define('DB_USER', 'root');
define('DB_PASS', 'root');
```

### Étape 4 : Lancer le serveur local
À la racine du projet `assetflow`, lancez le serveur intégré de PHP :
```bash
php -S localhost:8000 -t public
```
Ouvrez ensuite votre navigateur sur :  
 **[http://localhost:8000](http://localhost:8000)**

---

## 4. Les 8 Modules de l'Atelier SLAM

| Module | Intitulé | Compétence SIO | Objectifs Pédagogiques |
| :---: | :--- | :--- | :--- |
| **1** | **Référencement & Catalogue d'Équipements** | B1.1 - Patrimoine info | Création d'équipements, contrôle de validité serveur (regex `^AST-[0-9]{5}$`, valeurs positives) et fiche détaillée. |
| **2** | **Recherche Multi-Critères & Consultation** | B1.1 - Patrimoine info | Moteur de recherche filtré (catégories, statuts, recherche plein texte), tri par date et badges visuels. |
| **3** | **Affectations & Sorties de Matériel** | B1.2 - Besoins usagers | Attribution aux collaborateurs, vérification bloquante de disponibilité et bascule atomique du statut du matériel. |
| **4** | **Restitutions & Diagnostic de Retour** | B1.4 - Support usagers | Clôture d'emprunt, qualification de l'état physique du matériel et réintégration automatique (disponible ou maintenance). |
| **5** | **Maintenance, SAV & Suivi des Pannes** | B1.4 - Support usagers | Signalement d'incidents techniques, suivi du workflow de réparation et consolidation des coûts de maintenance. |
| **6** | **Tableau de Bord DSI, Audit & Alertes** | B2.1 - Conception solution | Calcul d'indicateurs de synthèse (taux d'occupation, coût total), détection des dérives et export d'audit (CSV/JSON). |
| **7** | **Alertes de Retard & Supervision** | B2.2 - Traitement données | Détection automatisée des affectations échues, calcul du retard effectif et traçabilité de l'historique des relances. |
| **8** | **Gestion des Profils & Droits Collaborateurs**| B1.3 - Habilitations | Annuaire des utilisateurs, gestion du cycle de vie des comptes (actif/inactif) et matrice des droits d'accès aux modules. |

---

## 5. Gestion des Évolutions de Schéma (Migrations)

Lors du travail en équipe ou lors du passage d'un module à l'autre, vous serez amenés à modifier la structure de la base de données.
Consultez le dossier `sql/migrations/` et étudiez le fichier d'exemple :  
`sql/migrations/01_example_add_field.sql.example`

Pour appliquer une évolution sans réinitialiser la base :
```bash
mysql -u root -p assetflow_db < sql/migrations/01_example_add_field.sql
```

---

## Licence & Paternité
Support pédagogique conçu pour les ateliers de professionnalisation **BTS SIO (Services Informatiques aux Organisations) - Option SLAM (Solutions Logicielles et Applications Métiers)**. Libre d'usage et d'adaptation pédagogique.
