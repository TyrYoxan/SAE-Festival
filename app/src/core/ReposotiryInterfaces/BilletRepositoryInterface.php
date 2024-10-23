<?php
namespace festival\core\ReposotiryInterfaces;

interface BilletRepositoryInterface
{
 public function getBillets(): array;
 public function creerBillet(int $soireeId, int $quantite , int $tarif);
}