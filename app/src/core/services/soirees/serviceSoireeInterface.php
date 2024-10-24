<?php

namespace festival\core\services\soirees;

interface serviceSoireeInterface{

    public function getSpectacles(string $id);

    public function getPlacesVendues(string $soireeId);
}