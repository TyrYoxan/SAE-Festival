<?php
namespace festival\core\domain\entities\LieuSpectacle;

use DateTime;
use festival\core\domain\Entity\Entity;
use festival\core\Dto\DtoLieuSpectacle;

class LieuSpectacle extends Entity{
    private String $name;

    private String $address;

    private int $nbrPlaceAssise;

    private int $nbrPlaceDebout;

    private string $images;


    public function __construct(string $name, string $address, int $nbrPlaceAssise, int $nbrPlaceDebout, string $images)
    {
        $this->name = $name;
        $this->address = $address;
        $this->nbrPlaceAssise = $nbrPlaceAssise;
        $this->nbrPlaceDebout = $nbrPlaceDebout;
        $this->images = $images;
    }


    public function toDTO(): DtoLieuSpectacle{
        return new DtoLieuSpectacle($this);
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function getAddress(): string
    {
        return $this->address;
    }

    public function getNbrPlaceAssise(): int
    {
        return $this->nbrPlaceAssise;
    }

    public function getNbrPlaceDebout(): int
    {
        return $this->nbrPlaceDebout;
    }

    public function getImages(): string
    {
        return $this->images;
    }
}