<?php

namespace festival\core\services\Utilisateur;

use festival\core\domain\entities\Utilisateur\Utilisateur;
use PDO;

class ServiceUtilisateur
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function createUtilisateur(Utilisateur $utilisateur)
    {
        $stmt = $this->db->prepare('INSERT INTO Utilisateur (nom, email, mot_de_passe) VALUES (:nom, :email, :mot_de_passe)');
        $stmt->bindValue(':nom', $utilisateur->getNom());
        $stmt->bindValue(':email', $utilisateur->getEmail());
        $stmt->bindValue(':mot_de_passe', $utilisateur->getPassword());
        $stmt->execute();
    }
    public function getBilletsByUtilisateur(int $id_utilisateur)
    {
        $stmt = $this->db->prepare('SELECT * FROM Billet WHERE id_utilisateur = :id_utilisateur');
        $stmt->bindValue(':id_utilisateur', $id_utilisateur);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}