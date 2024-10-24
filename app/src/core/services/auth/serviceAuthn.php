<?php

namespace festival\core\services\auth;

use festival\core\domain\entities\Utilisateur\Utilisateur;
use festival\core\Dto\DtoAuth;
use festival\core\Dto\DtoCredentials;
use festival\core\ReposotiryInterfaces\UtilisateurRepositoryInterface;

class serviceAuthn implements serviceAuthnInterface{
    private UtilisateurRepositoryInterface $utilisateurRepository;

    public function __construct(UtilisateurRepositoryInterface $utilisateurRepository){
        $this->utilisateurRepository = $utilisateurRepository;
    }

    public function byCredentials(DtoCredentials $credentials): ?DtoAuth{
        return $this->utilisateurRepository->getUserByEmail($credentials);
    }
}