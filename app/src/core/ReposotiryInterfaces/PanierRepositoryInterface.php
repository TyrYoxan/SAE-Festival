<?php

namespace festival\core\ReposotiryInterfaces;

interface PanierRepositoryInterface{
    public function getPanier(String $id): array;

    public function ajouterBilletAuPanier(string $id_panier, int $id_soiree, int $quantite): void;
}