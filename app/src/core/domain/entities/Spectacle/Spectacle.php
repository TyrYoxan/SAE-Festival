<?php
namespace festival\core\domain\entities\Spectacle;

use DateTime;
use festival\core\domain\Entity\Entity;
use festival\core\Dto\DtoSoiree;
use festival\core\Dto\DtoSpectacle;

/*Un spectacle est décrit par un titre, un ou plusieurs artistes, une description, une ou plusieurs
images, une url vers une vidéo, un horaire prévisionnel.*/
class Spectacle extends Entity
{
    private String $title;
    private array $artists;
    private String $description;
    private string $images;
    private String $videoUrl;
    private string $heure;

    public function __construct(string $title, array $artists, string $description, string $images, string $videoUrl, string $heure)
    {

        $this->title = $title;
        $this->artists = $artists;
        $this->description = $description;
        $this->images = $images;
        $this->videoUrl = $videoUrl;
        $this->heure = $heure;
    }

    public function toDTO(): DtoSpectacle{
        return new DtoSpectacle($this);
    }
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getArtists(): array
    {
        return $this->artists;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImages(): string
    {
        return $this->images;
    }

    public function getVideoUrl(): string
    {
        return $this->videoUrl;
    }

    public function getHour(): string
    {
        return $this->heure;
    }


}
