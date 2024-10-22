<?php

namespace festival\infrastructure\repositories;

use DateTime;
use festival\core\domain\entities\Soiree\Soiree;
use festival\core\domain\entities\Spectacle\Spectacle;
use festival\core\ReposotiryInterfaces\SoireeRepositoryInterface;
use PDO;

class PDOSoiree implements SoireeRepositoryInterface{
    private PDO $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function getSpectacles(string $id): array{
        $stmt = $this->pdo->prepare('SELECT * FROM Soiree  WHERE Soiree.id_soiree = :id;');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt2 = $this->pdo->prepare('SELECT * FROM Spectacle WHERE Spectacle.id_soiree = :id;');
        $stmt2->bindParam(':id', $id);
        $stmt2->execute();
        $row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);


        $spectacles = [];
        foreach ($row2 as $r){
            $spectacle = new Spectacle($r['titre'],'toto', $r['description'], $r['images'],$r['url_video'], DateTime::createFromFormat('H:i:s', $r['horaire_previsionnel'] ));
            $spectacle->setId($r['id_spectacle']);
            $spectacles[] = $spectacle;
        }

        $soirees = [];
        foreach ($row as $r){
            $soiree = new Soiree($r['nom'], $r['thematique'], DateTime::createFromFormat('Y-m-d', $r['date']), DateTime::createFromFormat('H:i:s',$r['horaire_debut']), $r['id_lieu'],$spectacles);
            $soiree->setId($r['id_soiree']);
            $soirees[] = $soiree;
        }

        return $soirees;
    }
}