<?php

namespace festival\core\Dto;

use festival\core\domain\entities\Theme\Theme;
use festival\core\Dto\Dto;

class DtoTheme extends Dto implements \JsonSerializable{

    protected string $id;
    protected string $name;

    public function __construct(Theme $theme){
        $this->id = $theme->getId();
        $this->name = $theme->getName();
    }

    public function jsonSerialize(): array{
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}