<?php

namespace festival\core\ReposotiryInterfaces;
interface SpectacleRepositoryInterface {
    public function getSpectacles(): array;
    public function getSpectaclesByFilter(?string $type, ?string $date, ?string $lieu);


}