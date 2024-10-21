<?php

use toubeelib\core\ReposotiryInterfaces\SpectacleRepositoryInterface;

class serviceSpectacle implements serviceSpectacleInterface{
    private SpectacleRepositoryInterface $spectacleRepository;

    public function __construct(SpectacleRepositoryInterface $spectacleRepository){
        $this->spectacleRepository = $spectacleRepository;
    }

    public function getSpectacles(){
        $spectacle = $this->spectacleRepository->getSpectacles();
        return $spectacle;
    }
}