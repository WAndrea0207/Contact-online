<?php

class DBConnect
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            'mysql:host=localhost;dbname=contact_online;charset=utf8mb4',
            'willa',
            '020798',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}
