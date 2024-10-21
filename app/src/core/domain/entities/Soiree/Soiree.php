<?php
/* Les soirées sont décrites par un nom, une thématique générale (soirée blues, soirée reggae
…), une date et un horaire de début, le lieu où elle se déroule, les spectacles prévus,*/
namespace App\Core\Domain\Entities\Soirée;
use App\Core\Domain\Entities\Entity;
use App\Core\Domain\Entities\Spectacle\Spectacle;

class Soiree extends Entity
{
    private string $name;
    private string $theme;
    private \DateTime $date;
    private \DateTime $hour;
    private string $place;
    private array $spectacles;

    public function __construct(string $id, string $name, string $theme, \DateTime $date, \DateTime $hour, string $place, array $spectacles)
    {
        parent::__construct($id);
        $this->name = $name;
        $this->theme = $theme;
        $this->date = $date;
        $this->hour = $hour;
        $this->place = $place;
        $this->spectacles = $spectacles;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTheme(): string
    {
        return $this->theme;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getHour(): \DateTime
    {
        return $this->hour;
    }

    public function getPlace(): string
    {
        return $this->place;
    }

    public function getSpectacles(): array
    {
        return $this->spectacles;
    }
}

