<?php

namespace festival\core\domain\entities\Theme;

use festival\core\domain\Entity\Entity;
use festival\core\Dto\DtoTheme;

class Theme extends Entity{

    protected string $name;

    public function __construct(string $name){
        $this->name = $name;
    }

    public function getName(): string{
        return $this->name;
    }

    public function toDTO(): DtoTheme{
        return new DtoTheme($this);
    }
}