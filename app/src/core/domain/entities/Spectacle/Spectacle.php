<?php
namespace festival\core\domain\entities\Spectacle;

use DateTime;
use festival\core\domain\Entity\Entity;
/*Un spectacle est décrit par un titre, un ou plusieurs artistes, une description, une ou plusieurs
images, une url vers une vidéo, un horaire prévisionnel.*/
class Spectacle extends Entity
{
    private String $title;
    private array $artists;
    private String $description;
    private array $images;
    private String $videoUrl;
    private DateTime $heure;

    public function __construct(string $id, string $title, array $artists, string $description, array $images, string $videoUrl, DateTime $heure)
    {
        parent::__construct($id);
        $this->title = $title;
        $this->artists = $artists;
        $this->description = $description;
        $this->images = $images;
        $this->videoUrl = $videoUrl;
        $this->heure = $heure;
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

    public function getImages(): array
    {
        return $this->images;
    }

    public function getVideoUrl(): string
    {
        return $this->videoUrl;
    }

    public function getHour(): DateTime
    {
        return $this->heure;
    }
}
