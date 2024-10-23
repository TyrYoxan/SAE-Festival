<?php

namespace festival\infrastructure\repositories;

use festival\core\domain\entities\Utilisateur\Utilisateur;
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

    public function getUserByEmail(string $email): Utilisateur{
        $stmt = $this->db->prepare('SELECT * FROM Utilisateur WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $row = $stmt->fetch();
        $user = new Utilisateur($row['nom'], $row['email'], $row['mot_de_passe'], $row['role']);
        $user->setId($row['uuid']);
        return $user;
    }
}