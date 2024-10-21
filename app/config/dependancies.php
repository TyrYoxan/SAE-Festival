<?php

use Psr\Container\ContainerInterface;
use toubeelib\core\ReposotiryInterfaces\SpectacleRepositoryInterface;

return[
    'spectacle.pdo' => function (ContainerInterface $c) {
        $pdo = new PDO(
            'mysql:host=localhost;dbname=festival',
            getenv()['MARIADB_ROOT_PASSWORD'],
            getenv()['MARIADB_ROOT_PASSWORD'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return new PDOSpectacle($pdo);
    },

    SpectacleRepositoryInterface::class => function (ContainerInterface $c) {
        return new serviceSpectacle($c->get('spectacle.pdo'));
    }
];