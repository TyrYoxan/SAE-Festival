<?php

namespace festival\core\services\themes;

use festival\core\ReposotiryInterfaces\SoireeRepositoryInterface;
use festival\core\ReposotiryInterfaces\ThemeRepositoryInterface;
use festival\core\services\themes\serviceThemesInterface;

class serviceThemes implements serviceThemesInterface{

    private ThemeRepositoryInterface $soireeRepository;

    public function __construct(ThemeRepositoryInterface $soireeRepository){
        $this->soireeRepository = $soireeRepository;
    }

    public function getThemes(): array{
        $soirees = $this->soireeRepository->getThemes();
        $themes = [];

        foreach ($soirees as $s) {
            $themes[] = $s->toDTO();
        }

        return $themes;
    }
}