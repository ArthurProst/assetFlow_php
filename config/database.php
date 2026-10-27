<?php
declare(strict_types=1);

namespace App\Config;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
    private static ?PDO $instance = null;
    private static ?string $lastError = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new RuntimeException("La désérialisation d'un singleton n'est pas autorisée.");
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                DB_HOST,
                DB_PORT,
                DB_NAME,
                DB_CHARSET
            );

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => 5,
            ];

            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
                self::$lastError = null;
            } catch (PDOException $e) {
                self::$lastError = $e->getMessage();
                throw $e;
            }
        }

        return self::$instance;
    }

    public static function isConnected(): bool
    {
        try {
            self::getInstance();
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    public static function getLastError(): ?string
    {
        return self::$lastError;
    }
}
