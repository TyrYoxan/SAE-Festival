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
        try{
            $stmt = $this->pdo->query('SELECT Spectacle.*, GROUP_CONCAT(Artiste.nom_artiste SEPARATOR \', \') AS artistes, Soiree.date FROM Spectacle INNER JOIN Spectacle_Artiste ON Spectacle.id_spectacle = Spectacle_Artiste.id_spectacle INNER JOIN Artiste ON Spectacle_Artiste.id_artiste = Artiste.id_artiste INNER JOIN Soiree ON Spectacle.id_soiree = Soiree.id_soiree GROUP BY Spectacle.id_spectacle;');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (\PDOException $e){
            throw new \Exception($e->getMessage());
        }

    }
}