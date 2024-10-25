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
        $stmt = $this->pdo->prepare('SELECT * 
                                            FROM Soiree 
                                            INNER JOIN Tarif ON Soiree.id_soiree = Tarif.id_soiree 
                                            INNER JOIN Lieu ON Lieu.id_lieu = Soiree.id_lieu 
                                            INNER JOIN Thematique ON Thematique.id_thematique = Soiree.thematique
                                            WHERE Soiree.id_soiree = :id;');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt2 = $this->pdo->prepare('SELECT Spectacle.*,  GROUP_CONCAT(Artiste.nom_artiste SEPARATOR \', \') AS artistes 
                                            FROM Spectacle INNER JOIN Spectacle_Artiste ON Spectacle.id_spectacle = Spectacle_Artiste.id_spectacle 
                                            INNER JOIN Artiste ON Artiste.id_artiste = Spectacle_Artiste.id_artiste 
                                            WHERE Spectacle.id_soiree = :id 
                                            GROUP BY Spectacle.id_spectacle;');
        $stmt2->bindParam(':id', $id);
        $stmt2->execute();
        $row2 = $stmt2->fetchAll();


        $spectacles = [];
        $artistes = [];
        foreach ($row2 as $r){
            $artistes[] = $r['artistes'];
            $spectacle = new Spectacle($r['titre'],$artistes, $r['description'], $r['images'],$r['url_video'], $r['horaire_previsionnel'] );
            $spectacle->setId($r['id_spectacle']);
            $spectacles[] = $spectacle;
            $artistes = [];
        }

        $tarifs = [];
        $soirees = [];
        foreach ($row as $r){
            $tarifs[] = $r['tarif_normal'];
            $tarifs[] = $r['tarif_reduit'];
            $soiree = new Soiree($r['nom_soiree'], $r['nom_thematique'],  $r['date'], $r['horaire_debut'],null, $r['nom_lieu'],$spectacles, $tarifs);
            $soiree->setId($r['id_soiree']);
            $soirees[] = $soiree;
        }

        return $soirees;
    }

    public function getPlacesVendues(string $soireeId) : int{
        $stmt = $this->pdo->prepare('SELECT SUM(quantite) as places_vendues FROM Billet WHERE id_soiree = :soireeId');
        $stmt->bindParam(':soireeId', $soireeId);
        $stmt->execute();
        $row = $stmt->fetch();
        if($row['places_vendues'] === null){
            return 0;
        }
        return $row['places_vendues'];
    }

    public function getPlacesDisponibles(string $soireeId) : int{
        $stmt = $this->pdo->prepare("SELECT SUM(places_assises + places_debout) as places_disponibles 
                                            FROM Lieu 
                                            WHERE id_lieu IN (SELECT id_lieu 
                                                              FROM Soiree 
                                                              WHERE id_soiree = :soireeId)");
        $stmt->bindParam(':soireeId', $soireeId);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['places_disponibles'] - $this->getPlacesVendues($soireeId);
    }

    public function verfierPlace(array $id_soiree): bool{
        foreach ($id_soiree as $s){
            if($this->getPlacesDisponibles($s) === 0){
                return false;
            }
        }
        return true;
    }
}