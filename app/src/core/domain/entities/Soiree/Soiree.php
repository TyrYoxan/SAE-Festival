<?php

namespace festival\core\domain\entities\Soiree;

use DateTime;
use DateTimeInterface;
use festival\core\domain\entities\Spectacle\Spectacle;
use festival\core\domain\Entity\Entity;
use festival\core\Dto\DtoSoiree;
use festival\core\Dto\DtoSpectacle;

class Soiree extends Entity{

    protected string $name;
    protected string $theme;
    protected string $date;
    protected string $hour;
    protected string $lieu;
    protected array $spectacles;
    protected array $tarifs;

    public function __construct(string $name, string $theme, string $date, string $hour, string $place, array $spectacles, array $tarifs){
        $this->name = $name;
        $this->theme = $theme;
        $this->date = $date;
        $this->hour = $hour;
        $this->lieu = $place;
        $this->spectacles = $spectacles;
        $this->tarifs = $tarifs;
    }

    public function toDTO(): DtoSoiree{
        $dtoSpectacles = array_map(function (Spectacle $spectacle) {
            return new DtoSpectacle($spectacle);
        }, $this->spectacles);

        $this->spectacles = $dtoSpectacles;
        // Créer et retourner le DTO de Soiree avec les spectacles convertis
        $dtoSoiree = new DtoSoiree($this);

        return $dtoSoiree;
    }

    // Ajoute les getters
    public function getName(): string {
        return $this->name;
    }

    public function gettheme(): string {
        return $this->theme;
    }

    public function getdate(): string {
        return $this->date;
    }

    public function getheure(): string {
        return $this->hour;
    }

    public function getplace(): string {
        return $this->lieu;
    }

    public function getspectacle(): array {
        return $this->spectacles;
    }

    public function gettarifs(): array {
        return $this->tarifs;
    }
}

