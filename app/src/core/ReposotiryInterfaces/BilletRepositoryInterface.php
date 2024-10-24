<?php
namespace festival\core\ReposotiryInterfaces;

interface BilletRepositoryInterface{
 public function creerBillet(int $soireeId, int $quantite , string $tarif, string $id_utilisateur): void;
}