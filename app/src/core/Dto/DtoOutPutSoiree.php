<?php

namespace festival\core\Dto;

use festival\core\domain\entities\Soiree\Soiree;
use festival\core\Dto\Dto;

class DtoOutPutSoiree extends Dto implements \JsonSerializable
{

    protected int $id;
    protected String $name;
    protected String $theme;
    protected string $date;
    protected string $hour;
    protected string $quantite;
    protected String $lieu;
    protected array $tarifs;


    public function __construct(Soiree $soiree){

        $this->id = $soiree->getid();
        $this->quantite = $soiree->getQuantite();
        $this->name = $soiree->getname();
        $this->theme = $soiree->gettheme();
        $this->date = $soiree->getdate();
        $this->hour = $soiree->getheure();
        $this->lieu = $soiree->getplace();
        $this->tarifs = $soiree->gettarifs();

    }

    public function jsonSerialize() : array
    {
        return [
            'name' => $this->name,
            'theme' => $this->theme,
            'date' => $this->date,
            'hour' => $this->hour,
            'quantite' => $this->quantite,
            'tarif' => $this->tarifs[0],
            'lieu' => $this->lieu,
        ];
    }
}