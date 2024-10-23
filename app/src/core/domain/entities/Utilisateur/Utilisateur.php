<?php
namespace festival\core\domain\entities\Utilisateur;

use festival\core\domain\entity\Entity;

class Utilisateur extends Entity{
    private string $nom;
    private string $email;
    private string $password;

    public function __construct(string $nom, string $email, string $password){
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