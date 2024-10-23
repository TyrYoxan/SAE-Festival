<?php

namespace festival\core\services\authorization;

use festival\core\Dto\DtoAuth;

class ServiceAuthz {
    public function authRead(DtoAuth $auth): bool{
        if($auth->role === 10){
            return true;
        }
        return false;
    }

}