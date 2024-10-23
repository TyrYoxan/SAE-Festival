<?php

namespace festival\application\providers\auth;

use PhpParser\Token;
use festival\core\dto\AuthDTO;
use festival\core\dto\CredentialsDTO;

interface AuthnProviderInterface{
    public function register(CredentialsDTO $credentials, int $role): void;
    public function signin(CredentialsDTO $credentials): AuthDTO;
    public function refresh(Token $token): AuthDTO;

    public function getSignedInUser(Token $token): AuthDTO;
}