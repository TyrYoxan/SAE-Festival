<?php

namespace festival\core\ReposotiryInterfaces;

interface SoireeRepositoryInterface{

    public function getSpectacles(string $id): array;
}