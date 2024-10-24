<?php

use festival\application\action\GetAddBilletPanierAction;
use festival\application\action\GetLieuxAction;
use festival\application\action\GetPanierAction;
use festival\application\action\GetSoireeAction;
use festival\application\action\GetSpectaclesAction;
use festival\application\action\GetThemesAction;
use festival\application\action\GetTicketByUserAction;
use festival\application\action\PostCreateUserAction;
use festival\application\action\PostSigninAction;
use festival\application\action\PostValidatePanierAction;
use festival\core\ReposotiryInterfaces\LieuRepositoryInterface;
use festival\core\ReposotiryInterfaces\PanierRepositoryInterface;
use festival\core\ReposotiryInterfaces\SoireeRepositoryInterface;
use festival\core\ReposotiryInterfaces\SpectacleRepositoryInterface;
use festival\core\ReposotiryInterfaces\ThemeRepositoryInterface;
use festival\core\ReposotiryInterfaces\UtilisateurRepositoryInterface;
use festival\core\services\lieux\serviceLieux;
use festival\core\services\panier\servicePanier;
use festival\core\services\panier\servicePanierInterface;
use festival\core\services\soirees\serviceSoirees;
use festival\core\services\spectacles\serviceSpectacle;
use festival\core\services\themes\serviceThemes;
use festival\core\services\Utilisateur\serviceUtilisateur;
use festival\core\services\Utilisateur\serviceUtilisateurInterface;
use festival\infrastructure\repositories\PDOLieu;
use festival\infrastructure\repositories\PDOPanier;
use festival\infrastructure\repositories\PDOSoiree;
use festival\infrastructure\repositories\PDOSpectacle;
use festival\infrastructure\repositories\PDOTheme;
use festival\infrastructure\repositories\PDOUtilisateur;
use Psr\Container\ContainerInterface;



return[
    // PDO
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

    'theme.pdo' => function (ContainerInterface $c) {
        $pdo = new PDO(
            'mysql:host=festival.db;dbname=festival;charset=utf8',
            'root',
            'root',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return new PDOTheme($pdo);
    },

    'lieu.pdo' => function (ContainerInterface $c) {
        $pdo = new PDO(
            'mysql:host=festival.db;dbname=festival;charset=utf8',
            'root',
            'root',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return new PDOLieu($pdo);
    },

    'user.pdo' => function (ContainerInterface $c) {
        $pdo = new PDO(
            'mysql:host=festival.db;dbname=festival;charset=utf8',
            'root',
            'root',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return new PDOUtilisateur($pdo);
    },

    'panier.pdo' => function (ContainerInterface $c) {
        $pdo = new PDO(
            'mysql:host=festival.db;dbname=festival;charset=utf8',
            'root',
            'root',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return new PDOPanier($pdo);
    },

    // Repositories
    SpectacleRepositoryInterface::class => function (ContainerInterface $c) {
        return new serviceSpectacle($c->get('spectacle.pdo'));
    },

    SoireeRepositoryInterface::class => function (ContainerInterface $c) {
        return new serviceSoirees($c->get('soiree.pdo'));
    },

    ThemeRepositoryInterface::class => function (ContainerInterface $c) {
        return new serviceThemes($c->get('theme.pdo'));
    },

    LieuRepositoryInterface::class => function (ContainerInterface $c) {
        return new serviceLieux($c->get('lieu.pdo'));
    },

    UtilisateurRepositoryInterface::class => function (ContainerInterface $c) {
        return $c->get('user.pdo');
    },

    PanierRepositoryInterface::class => function (ContainerInterface $c) {
        return $c->get('panier.pdo');
    },

    // Services
    serviceUtilisateurInterface::class => function (ContainerInterface $c) {
        return new serviceUtilisateur($c->get(UtilisateurRepositoryInterface::class));
    },

    servicePanierInterface::class => function (ContainerInterface $c) {
        return new servicePanier($c->get(PanierRepositoryInterface::class));
    },

    // Actions
    GetSpectaclesAction::class => function (ContainerInterface $c) {
        return new GetSpectaclesAction($c->get(SpectacleRepositoryInterface::class));
    },

    GetSoireeAction::class => function (ContainerInterface $c) {
        return new GetSoireeAction($c->get(SoireeRepositoryInterface::class));
    },

    GetThemesAction::class => function (ContainerInterface $c) {
        return new GetThemesAction($c->get(ThemeRepositoryInterface::class));
    },

    GetLieuxAction::class => function (ContainerInterface $c) {
        return new GetLieuxAction($c->get(LieuRepositoryInterface::class));
    },

    PostCreateUserAction::class => function (ContainerInterface $c) {
        return new PostCreateUserAction($c->get(serviceUtilisateurInterface::class));
    },

    PostSigninAction::class => function (ContainerInterface $c) {
        return new PostSigninAction($c->get(UtilisateurRepositoryInterface::class));
    },

    GetTicketByUserAction::class => function (ContainerInterface $c) {
        return new GetTicketByUserAction($c->get(serviceUtilisateurInterface::class));
    },

    GetPanierAction::class => function (ContainerInterface $c) {
        return new GetPanierAction($c->get(servicePanierInterface::class));
    },

    GetAddBilletPanierAction::class => function (ContainerInterface $c) {
        return new GetAddBilletPanierAction($c->get(servicePanierInterface::class));
    },

    PostValidatePanierAction::class => function (ContainerInterface $c) {
        return new PostValidatePanierAction($c->get(servicePanierInterface::class));
    }
];