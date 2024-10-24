<?php

namespace festival\core\services\panier;

interface servicePanierInterface{
    public function getPanier(string $id): array;
    public function ajouterBilletAuPanier(string $id_user, int $id_soiree, string $quantite, string $tarif): void;

    public function validatePanier(string $id): void;
}