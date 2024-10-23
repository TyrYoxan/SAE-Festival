<?php

namespace festival\core\ReposotiryInterfaces;

use festival\core\domain\entities\Utilisateur\Utilisateur;
use festival\core\Dto\DtoAuth;
use festival\core\Dto\DtoCredentials;

interface UtilisateurRepositoryInterface{

    public function creatUser(Utilisateur $utilisateur): void;
    public function getUserByEmail(DtoCredentials $credentials): ?DtoAuth;

    public function getBilletsByUser(string $userId): array;

}