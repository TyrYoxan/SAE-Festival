<?php

namespace festival\core\Dto;

use festival\core\domain\entities\Soiree\Soiree;
use festival\core\Dto\Dto;

class DtoOutPutSoiree extends Dto implements \JsonSerializable
{

    protected String $name;
    protected String $theme;
    protected string $date;
    protected string $hour;
    protected String $lieu;
    protected array $tarifs;


    public function __construct(Soiree $soiree){
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
            'tarif' => $this->tarifs[0],
            'lieu' => $this->lieu,
        ];
    }
}