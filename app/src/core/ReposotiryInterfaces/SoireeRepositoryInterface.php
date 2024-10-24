<?php

namespace festival\core\ReposotiryInterfaces;


interface SoireeRepositoryInterface{

    public function getSpectacles(string $id): array;

    public function getPlacesVendues(string $soireeId) : int;

    function getPlacesDisponibles(string $soireeId) : int;

    public function verfierPlace(array $id_soiree) : bool;
}