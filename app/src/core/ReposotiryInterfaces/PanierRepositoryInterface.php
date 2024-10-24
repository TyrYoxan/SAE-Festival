<?php

namespace festival\core\ReposotiryInterfaces;

interface PanierRepositoryInterface{
    public function getPanier(String $id): array;

    public function ajouterBilletAuPanier(string $id_user, int $id_soiree, string $quantite, string $tarif): void;

    public function validatePanier(string $id): void;

    public function payerPanier(string $id): array;
}