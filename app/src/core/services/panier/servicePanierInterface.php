<?php

namespace festival\core\services\panier;

interface servicePanierInterface{
    public function getPanier(string $id): array;
    public function ajouterBilletAuPanier(int $soireeId, int $quantite): void;
}