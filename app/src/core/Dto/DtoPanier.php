<?php
namespace festival\core\Dto;

use festival\core\domain\entities\Panier\Panier;

class DtoPanier extends Dto implements \JsonSerializable{
    protected  string $id;
    protected string $id_utilisateur;
    protected array $id_soiree;
    protected string $etat;

    public function __construct(Panier $panier)
    {
        $this->id = $panier->getId();
        $this->id_utilisateur = $panier->getIdUtilisateur();
        $this->id_soiree = $panier->getIdSoiree();
        $this->etat = $panier->getEtat();
    }

    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id,
                'id_utilisateur' => $this->id_utilisateur,
                'id_soiree' => $this->id_soiree,
                'etat' => $this->etat
        ];
    }
}