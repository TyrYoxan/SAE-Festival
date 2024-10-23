<?php
namespace festival\core\domain\Entity;
abstract class Entity
{
    protected ?string $id=null;

    public function __construct(?string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }
}