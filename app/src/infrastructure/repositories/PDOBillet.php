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

    public function creerBillet(int $soireeId, int $quantite, string $tarif, string $id_utilisateur): void{
        $stmt = $this->pdo->prepare('INSERT INTO Billet (id_utilisateur, id_soiree, categorie_tarif, quantite, date_achat) VALUES (:id_user, :id_soiree, :categorie_tarif, :quantite, NOW())');
        $stmt->bindValue(':id_soiree', $soireeId);
        $stmt->bindValue(':id_user', $id_utilisateur);
        $stmt->bindValue(':categorie_tarif', $tarif);
        $stmt->bindValue(':quantite', $quantite);
        $stmt->execute();
    }
}
