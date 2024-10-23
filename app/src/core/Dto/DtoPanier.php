<?php
namespace festival\core\Dto;

class DtoPanier
{
    protected array $billets = [];

    public function __construct(array $billets)
    {
        $this->billets = $billets;
    }

    public function jsonSerialize() : array
    {
        return [
            'billets' => $this->billets
        ];
    }
}