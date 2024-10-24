<?php

namespace festival\core\services\Utilisateur;

use festival\core\domain\entities\Utilisateur\Utilisateur;
use festival\core\Dto\DtoUtilisateur;

interface serviceUtilisateurInterface{

    public function createUser(string $nom, string $email, string $password): void;

    public function getUserByEmail(string $email): DtoUtilisateur;

    public function getBilletsByUser(string $userId): array;
}