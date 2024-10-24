<?php

namespace festival\infrastructure\repositories;

use festival\core\domain\entities\Billet\Billet;
use festival\core\domain\entities\Utilisateur\Utilisateur;
use festival\core\Dto\DtoAuth;
use festival\core\Dto\DtoCredentials;
use festival\core\ReposotiryInterfaces\UtilisateurRepositoryInterface;
use PDO;

class PDOUtilisateur implements UtilisateurRepositoryInterface{
    private PDO $db;

    public function __construct(PDO $pdo){
        $this->db = $pdo;
    }

    public function creatUser(Utilisateur $utilisateur): void{
        try {
            $stmt = $this->db->prepare('INSERT INTO Utilisateur (nom_utilisateur, email, mot_de_passe, uuid) VALUES (:nom, :email, :mot_de_passe, :uuid)');
            $stmt->bindValue(':uuid', uniqid());
            $stmt->bindValue(':nom', $utilisateur->getNom());
            $stmt->bindValue(':email', $utilisateur->getEmail());
            $stmt->bindValue(':mot_de_passe', $utilisateur->getPassword());

            $stmt->execute();
        }catch (\PDOException $e){
            throw new \Exception('Erreur lors de l\'enregistrement de l\'utilisateur: ');
        }
    }

    public function getUserByEmail(DtoCredentials $credentials): ?DtoAuth{
        $stmt = $this->db->prepare('SELECT * FROM Utilisateur WHERE email = :email');
        $stmt->bindParam(':email', $credentials->email);
        $stmt->execute();
        $row = $stmt->fetch();
        if($row && password_verify($credentials->password, $row['mot_de_passe'])) {
            return new DtoAuth($row['nom_utilisateur'], $row['email'],$row['uuid'], $row['role']);
        }

        return null;
    }

    public function getBilletsByUser(string $userId): array {
        $stmt = $this->db->prepare('SELECT * FROM Billet 
                                        INNER JOIN Soiree ON Soiree.id_soiree = Billet.id_soiree 
                                        INNER JOIN Utilisateur ON Utilisateur.uuid = Billet.id_utilisateur
                                        INNER JOIN Lieu ON Soiree.id_lieu = Lieu.id_lieu
                                        WHERE id_utilisateur = :userId');
        $stmt->execute(['userId' => $userId]);
        $billets  = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $billet = [];
        foreach ($billets as $b){
            $ticket = new Billet($b['nom_soiree'], $b['nom_utilisateur'], $b['categorie_tarif'], $b['quantite'],$b['nom_lieu'],$b['date'],$b['horaire_debut'], $b['date_achat']);
            $ticket->setId($b['id_billet']);
            $billet[] = $ticket;
        }
        return $billet;
    }
}