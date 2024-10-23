<?php

namespace festival\core\services\Utilisateur;

use festival\core\domain\entities\Utilisateur\Utilisateur;
use festival\core\Dto\DtoUtilisateur;
use festival\core\ReposotiryInterfaces\UtilisateurRepositoryInterface;
use PDO;

class serviceUtilisateur implements serviceUtilisateurInterface{
    protected UtilisateurRepositoryInterface $utilisateurRepository;
    public function __construct(UtilisateurRepositoryInterface $utilisateurRepository){
        $this->utilisateurRepository = $utilisateurRepository;
    }

    public function createUser(string $nom, string $email, string $password): void{
        try {
            $utilisateur = new Utilisateur($nom, $email, $password);
            $this->utilisateurRepository->creatUser($utilisateur);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function getUserByEmail(string $email): DtoUtilisateur{
        $user = $this->utilisateurRepository->getUserByEmail($email);
        if (!$user) {
            throw new \Exception('User not found');
        }

        return $user->toDTO();
    }
}