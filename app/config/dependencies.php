<?php

use festival\application\action\GetAddBilletPanierAction;
use festival\application\action\GetLieuxAction;
use festival\application\action\GetnbPlacesVenduesAction;
use festival\application\action\GetPanierAction;
use festival\application\action\GetSoireeAction;
use festival\application\action\GetSpectaclesAction;
use festival\application\action\GetThemesAction;
use festival\application\action\GetTicketByUserAction;
use festival\application\action\PostCreateUserAction;
use festival\application\action\PostPayerPanierAction;
use festival\application\action\PostSigninAction;
use festival\application\action\PostValidatePanierAction;
use festival\application\middlewares\AdminMiddleware;
use festival\application\middlewares\Cors;
use festival\application\middlewares\JWTAuthMiddleware;
use festival\application\providers\auth\JWTAuthnProvider;
use festival\core\ReposotiryInterfaces\BilletRepositoryInterface;
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
use festival\infrastructure\repositories\PDOBillet;
use festival\infrastructure\repositories\PDOLieu;
use festival\infrastructure\repositories\PDOPanier;
use festival\infrastructure\repositories\PDOSoiree;
use festival\infrastructure\repositories\PDOSpectacle;
use festival\infrastructure\repositories\PDOTheme;
use festival\infrastructure\repositories\PDOUtilisateur;
use Psr\Container\ContainerInterface;



return[
    Cors::class => function (ContainerInterface $c) {
        return new Cors();
    },

    JWTAuthMiddleware::class => function (ContainerInterface $c) {
            return new JWTAuthMiddleware();
    },

    AdminMiddleware::class => function (ContainerInterface $c) {
        return new AdminMiddleware();
    },

    // PDO
    'pdo' => function (ContainerInterface $c) {
        return new PDO(
            'mysql:host=festival.db;dbname=festival;charset=utf8',
            'root',
            'root',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    },

    'spectacle.pdo' => function (ContainerInterface $c) {
        return new PDOSpectacle($c->get('pdo'));
    },

    'soiree.pdo' => function (ContainerInterface $c) {

        return new PDOSoiree($c->get('pdo'));
    },

    'theme.pdo' => function (ContainerInterface $c) {
        return new PDOTheme($c->get('pdo'));
    },

    'lieu.pdo' => function (ContainerInterface $c) {
        return new PDOLieu($c->get('pdo'));
    },

    'user.pdo' => function (ContainerInterface $c) {
        return new PDOUtilisateur($c->get('pdo'));
    },

    'panier.pdo' => function (ContainerInterface $c) {
        return new PDOPanier($c->get('pdo'));
    },

    'billet.pdo' => function (ContainerInterface $c) {
        $pdo = new PDO(
            'mysql:host=festival.db;dbname=festival;charset=utf8',
            'root',
            'root',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        return new PDOBillet($pdo);
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

    BilletRepositoryInterface::class => function (ContainerInterface $c) {
        return $c->get('billet.pdo');
    },

    // Services
    serviceUtilisateurInterface::class => function (ContainerInterface $c) {
        return new serviceUtilisateur($c->get(UtilisateurRepositoryInterface::class));
    },

    servicePanierInterface::class => function (ContainerInterface $c) {
        return new servicePanier($c->get(PanierRepositoryInterface::class), $c->get(BilletRepositoryInterface::class));
    },

    JWTAuthnProvider::class => function (ContainerInterface $c) {
        return new JWTAuthnProvider($c->get(UtilisateurRepositoryInterface::class));
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
    },

    GetnbPlacesVenduesAction::class => function (ContainerInterface $c) {
        return new GetnbPlacesVenduesAction($c->get(SoireeRepositoryInterface::class));
    },

    PostPayerPanierAction::class => function (ContainerInterface $c) {
        return new PostPayerPanierAction($c->get(servicePanierInterface::class), $c->get(SoireeRepositoryInterface::class));
    },
];