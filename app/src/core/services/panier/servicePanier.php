<?php

namespace festival\core\services\panier;

use festival\core\ReposotiryInterfaces\PanierRepositoryInterface;
use festival\core\services\panier\servicePanierInterface;

class servicePanier implements servicePanierInterface{
    private PanierRepositoryInterface $panierRepository;

    public function __construct(PanierRepositoryInterface $panierRepository){
        $this->panierRepository = $panierRepository;
    }
    public function getPanier(string $id): array{
        $panier = $this->panierRepository->getPanier($id);
        $paniers = [];
        foreach ($panier as $p) {
            $soirees = [];
            foreach ($p->getIdSoiree() as $s) {
                $soirees[] = $s->toOutputDTO();
            }


            $panierDTO = $p->toDTO();
            $panierDTO->setSoirees($soirees);
            $paniers[] = $panierDTO;
        }

        return $paniers;
    }


    public function ajouterBilletAuPanier(string $id_user, int $id_soiree, string $quantite, string $tarif): void {
        try{
            $this->panierRepository->ajouterBilletAuPanier($id_user, $id_soiree, $quantite, $tarif);
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function validatePanier(string $id): void{
        try{
            $this->panierRepository->validatePanier($id);
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}