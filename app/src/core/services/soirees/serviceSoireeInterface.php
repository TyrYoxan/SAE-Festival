<?php

namespace festival\core\services\soirees;

interface serviceSoireeInterface{

    public function getSpectacles(string $id);

    public function ajouterBilletAuPanier(int $soireeId, int $quantite): void;
}