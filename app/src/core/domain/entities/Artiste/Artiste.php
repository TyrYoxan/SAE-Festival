<?php
namespace festival\core\services\spectacles;

use festival\core\domain\Entity\Entity;

class Artiste extends Entity
{
    private string $name;


    public function __construct(string $id, string $name)
    {
        parent::__construct($id);
        $this->name = $name;

    }

    public function getName(): string
    {
        return $this->name;
    }
}