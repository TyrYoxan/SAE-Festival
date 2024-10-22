<?php

namespace festival\core\ReposotiryInterfaces;

use festival\core\domain\entities\Soiree\Soiree;

interface SoireeRepositoryInterface{

    public function getSpectacles(string $id): array;
}