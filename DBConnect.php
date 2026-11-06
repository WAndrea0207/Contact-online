<?php

// Ouvre une seule connexion PDO à la base, réutilisée partout.
class DBConnect
{
    private PDO $pdo;

    public function __construct()
    {
        $config = require __DIR__ . '/config.php';

        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';charset=utf8mb4';
        $this->pdo = new PDO($dsn, $config['user'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}
