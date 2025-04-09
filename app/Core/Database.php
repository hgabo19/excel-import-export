<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    protected PDO $pdo;

    public function __construct(array $config, string $username = 'root', string $password = '') {
        $dsn = 'mysql:' . http_build_query($config, '', ';');

        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Hiba az adatbázis kapcsolatban: " . $e->getMessage());
        }
    }

    /**
     * Visszaad egy PDO objektumot
     *
     * @return PDO
     */
    public function getConnection(): PDO {
        return $this->pdo;
    }
}