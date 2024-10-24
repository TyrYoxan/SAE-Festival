<?php

namespace festival\core\services\panier;

interface servicePanierInterface{
    public function getPanier(string $id): array;
    public function ajouterBilletAuPanier(string $id_panier, int $id_soiree, int $quantite): void;
}