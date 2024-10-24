<?php
namespace festival\core\services\panier;
interface servicePanierInterface{
    public function getPanierDetails();
    public function ajouterBilletAuPanier(int $soireeId, int $quantite): void;
}