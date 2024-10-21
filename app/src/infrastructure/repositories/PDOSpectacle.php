<?php

use toubeelib\core\ReposotiryInterfaces\SpectacleRepositoryInterface;

class PDOSpectacle implements SpectacleRepositoryInterface{

    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    public function getSpectacles(): array{
        $stmt = $this->pdo->query('SELECT * FROM spectacles');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}