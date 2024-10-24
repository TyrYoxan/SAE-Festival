<?php

namespace festival\core\ReposotiryInterfaces;

interface PanierRepositoryInterface{
    public function getPanier(String $id): array;

    public function ajouterBilletAuPanier(string $id_user, int $id_soiree, string $quantite, string $tarif): void;
}