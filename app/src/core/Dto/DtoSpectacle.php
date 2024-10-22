<?php
namespace festival\core\Dto;
use DateTime;
use festival\core\domain\entities\Spectacle\Spectacle;

class DtoSpectacle extends Dto implements \JsonSerializable{
    protected string $id;
    protected string $title;
    protected array $artists;
    protected string $description;
    protected string $images;
    protected string $videoUrl;
    protected string $heure;

    public function __construct(Spectacle $sp)
    {
        $this->id = $sp->getId();
        $this->title = $sp->getTitle();
        $this->artists = $sp->getArtists();
        $this->description = $sp->getDescription();
        $this->images = $sp->getImages();
        $this->videoUrl = $sp->getVideoUrl();
        $this->heure = $sp->getHour();
    }
    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'artists' => $this->artists,
            'description' => $this->description,
            'images' => $this->images,
            'videoUrl' => $this->videoUrl,
            'heure' => $this->heure
        ];
    }


}