<?php

namespace festival\core\Dto;

use festival\core\Dto\Dto;

class DtoCredentials extends DTO{

    public string $email;
    public string $password;

    public function __construct(string $email, string $password){
        $this->email = $email;
        $this->password = $password;
    }
}