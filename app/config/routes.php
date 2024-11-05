<?php
declare(strict_types=1);

use festival\application\action\DeleteItemAction;
use festival\application\action\GetAddBilletPanierAction;
use festival\application\action\GetLieuxAction;
use festival\application\action\GetnbPlacesVenduesAction;
use festival\application\action\GetPanierAction;
use festival\application\action\GetThemesAction;
use festival\application\action\GetTicketByUserAction;
use festival\application\action\HomeAction;
use festival\application\action\GetSoireeAction;
use festival\application\action\GetSpectaclesAction;
use festival\application\action\PostCreateUserAction;
use festival\application\action\PostPayerPanierAction;
use festival\application\action\PostSigninAction;
use festival\application\action\PostValidatePanierAction;
use festival\application\middlewares\AdminMiddleware;
use festival\application\middlewares\Cors;
use festival\application\middlewares\JWTAuthMiddleware;

return function (\Slim\App $app): \Slim\App {
    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    $app->get('/', HomeAction::class)->setName('home');

    // liste spectacles
    $app->get('/spectacles', GetSpectaclesAction::class)->setName('spectacles');

    //liste des themes
    $app->get('/themes', GetThemesAction::class)->setName('themes');

    // details d'un spectacle
    $app->get('/soirees/{id}', GetSoireeAction::class)->setName('spectacle');

    // liste des lieux
    $app->get('/lieux', GetLieuxAction::class)->setName('lieux');

    // create user
    $app->post('/users/signup', PostCreateUserAction::class)->setName('createUser');

    // signin
    $app->post('/users/signin', PostSigninAction::class)->setName('signin');

    $app->get('/soirees/Places/{id_soiree}', GetnbPlacesVenduesAction::class)->setName('nbPlacesVendues')
        ->add(AdminMiddleware::class)
        ->add(JWTAuthMiddleware::class);

    // liste des billets
    $app->get('/users/{id}/billets', GetTicketByUserAction::class)->setName('billets')
        ->add(JWTAuthMiddleware::class);

    // panier
    $app->get('/panier/{id_user}', GetPanierAction::class)->setName('panier')
        ->add(JWTAuthMiddleware::class);

    // ajout d'un billet au panier
    $app->post('/panier/{id_user}/ajouter', GetAddBilletPanierAction::class)->setName('ajouterBilletAuPanier')
        ->add(JWTAuthMiddleware::class);

    $app->post('/panier/{id_user}/valider', PostValidatePanierAction::class)->setName('validerPanier')
        ->add(JWTAuthMiddleware::class);

    $app->post('/panier/{id_user}/payer', PostPayerPanierAction::class)->setName('payerPanier')
        ->add(JWTAuthMiddleware::class);

    $app->delete('/panier/{id_user}/{item}', DeleteItemAction::class)->setName('deletePanier')
        ->add(JWTAuthMiddleware::class);

    return $app;
};