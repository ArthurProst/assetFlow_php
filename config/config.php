<?php
declare(strict_types=1);

// 1. Chargement des surcharges locales en amont (évite le conflit define)
if (file_exists(__DIR__ . '/config.local.php')) {
    require_once __DIR__ . '/config.local.php';
}

// 2. Environnement & Métadonnées
defined('APP_ENV') || define('APP_ENV', getenv('APP_ENV') ?: 'development');
defined('APP_NAME') || define('APP_NAME', 'AssetFlow');
defined('APP_VERSION') || define('APP_VERSION', '1.0.0');

// 3. Résolution dynamique de BASE_URL (compatible CLI, serveur PHP, Wamp, Xampp)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8000';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$baseUrl = rtrim($protocol . $host . ($scriptDir === '/' ? '' : $scriptDir), '/');

defined('BASE_URL') || define('BASE_URL', getenv('APP_URL') ?: $baseUrl);

// 4. Paramètres de connexion BDD (ne s'appliquent que si non définis dans config.local.php)
defined('DB_HOST') || define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
defined('DB_PORT') || define('DB_PORT', (int) (getenv('DB_PORT') ?: 3306));
defined('DB_NAME') || define('DB_NAME', getenv('DB_NAME') ?: 'assetflow_db');
defined('DB_USER') || define('DB_USER', getenv('DB_USER') ?: 'root');
defined('DB_PASS') || define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
defined('DB_CHARSET') || define('DB_CHARSET', 'utf8mb4');

// 5. Helper global d'échappement anti-XSS
if (!function_exists('e')) {
    function e(mixed $value): string
    {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}