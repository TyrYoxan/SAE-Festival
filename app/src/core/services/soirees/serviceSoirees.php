<?php

namespace festival\core\services\soirees;


use festival\core\Dto\DtoSoiree;
use festival\core\ReposotiryInterfaces\SoireeRepositoryInterface;
use festival\core\services\soirees\serviceSoireeInterface;
use festival\core\domain\entities\Billet\Billet;
use festival\core\domain\entities\Panier\Panier;
use festival\core\ReposotiryInterfaces\BilletRepositoryInterface;

class serviceSoirees implements serviceSoireeInterface{
    private SoireeRepositoryInterface $soireeRepository;
    private Panier $panier;
    private $billetRepository;

    public function __construct(SoireeRepositoryInterface $soireeRepository){
        $this->soireeRepository = $soireeRepository;
        $this->panier = new Panier();


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