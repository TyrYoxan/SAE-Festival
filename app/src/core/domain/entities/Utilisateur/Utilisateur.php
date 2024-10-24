<?php
namespace festival\core\domain\entities\Utilisateur;

use festival\core\domain\Entity\Entity;
use festival\core\Dto\DtoUtilisateur;

class Utilisateur extends Entity{
    private string $nom;
    private string $email;
    private string $password;

    private int $role;

    public function __construct(string $nom, string $email, string $password, int $role = 10){
        $this->nom = $nom;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }

    public function toDTO(): DtoUtilisateur{
        return new DtoUtilisateur($this);
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

    public function getRole(): int{
        return $this->role;
    }
}