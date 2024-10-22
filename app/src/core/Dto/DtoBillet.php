<?php
namespace festival\core\Dto;
use DateTime;

class DtoBillet
{
    protected int $tarifNormal;
    protected int $tarifReduit;

    public function __construct(int $tarifNormal, int $tarifReduit)
    {
        $this->tarifNormal = $tarifNormal;
        $this->tarifReduit = $tarifReduit;
    }

    public function jsonSerialize() : array
    {
        return [
            'tarifNormal' => $this->tarifNormal,
            'tarifReduit' => $this->tarifReduit
        ];
    }
}