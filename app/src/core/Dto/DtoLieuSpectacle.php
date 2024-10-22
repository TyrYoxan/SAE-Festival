<?php
namespace festival\core\Dto;

use DateTime;
use festival\core\domain\entities\LieuSpectacle\LieuSpectacle;
class DtoLieuSpectacle
{
    protected string $name;
    protected DateTime $date;

    protected string $address;

    protected int $nbrPlaceAssise;

    protected int $nbrPlaceDebout;

    protected array $images;

    public function __construct(LieuSpectacle $lieuSpectacle)
    {
        $this->name = $lieuSpectacle->getName();
        $this->date = $lieuSpectacle->getDate();
        $this->address = $lieuSpectacle->getAddress();
        $this->nbrPlaceAssise = $lieuSpectacle->getNbrPlaceAssise();
        $this->nbrPlaceDebout = $lieuSpectacle->getNbrPlaceDebout();
        $this->images = $lieuSpectacle->getImages();
    }

    public function jsonSerialize() : array
    {
        return [
            'name' => $this->name,
            'date' => $this->date,
            'address' => $this->address,
            'nbrPlaceAssise' => $this->nbrPlaceAssise,
            'nbrPlaceDebout' => $this->nbrPlaceDebout,
            'images' => $this->images
        ];
    }
}