<?php
namespace festival\core\domain\entities\Utilisateur;

use festival\core\domain\entities\Entity;

class Utilisateur extends Entity{
    private string $nom;
    private string $email;
    private string $password;

    public function __construct(string $id, string $nom, string $email, string $password){
        parent::__construct($id);
        $this->nom = $nom;
        $this->email = $email;
        $this->password = $password;
    }

    public function getNom(): string{
        return $this->nom;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getPassword(): string{
        return $this->password;
    }
}