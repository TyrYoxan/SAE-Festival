<?php

namespace festival\core\Dto;

use festival\core\domain\entities\Utilisateur\Utilisateur;
use festival\core\Dto\Dto;

class DtoUtilisateur extends Dto implements \JsonSerializable{

    protected string $id;
    protected string $nom;
    protected string $email;
    protected int $role;


    public function __construct(Utilisateur $utilisateur){
        $this->id = $utilisateur->getId();
        $this->nom = $utilisateur->getNom();
        $this->email = $utilisateur->getEmail();
        $this->role = $utilisateur->getRole();
    }
    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed{
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'email' => $this->email
        ];
    }
}