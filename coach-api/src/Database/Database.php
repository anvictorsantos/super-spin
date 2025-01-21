<?php

namespace Database;

use Dotenv\Dotenv;
use PDO;
use PDOException;
use RuntimeException;

class Database
{
    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../'); // Adjust path if necessary
        $dotenv->load();
    }

    public function getConnection(): PDO
    {
        try {
            // Load database configuration from environment variables
            $host = $_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT'];
            $name = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];

            // Build the DSN (Data Source Name)
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                $host,
                $name
            );

            // Create and return the PDO instance
            return new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
                PDO::ATTR_EMULATE_PREPARES => false,         // Use real prepared statements
                PDO::ATTR_STRINGIFY_FETCHES => false         // Keep native data types
            ]);
        } catch (PDOException $e) {
            // Wrap the PDOException in a RuntimeException
            throw new RuntimeException(
                'Failed to connect to the database: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
