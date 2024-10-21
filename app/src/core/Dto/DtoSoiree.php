<?php
namespace festival\core\Dto;

use DateTime;
use festival\core\domain\entities\Soiree\Soiree;

class DtoSoiree
{
    protected String $name;
    protected String $theme;
    protected DateTime $date;
    protected DateTime $hour;
    protected String $place;
    protected array $spectacles;


    public function __construct(Soiree $soiree)
    {
        $this->name = $soiree->getName();
        $this->theme = $soiree->getTheme();
        $this->date = $soiree->getDate();
        $this->hour = $soiree->getHour();
        $this->place = $soiree->getPlace();
        $this->spectacles = $soiree->getSpectacles();
    }

    public function jsonSerialize() : array
    {
        return [
            'name' => $this->name,
            'theme' => $this->theme,
            'date' => $this->date,
            'hour' => $this->hour,
            'place' => $this->place,
            'spectacles' => $this->spectacles
        ];
    }
}