<?php

namespace festival\core\services\spectacles;
interface serviceSpectacleInterface{

    public function getSpectacles();

    public function getSpectaclesByFilter(?string $type, ?string $date, ?string $lieu);


}