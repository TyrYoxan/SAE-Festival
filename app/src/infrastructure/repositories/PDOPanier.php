<?php

namespace festival\infrastructure\repositories;

use Ramsey\Uuid\Uuid;
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
                $soiree = new Soiree($row['nom_soiree'], $row['nom_thematique'], $row['date'], $row['horaire_debut'], $row['quantite'] ,$row['nom_lieu'],[], $tarifs);
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

    public function ajouterBilletAuPanier(string $id_user, int $id_soiree, string $quantite, string $tarif): void
    {
        try {
            $id_panier = UUID::uuid4()->toString();
            $stmt2 = $this->db->prepare('INSERT INTO Panier (id_panier, id_utilisateur) VALUES (:id_panier, :id_user)');
            $stmt2->bindValue(':id_panier', $id_panier);
            $stmt2->bindValue(':id_user', $id_user);
            $stmt2->execute();

        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());

        }

        try {

            $stmt = $this->db->prepare('INSERT INTO Panier_Soiree (id_panier, id_soiree, quantite, categorie_tarif) VALUES (:id_panier, :id_soiree, :quantite, :id_tarif)');
            $stmt->bindValue(':id_panier', $id_panier);
            $stmt->bindValue(':id_soiree', (int) $id_soiree);
            $stmt->bindValue(':quantite', (int) $quantite);
            if($tarif === '0'){
                $stmt->bindValue(':id_tarif', 'normal');
            }else{
                $stmt->bindValue(':id_tarif', 'reduit');
            }

            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function validatePanier(string $id): void{
        try {
            $stmt = $this->db->prepare('UPDATE Panier SET etat = :etat WHERE id_utilisateur = :id;');
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':etat', 'valider');
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}