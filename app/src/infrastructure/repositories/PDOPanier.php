<?php

namespace festival\infrastructure\repositories;

use festival\core\domain\entities\Panier\Panier;
use festival\core\domain\entities\Soiree\Soiree;
use festival\core\domain\entities\Spectacle\Spectacle;
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
                                            INNER JOIN  Soiree ON Soiree.id_soiree = Panier_Soiree.id_soiree
                                            INNER JOIN Lieu ON Soiree.id_lieu = Lieu.id_lieu
                                            INNER JOIN Tarif ON Soiree.id_soiree = Tarif.id_soiree
                                            INNER JOIN Thematique ON Soiree.thematique = Thematique.id_thematique
                                            WHERE id_utilisateur = :id;');
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


            $paniers = [];
            $r = [];
            foreach ($rows as $row){
                if($row['categorie_tarif'] === 'normal'){
                    $tarifs[] = $row['tarif_normal'];
                }else{
                    $tarifs[] = $row['tarif_reduit'];
                }
                $soiree = new Soiree($row['nom_soiree'], $row['nom_thematique'], $row['date'], $row['horaire_debut'], $row['nom_lieu'],[], $tarifs);
                $soiree->setId($row['id_soiree']);
                $r[] = $soiree;
                $tarifs = [];
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