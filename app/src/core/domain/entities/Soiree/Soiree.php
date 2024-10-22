<?php

namespace festival\core\domain\entities\Soiree;

use DateTime;
use DateTimeInterface;
use festival\core\domain\entities\Spectacle\Spectacle;
use festival\core\domain\Entity\Entity;
use festival\core\Dto\DtoSoiree;

class Soiree extends Entity{

    protected string $name;
    protected string $theme;
    protected DateTimeInterface $date;
    protected DateTimeInterface $hour;
    protected string $lieu;
    protected array $spectacles;

    public function __construct(string $name, string $theme, DateTimeInterface $date, DateTimeInterface $hour, string $place, array $spectacles){
        $this->name = $name;
        $this->theme = $theme;
        $this->date = $date;
        $this->hour = $hour;
        $this->lieu = $place;
        $this->spectacles = $spectacles;
    }

    public function toDTO(): DtoSoiree{
        return new DtoSoiree($this);
    }

    // Ajoute les getters
    public function getName(): string {
        return $this->name;
    }

    public function gettheme(): string {
        return $this->theme;
    }

    public function getdate(): DateTimeInterface {
        return $this->date;
    }

    public function getheure(): DateTimeInterface {
        return $this->hour;
    }

    public function getplace(): string {
        return $this->lieu;
    }

    public function getspectacle(): array {
        return $this->spectacles;
    }
}

