<?php
namespace festival\core\domain\entities\Billet;

use festival\core\domain\Entity\Entity;


/*Le tarif des billets d’entrée dépend de la soirée, mais existe toujours en deux catégories :
tarif normal et tarif réduit (étudiants, demandeurs d’emploi, personnes en situation de
handicap),*/

class Billet extends Entity
{
    private int $id_soiree;
    private int $id_utilisateur;
    private int $categorie_tarif;
    private int $quantite;
    private int $date_achat;

    public function __construct(int $id, int $id_soiree, int $id_utilisateur, int $categorie_tarif, int $quantite, int $date_achat)
    {
        parent::__construct($id);
        $this->id_soiree = $id_soiree;
        $this->id_utilisateur = $id_utilisateur;
        $this->categorie_tarif = $categorie_tarif;
        $this->quantite = $quantite;
        $this->date_achat = $date_achat;
    }
}

