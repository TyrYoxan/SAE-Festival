<?php
namespace festival\core\Dto;
use DateTime;
use festival\core\domain\entities\Billet\Billet;

class DtoBillet extends Dto implements \JsonSerializable{
    protected string $id_bille;
    protected string $id_utilisateur;
    protected string $id_soiree;
    protected int $quantite;
    protected string $tarif;

    protected string $date_achat;

    public function __construct(Billet $billet){
      $this->id_bille = $billet->getId();
      $this->id_utilisateur = $billet->getIdUtilisateur();
      $this->id_soiree = $billet->getIdSoiree();
      $this->quantite = $billet->getQuantite();
      $this->tarif = $billet->getCategorieTarif();
      $this->date_achat = $billet->getDateAchat();
    }

    public function jsonSerialize() : array
    {
        return [
            'id' => $this->id_bille,
            'utilisateur' => $this->id_utilisateur,
            'soiree' => $this->id_soiree,
            'quantite' => $this->quantite,
            'tarif' => $this->tarif,
            'date_achat' => $this->date_achat
        ];
    }
}