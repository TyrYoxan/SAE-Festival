<?php

namespace festival\core\ReposotiryInterfaces;

interface PanierRepositoryInterface{
    public function getPanier(String $id): array;
}