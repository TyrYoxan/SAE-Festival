<?php

use festival\application\action\DeleteItemAction;
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
        return new PDOBillet($c->get('pdo'));
    },

    // Repositories
    'service_spectacle' => function (ContainerInterface $c) {
        return new serviceSpectacle($c->get('spectacle.pdo'));
    },

    'service_soiree' => function (ContainerInterface $c) {
        return new serviceSoirees($c->get('soiree.pdo'));
    },

    'service_theme' => function (ContainerInterface $c) {
        return new serviceThemes($c->get('theme.pdo'));
    },

    'service_lieu' => function (ContainerInterface $c) {
        return new serviceLieux($c->get('lieu.pdo'));
    },

    // Services
    'service_utilisateur' => function (ContainerInterface $c) {
        return new serviceUtilisateur($c->get('user.pdo'));
    },

    'service_panier' => function (ContainerInterface $c) {
        return new servicePanier($c->get('panier.pdo'), $c->get('billet.pdo'));
    },

    'jwt_auth_provider' => function (ContainerInterface $c) {
        return new JWTAuthnProvider($c->get('user.pdo'));
    },

    // Actions
    GetSpectaclesAction::class => function (ContainerInterface $c) {
        return new GetSpectaclesAction($c->get('service_spectacle'));
    },

    GetSoireeAction::class => function (ContainerInterface $c) {
        return new GetSoireeAction($c->get('service_soiree'));
    },

    GetThemesAction::class => function (ContainerInterface $c) {
        return new GetThemesAction($c->get('service_theme'));
    },

    GetLieuxAction::class => function (ContainerInterface $c) {
        return new GetLieuxAction($c->get('service_lieu'));
    },

    PostCreateUserAction::class => function (ContainerInterface $c) {
        return new PostCreateUserAction($c->get('service_utilisateur'));
    },

    PostSigninAction::class => function (ContainerInterface $c) {
        return new PostSigninAction($c->get('user.pdo'));
    },

    GetTicketByUserAction::class => function (ContainerInterface $c) {
        return new GetTicketByUserAction($c->get('service_utilisateur'));
    },

    GetPanierAction::class => function (ContainerInterface $c) {
        return new GetPanierAction($c->get('service_panier'));
    },

    GetAddBilletPanierAction::class => function (ContainerInterface $c) {
        return new GetAddBilletPanierAction($c->get('service_panier'));
    },

    PostValidatePanierAction::class => function (ContainerInterface $c) {
        return new PostValidatePanierAction($c->get('service_panier'));
    },

    GetnbPlacesVenduesAction::class => function (ContainerInterface $c) {
        return new GetnbPlacesVenduesAction($c->get('service_soiree'));
    },

    PostPayerPanierAction::class => function (ContainerInterface $c) {
        return new PostPayerPanierAction($c->get('service_panier'), $c->get('service_soiree'));
    },

    DeleteItemAction::class => function (ContainerInterface $c) {
        return new DeleteItemAction($c->get('service_panier'));
    },
];