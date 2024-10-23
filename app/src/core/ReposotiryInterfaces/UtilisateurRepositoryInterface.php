<?php

namespace festival\core\ReposotiryInterfaces;

use festival\core\domain\entities\Utilisateur\Utilisateur;

interface UtilisateurRepositoryInterface{

    public function creatUser(Utilisateur $utilisateur): void;
    public function getUserByEmail(string $email): Utilisateur;

    public function getBilletsByUser(string $userId): array;

}