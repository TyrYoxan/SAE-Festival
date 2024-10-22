<?php

namespace festival\core\services\soirees;

use festival\core\ReposotiryInterfaces\SoireeRepositoryInterface;
use festival\core\services\soirees\serviceSoireeInterface;

class serviceSoirees implements serviceSoireeInterface{
    private SoireeRepositoryInterface $soireeRepository;

    public function __construct(SoireeRepositoryInterface $soireeRepository){
        $this->soireeRepository = $soireeRepository;
    }

    public function getSpectacles(string $id){
        $soiree = $this->soireeRepository->getSpectacles($id);
        return $soiree;
    }
}