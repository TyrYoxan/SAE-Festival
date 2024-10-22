<?php

namespace festival\infrastructure\repositories;

use festival\core\ReposotiryInterfaces\SoireeRepositoryInterface;
use PDO;

class PDOSoiree implements SoireeRepositoryInterface{
    private PDO $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function getSpectacles(string $id): array{
        $stmt = $this->pdo->prepare('SELECT Soiree.*, Spectacle.id_spectacle FROM Soiree INNER JOIN Spectacle ON Soiree.id_soiree = Spectacle.id_soiree WHERE Soiree.id_soiree = :id;');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}