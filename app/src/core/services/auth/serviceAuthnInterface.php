<?php

namespace festival\core\services\auth;

use festival\core\Dto\DtoAuth;
use festival\core\Dto\DtoCredentials;

interface serviceAuthnInterface{

    //public function createUser(CredentialsDTO $credentials, int $role):UUID;
    public function byCredentials(DtoCredentials $credentials): ?DtoAuth;
}