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
        foreach ($panier as $p){
            $paniers[] = $p->toDTO();
        }
        return $paniers;
    }

    public function ajouterBilletAuPanier(int $soireeId, int $quantite): void {
        $billet = $this->billetRepository->creerBillet($soireeId, $quantite);
        $this->panier->ajouterBillet($billet);
    }
}