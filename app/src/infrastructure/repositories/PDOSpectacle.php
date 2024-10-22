<?php

namespace festival\infrastructure\repositories;

use festival\core\ReposotiryInterfaces\SpectacleRepositoryInterface;
use PDO;

class PDOSpectacle implements SpectacleRepositoryInterface{

    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }
    public function getSpectacles(): array{
        $stmt = $this->pdo->query('SELECT Spectacle.*, Artiste.nom FROM Spectacle INNER JOIN Spectacle_Artiste ON Spectacle.id_spectacle = Spectacle_Artiste.id_spectacle INNER JOIN Artiste ON Spectacle_Artiste.id_artiste = Artiste.id_artiste;');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}