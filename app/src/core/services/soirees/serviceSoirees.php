<?php

namespace festival\core\services\soirees;

use festival\core\Dto\DtoSoiree;
use festival\core\ReposotiryInterfaces\SoireeRepositoryInterface;
use festival\core\services\soirees\serviceSoireeInterface;

class serviceSoirees implements serviceSoireeInterface{
    private SoireeRepositoryInterface $soireeRepository;

    public function __construct(SoireeRepositoryInterface $soireeRepository){
        $this->soireeRepository = $soireeRepository;
    }

    public function getSpectacles(string $id):array{
        $soiree = $this->soireeRepository->getSpectacles($id);
        $soirees = [];
        foreach ($soiree as $s){
            $soirees[] = $s->toDTO();
        }
        return $soirees;
    }
}