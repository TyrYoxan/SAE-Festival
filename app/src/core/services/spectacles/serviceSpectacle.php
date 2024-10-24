<?php

namespace festival\core\services\spectacles;
use festival\core\services\spectacles\serviceSpectacleInterface;
use festival\core\ReposotiryInterfaces\SpectacleRepositoryInterface;

class serviceSpectacle implements serviceSpectacleInterface{
    private SpectacleRepositoryInterface $spectacleRepository;

    public function __construct(SpectacleRepositoryInterface $spectacleRepository){
        $this->spectacleRepository = $spectacleRepository;
    }

    public function getSpectacles(){
        $spectacle = $this->spectacleRepository->getSpectacles();
        return $spectacle;
    }

    public function getSpectaclesByFilter(?string $type, ?string $date, ?string $lieu)
    {
       $spectacle = $this->spectacleRepository->getSpectaclesByFilter($type, $date, $lieu);
       return $spectacle;
    }
}