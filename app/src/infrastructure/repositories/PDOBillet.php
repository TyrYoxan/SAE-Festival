<?php
namespace festival\infrastructure\repositories;

use festival\core\domain\entities\Billet\Billet;
use festival\core\ReposotiryInterfaces\BilletRepositoryInterface;
use PDO;

class PDOBillet implements BilletRepositoryInterface{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getBillets(): array{
        $stmt = $this->pdo->prepare('SELECT * FROM Billet;');
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $billets = [];
        foreach ($rows as $row){
            $billet = new Billet($row['id_soiree'], $row['id_utilisateur'], $row['categorie_tarif'], $row['quantite'], $row['date_achat']);
            $billet->setId($row['id_billet']);
            $billets[] = $billet;
        }
        return $billets;
    }
    /*TODO A Verifier */
    public function creerBillet(int $soireeId, int $quantite, int $tarif ){
        $stmt = $this->pdo->prepare('INSERT INTO Billet (id_soiree, categorie_tarif, quantite) VALUES (:id_soiree, :categorie_tarif, :quantite)');
        $stmt->bindValue(':id_soiree', $soireeId);
        $stmt->bindValue(':categorie_tarif', $tarif);
        $stmt->bindValue(':quantite', $quantite);
        $stmt->execute();
    }
}
