<?php

namespace festival\core\domain\entities\Panier;

use festival\core\domain\entities\Billet\Billet;
use festival\core\domain\Entity\Entity;
use festival\core\Dto\DtoPanier;

class Panier extends Entity {

    protected string $id_utilisateur;
    protected array $id_soiree;
    protected string $etat;

    public function __construct(string $id_utilisateur, array $id_soiree, string $etat) {
        $this->id_utilisateur = $id_utilisateur;
        $this->id_soiree = $id_soiree;
        $this->etat = $etat;
    }

    public function toDTO(): DtoPanier{
        return new DtoPanier($this);
    }

    public function getIdUtilisateur(): string
    {
        return $this->id_utilisateur;
    }

    public function getIdSoiree(): array
    {
        return $this->id_soiree;
    }

    public function getEtat(): string
    {
        return $this->etat;
    }


}