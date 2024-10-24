<?php
namespace festival\core\domain\entities\Billet;

use DateTime;
use festival\core\domain\Entity\Entity;
use festival\core\Dto\DtoBillet;


class Billet extends Entity
{
    private String $id_soiree;
    private String $id_utilisateur;
    private String $categorie_tarif;
    private String $quantite;

    private string $lieu;

    private string $date_soiree;
    private string $heure_soiree;


    private String $date_achat;

    public function __construct(string $id_soiree, string $id_utilisateur, string $categorie_tarif, string $quantite,string $lieu, string $date_soiree, string $heure_soiree, string $date_achat){
        $this->lieu = $lieu;
        $this->heure_soiree = $heure_soiree;
        $this->date_soiree = $date_soiree;
        $this->id_soiree = $id_soiree;
        $this->id_utilisateur = $id_utilisateur;
        $this->categorie_tarif = $categorie_tarif;
        $this->quantite = $quantite;
        $this->date_achat = $date_achat;
    }


    public function toDTO(): DtoBillet{
        return new DtoBillet($this);
    }

    public function getIdSoiree(): string
    {
        return $this->id_soiree;
    }

    public function getIdUtilisateur(): string
    {
        return $this->id_utilisateur;
    }

    public function getCategorieTarif(): string
    {
        return $this->categorie_tarif;
    }

    public function getQuantite(): string
    {
        return $this->quantite;
    }

    public function getDateAchat(): string
    {
        return $this->date_achat;
    }

    public function getLieu(): string
    {
        return $this->lieu;
    }

    public function getDateSoiree(): string{

        $date = new DateTime($this->date_soiree);
        return $date->format('d F Y');
    }

    public function getHeureSoiree(): string
    {
        $heure = new DateTime($this->heure_soiree);
        return $heure->format('H\hi');
    }
}

