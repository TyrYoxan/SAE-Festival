<?php
namespace festival\core\domain\entities\Spectacle;

use DateTime;
use festival\core\domain\Entity\Entity;

class Spectacle extends Entity
{
    private String $name;
    private DateTime $date;

    private String $address;

    private int $nbrPlaceAssise;

    private int $nbrPlaceDebout;

    private array $images;


    public function __construct(string $id, string $name, DateTime $date, string $address, int $nbrPlaceAssise, int $nbrPlaceDebout, array $images)
    {
        parent::__construct($id);
        $this->name = $name;
        $this->date = $date;
        $this->address = $address;
        $this->nbrPlaceAssise = $nbrPlaceAssise;
        $this->nbrPlaceDebout = $nbrPlaceDebout;
        $this->images = $images;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDate(): DateTime
    {
        return $this->date;
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

    public function getImages(): array
    {
        return $this->images;
    }
}