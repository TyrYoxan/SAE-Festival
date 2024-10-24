<?php

namespace festival\core\domain\entities\Panier;

use festival\core\domain\entities\Billet\Billet;

class Panier {
    private array $billets = [];

    public function ajouterBillet(Billet $billet): void {
        $this->billets[] = $billet;
    }

    public function getBillets(): array {
        return $this->billets;
    }
}