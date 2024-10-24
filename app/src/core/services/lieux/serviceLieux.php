<?php

namespace festival\core\services\lieux;

use festival\core\ReposotiryInterfaces\LieuRepositoryInterface;
use festival\core\services\lieux\serviceLieuxInterface;

class serviceLieux implements serviceLieuxInterface{
    private LieuRepositoryInterface $lieuRepository;


    public function __construct(LieuRepositoryInterface $lieuRepository){
        $this->lieuRepository = $lieuRepository;
    }

    public function getLieux(): array{
        $lieux = $this->lieuRepository->getLieux();
        $lieu = [];
        foreach ($lieux as $l){
            $lieu [] = $l->toDTO();
        }
        return $lieu;
    }
}