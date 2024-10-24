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

    public function getSpectaclesByFilter(?string $type, ?string $date, ?string $lieu){
        try{
            $query ='SELECT Spectacle.*, GROUP_CONCAT(Artiste.nom_artiste SEPARATOR \', \') AS artistes, Soiree.date FROM Spectacle INNER JOIN Spectacle_Artiste ON Spectacle.id_spectacle = Spectacle_Artiste.id_spectacle INNER JOIN Artiste ON Spectacle_Artiste.id_artiste = Artiste.id_artiste INNER JOIN Soiree ON Spectacle.id_soiree = Soiree.id_soiree WHERE 1=1';
            // Tableau pour les paramètres
            $params = [];

            // Ajouter des conditions dynamiques
            if ($type !== 0) {
                $query .= ' AND Soiree.thematique = :type';
                $params[':type'] = $type;
            }

            if ($date !== null) {
                $query .= ' AND Soiree.date = :date';
                $params[':date'] = $date;
            }

            if ($lieu !== null) {
                $query .= ' AND Soiree.nom_lieu = :lieu';
                $params[':lieu'] = $lieu;
            }

            $query .= ' GROUP BY Spectacle.id_spectacle;';

            // Préparer la requête
            $stmt = $this->pdo->prepare($query);

            // Lier les paramètres
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (\PDOException $e){
            throw new \Exception($e->getMessage());
        }
    }
}