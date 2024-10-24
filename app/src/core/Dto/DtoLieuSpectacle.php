<?php
namespace festival\core\Dto;

use DateTime;
use festival\core\domain\entities\LieuSpectacle\LieuSpectacle;
class DtoLieuSpectacle extends Dto implements \JsonSerializable{

    protected int $id;

    protected string $name;

    protected string $address;

    protected int $nbrPlaceAssise;

    protected int $nbrPlaceDebout;

    protected string $images;

    public function __construct(LieuSpectacle $lieuSpectacle){
        $this->id = $lieuSpectacle->getId();
        $this->name = $lieuSpectacle->getName();
        $this->address = $lieuSpectacle->getAddress();
        $this->nbrPlaceAssise = $lieuSpectacle->getNbrPlaceAssise();
        $this->nbrPlaceDebout = $lieuSpectacle->getNbrPlaceDebout();
        $this->images = $lieuSpectacle->getImages();
    }

    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'nbrPlaceAssise' => $this->nbrPlaceAssise,
            'nbrPlaceDebout' => $this->nbrPlaceDebout,
            'images' => $this->images
        ];
    }
}