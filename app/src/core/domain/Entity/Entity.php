<?php
namespace festival\core\domain\Entity;
abstract class Entity
{
    protected ?string $id=null;



    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }
}