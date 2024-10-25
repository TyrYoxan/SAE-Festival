<?php

namespace festival\core\Dto;

use festival\core\Dto\Dto;

class DtoAuth extends Dto{

    protected string $nom;
    protected string $email;
    protected string $id;
    protected string $role;
    protected ?string $atoken;
    protected ?string $rtoken;

    public function __construct(string $nom, string $email, string $id, string $role){
        $this->nom = $nom;
        $this->email = $email;
        $this->id = $id;
        $this->role = $role;
    }

    public function addToken(string $atoken, string $rtoken): DtoAuth{
        $this->atoken = $atoken;
        $this->rtoken = $rtoken;
        return $this;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getId(): string {
        return $this->id;
    }

    public function getRole(): string {
        return $this->role;
    }

    public function getAtoken(): ?string {
        return $this->atoken;
    }

    public function getRtoken(): ?string {
        return $this->rtoken;
    }

    public function isAdmin(): bool{
        return $this->role === '100';
    }
}