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


    public function ajouterBilletAuPanier(string $id_panier, int $id_soiree, int $quantite): void {
        try{
            $this->panierRepository->ajouterBilletAuPanier($id_panier, $id_soiree, $quantite);
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}