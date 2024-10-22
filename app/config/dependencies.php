<?php

use festival\application\action\GetSoireeAction;
use festival\application\action\GetSpectaclesAction;
use festival\core\ReposotiryInterfaces\SoireeRepositoryInterface;
use festival\core\ReposotiryInterfaces\SpectacleRepositoryInterface;
use festival\core\services\soirees\serviceSoirees;
use festival\core\services\spectacles\serviceSpectacle;
use festival\infrastructure\repositories\PDOSoiree;
use festival\infrastructure\repositories\PDOSpectacle;
use Psr\Container\ContainerInterface;



return[
    'spectacle.pdo' => function (ContainerInterface $c) {
        $pdo = new PDO(
            'mysql:host=festival.db;dbname=festival;charset=utf8',
            'root',
            'root',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return new PDOSpectacle($pdo);
    },

    'soiree.pdo' => function (ContainerInterface $c) {
        $pdo = new PDO(
            'mysql:host=festival.db;dbname=festival;charset=utf8',
            'root',
            'root',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return new PDOSoiree($pdo);
    },

    SpectacleRepositoryInterface::class => function (ContainerInterface $c) {
        return new serviceSpectacle($c->get('spectacle.pdo'));
    },

    SoireeRepositoryInterface::class => function (ContainerInterface $c) {
        return new serviceSoirees($c->get('soiree.pdo'));
    },

    GetSpectaclesAction::class => function (ContainerInterface $c) {
        return new GetSpectaclesAction($c->get(SpectacleRepositoryInterface::class));
    },

    GetSoireeAction::class => function (ContainerInterface $c) {
        return new GetSoireeAction($c->get(SoireeRepositoryInterface::class));
    }
];