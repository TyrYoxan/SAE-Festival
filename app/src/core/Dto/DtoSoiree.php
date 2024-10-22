<?php
namespace festival\core\Dto;

use DateTime;
use festival\core\domain\entities\Soiree\Soiree;
use festival\core\domain\entities\Spectacle\Spectacle;

class DtoSoiree extends Dto implements \JsonSerializable{
    protected String $name;
    protected String $theme;
    protected string $date;
    protected string $hour;
    protected String $lieu;
    protected array $spectacles;
    protected array $tarifs;


    public function __construct(Soiree $soiree){
      $this->name = $soiree->getname();
      $this->theme = $soiree->gettheme();
      $this->date = $soiree->getdate();
      $this->hour = $soiree->getheure();
      $this->lieu = $soiree->getplace();
      $this->spectacles = $soiree->getspectacle();
      $this->tarifs = $soiree->gettarifs();

    }

    public function jsonSerialize() : array
    {
        return [
            'name' => $this->name,
            'theme' => $this->theme,
            'date' => $this->date,
            'hour' => $this->hour,
            'tarifs' => $this->tarifs,
            'lieu' => $this->lieu,
            'spectacles' => $this->spectacles
        ];
    }
}