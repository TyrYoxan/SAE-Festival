<?php

namespace festival\infrastructure\repositories;

use festival\core\domain\entities\Panier\Panier;
use festival\core\ReposotiryInterfaces\PanierRepositoryInterface;
use PDO;

class PDOPanier implements PanierRepositoryInterface{
    private PDO $db;

    public function __construct(PDO $pdo){
        $this->db = $pdo;
    }

    public function getPanier(string $id): array{
        try {
            $stmt = $this->db->prepare('SELECT * FROM Panier 
                                            INNER JOIN Panier_Soiree ON Panier_Soiree.id_panier = Panier.id_panier 
                                            WHERE id_utilisateur = :id;');
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $paniers = [];
            $r = [];
            foreach ($rows as $row){
                $r[] = $row['id_soiree'];
            }
            $panier = new Panier($row['id_utilisateur'], $r, $row['etat']);
            $panier->setId($row['id_panier']);
            $paniers[] = $panier;
            return $paniers;
        }catch (\PDOException $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function ajouterBilletAuPanier(string $id_panier, int $id_soiree, int $quantite): void
    {
        try {
            $stmt = $this->db->prepare('INSERT INTO Panier_Soiree (id_panier, id_soiree, quantite) VALUES (:id_panier, :id_soiree, :quantite)');
            $stmt->bindValue(':id_panier', $id_panier);
            $stmt->bindValue(':id_soiree', $id_soiree);
            $stmt->bindValue(':quantite', $quantite);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());

        }
    }
}