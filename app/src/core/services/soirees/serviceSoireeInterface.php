<?php

namespace festival\core\services\soirees;

interface serviceSoireeInterface{

    public function getSpectacles(string $id);

    public function getPlacesVendues(string $soireeId) :array;

    public function verfierPlace(array $id_soiree);
}