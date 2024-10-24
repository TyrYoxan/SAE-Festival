<?php

namespace festival\infrastructure\repositories;

use festival\core\domain\entities\Theme\Theme;
use festival\core\ReposotiryInterfaces\ThemeRepositoryInterface;
use PDO;

class PDOTheme implements ThemeRepositoryInterface{

    private PDO $pdo;
    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function getThemes(): array{
        $stmt = $this->pdo->prepare('SELECT * FROM Thematique;');
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $themes = [];
        foreach ($rows as $row){
            $theme = new Theme($row['nom_thematique']);
            $theme->setId($row['id_thematique']);
            $themes[] = $theme;
        }
        return $themes;
    }
}