<?php

namespace festival\application\providers\auth;

use festival\core\Dto\DtoAuth;
use festival\core\Dto\DtoCredentials;
use PhpParser\Token;


interface AuthnProviderInterface{
    //public function register(DtoCredentials $credentials, int $role): void;
    public function signin(DtoCredentials $credentials): DtoAuth;
    public function refresh(Token $token): DtoAuth;

    static function getSignedInUser(string $token): DtoAuth;
}