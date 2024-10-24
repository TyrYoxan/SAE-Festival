<?php
namespace festival\core\domain\entities\Billet;

use festival\core\domain\Entity\Entity;
use festival\core\Dto\DtoBillet;


/*Le tarif des billets d’entrée dépend de la soirée, mais existe toujours en deux catégories :
tarif normal et tarif réduit (étudiants, demandeurs d’emploi, personnes en situation de
handicap),*/

class Billet extends Entity
{
    private String $id_soiree;
    private String $id_utilisateur;
    private String $categorie_tarif;
    private String $quantite;
    private String $date_achat;

    public function __construct(string $id_soiree, string $id_utilisateur, string $categorie_tarif, string $quantite, string $date_achat)
    {
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


}

