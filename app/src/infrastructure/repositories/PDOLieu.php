<?php

namespace festival\infrastructure\repositories;

use festival\core\domain\entities\LieuSpectacle\LieuSpectacle;
use festival\core\ReposotiryInterfaces\LieuRepositoryInterface;
use PDO;

class PDOLieu implements LieuRepositoryInterface{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getLieux(): array{
        $stmt = $this->pdo->prepare('SELECT * FROM Lieu;');
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lieux = [];
        foreach ($rows as $row){
            $lieu = new LieuSpectacle($row['nom_lieu'], $row['adresse'], $row['places_assises'], $row['places_debout'], $row['images']);
            $lieu->setId($row['id_lieu']);
            $lieux[] = $lieu;
        }
        return $lieux;
    }
}