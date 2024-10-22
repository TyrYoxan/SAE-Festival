<?php

namespace festival\core\Dto;

use Respect\Validation\Validatable;
use Respect\Validation\Validator;

abstract class Dto
{
    protected ?Validatable $businessValidator = null;

    public function __get(string $name):mixed {
        return property_exists($this, $name) ? $this->$name : throw new \Exception(static::class . ": Property $name does not exist");
    }

    public function toJSON(): string {
        return json_encode($this, JSON_PRETTY_PRINT);
    }

    public function setBusinessValidator(Validatable $validator): void {
        $this->businessValidator = $validator;
    }
    public function validate(): void {
        $this->businessValidator ? $this->businessValidator->assert($this): null;
    }
}
