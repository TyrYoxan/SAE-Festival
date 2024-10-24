<?php

namespace festival\core\services\panier;

use festival\core\ReposotiryInterfaces\BilletRepositoryInterface;
use festival\core\ReposotiryInterfaces\PanierRepositoryInterface;
use festival\core\services\panier\servicePanierInterface;

class servicePanier implements servicePanierInterface{
    private PanierRepositoryInterface $panierRepository;
    private BilletRepositoryInterface $billetRepository;

    public function __construct(PanierRepositoryInterface $panierRepository, BilletRepositoryInterface $billetRepository){
        $this->panierRepository = $panierRepository;
        $this->billetRepository = $billetRepository;
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

    public function payerPanier(string $id_user): void
    {
       try{
          $id_panier = $this->panierRepository->payerPanier($id_user);
          foreach ($id_panier as $s){
              $this->billetRepository->creerBillet($s['id_soiree'], $s['quantite'], $s['categorie_tarif'], $id_user);
          }

       }catch(\Exception $e){
           throw new \Exception($e->getMessage());
       }
    }
}