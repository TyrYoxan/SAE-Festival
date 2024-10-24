<?php
namespace festival\core\services\panier;

class servicePanier implements servicePanierInterface
{
    private $panier;

    public function __construct($panier)
    {
        $this->panier = $panier;
    }

    public function getPanierDetails(): array {
        $billets = $this->panier->getBillets();
        $total = 0;
        foreach ($billets as $billet) {
            $total += $billet->getPrix() * $billet->getQuantite();
        }
        return [
            'billets' => $billets,
            'total' => $total
        ];
    }
    public function ajouterBilletAuPanier(int $soireeId, int $quantite): void {
        $billet = $this->billetRepository->creerBillet($soireeId, $quantite);
        $this->panier->ajouterBillet($billet);
    }
}