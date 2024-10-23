<?php
namespace festival\core\domain\entities\Artiste;

use festival\core\domain\Entity\Entity;

class Artiste extends Entity
{
    private string $name;


    public function __construct(string $name)
    {
        $this->name = $name;

    }

    public function getName(): string
    {
        return $this->name;
    }
}