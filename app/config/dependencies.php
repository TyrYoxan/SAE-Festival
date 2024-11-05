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

return [
    'middleware.cors_instance' => function (ContainerInterface $c) {
        return new Cors();
    },

    'middleware.jwt_auth_instance' => function (ContainerInterface $c) {
        return new JWTAuthMiddleware();
    },

    'middleware.admin_instance' => function (ContainerInterface $c) {
        return new AdminMiddleware();
    },

    // Database connection
    'database.pdo_connection' => function (ContainerInterface $c) {
        return new PDO(
            'mysql:host=festival.db;dbname=festival;charset=utf8',
            'root',
            'root',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    },

    // Repositories PDO
    'pdo.spectacle_repository' => function (ContainerInterface $c) {
        return new PDOSpectacle($c->get('database.pdo_connection'));
    },

    'pdo.soiree_repository' => function (ContainerInterface $c) {
        return new PDOSoiree($c->get('database.pdo_connection'));
    },

    'pdo.theme_repository' => function (ContainerInterface $c) {
        return new PDOTheme($c->get('database.pdo_connection'));
    },

    'pdo.lieu_repository' => function (ContainerInterface $c) {
        return new PDOLieu($c->get('database.pdo_connection'));
    },

    'pdo.user_repository' => function (ContainerInterface $c) {
        return new PDOUtilisateur($c->get('database.pdo_connection'));
    },

    'pdo.panier_repository' => function (ContainerInterface $c) {
        return new PDOPanier($c->get('database.pdo_connection'));
    },

    'pdo.billet_repository' => function (ContainerInterface $c) {
        return new PDOBillet($c->get('database.pdo_connection'));
    },

    // Repository Interfaces
    'repository.spectacle_service' => function (ContainerInterface $c) {
        return new serviceSpectacle($c->get('pdo.spectacle_repository'));
    },

    'repository.soiree_service' => function (ContainerInterface $c) {
        return new serviceSoirees($c->get('pdo.soiree_repository'));
    },

    'repository.theme_service' => function (ContainerInterface $c) {
        return new serviceThemes($c->get('pdo.theme_repository'));
    },

    'repository.lieu_service' => function (ContainerInterface $c) {
        return new serviceLieux($c->get('pdo.lieu_repository'));
    },

    'repository.user_interface' => function (ContainerInterface $c) {
        return $c->get('pdo.user_repository');
    },

    'repository.panier_interface' => function (ContainerInterface $c) {
        return $c->get('pdo.panier_repository');
    },

    'repository.billet_interface' => function (ContainerInterface $c) {
        return $c->get('pdo.billet_repository');
    },

    // Services
    'service.user_instance' => function (ContainerInterface $c) {
        return new serviceUtilisateur($c->get('repository.user_interface'));
    },

    'service.panier_instance' => function (ContainerInterface $c) {
        return new servicePanier($c->get('repository.panier_interface'), $c->get('repository.billet_interface'));
    },

    'provider.jwt_auth_instance' => function (ContainerInterface $c) {
        return new JWTAuthnProvider($c->get('repository.user_interface'));
    },

    // Actions
    'action.get_spectacles_instance' => function (ContainerInterface $c) {
        return new GetSpectaclesAction($c->get('repository.spectacle_service'));
    },

    'action.get_soiree_instance' => function (ContainerInterface $c) {
        return new GetSoireeAction($c->get('repository.soiree_service'));
    },

    'action.get_themes_instance' => function (ContainerInterface $c) {
        return new GetThemesAction($c->get('repository.theme_service'));
    },

    'action.get_lieux_instance' => function (ContainerInterface $c) {
        return new GetLieuxAction($c->get('repository.lieu_service'));
    },

    'action.post_create_user_instance' => function (ContainerInterface $c) {
        return new PostCreateUserAction($c->get('service.user_instance'));
    },

    'action.post_signin_instance' => function (ContainerInterface $c) {
        return new PostSigninAction($c->get('repository.user_interface'));
    },

    'action.get_ticket_by_user_instance' => function (ContainerInterface $c) {
        return new GetTicketByUserAction($c->get('service.user_instance'));
    },

    'action.get_panier_instance' => function (ContainerInterface $c) {
        return new GetPanierAction($c->get('service.panier_instance'));
    },

    'action.get_add_billet_panier_instance' => function (ContainerInterface $c) {
        return new GetAddBilletPanierAction($c->get('service.panier_instance'));
    },

    'action.post_validate_panier_instance' => function (ContainerInterface $c) {
        return new PostValidatePanierAction($c->get('service.panier_instance'));
    },

    'action.get_nb_places_vendues_instance' => function (ContainerInterface $c) {
        return new GetnbPlacesVenduesAction($c->get('repository.soiree_service'));
    },

    'action.post_payer_panier_instance' => function (ContainerInterface $c) {
        return new PostPayerPanierAction($c->get('service.panier_instance'), $c->get('repository.soiree_service'));
    },

    'action.delete_item_instance' => function (ContainerInterface $c) {
        return new DeleteItemAction($c->get('service.panier_instance'));
    },
];
