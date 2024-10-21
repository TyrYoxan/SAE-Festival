<?php
namespace festival\core\domain\entities\Billet;
use festival\core\domain\entities\Entity;
/*Le tarif des billets d’entrée dépend de la soirée, mais existe toujours en deux catégories :
tarif normal et tarif réduit (étudiants, demandeurs d’emploi, personnes en situation de
handicap),*/

class Billet extends Entity{
    private int $tarifNormal;
    private int $tarifReduit;

    public function __construct(string $id, int $tarifNormal, int $tarifReduit){
        parent::__construct($id);
        $this->tarifNormal = $tarifNormal;
        $this->tarifReduit = $tarifReduit;
    }

    public function getTarifNormal(): int{
        return $this->tarifNormal;
    }

    public function getTarifReduit(): int{
        return $this->tarifReduit;
    }
}

