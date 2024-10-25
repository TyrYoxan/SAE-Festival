<?php
declare(strict_types=1);

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
use festival\application\middlewares\Cors;
use festival\application\middlewares\JWTAuthMiddleware;

return function (\Slim\App $app): \Slim\App {
    $app->add(new Cors());

    $app->get('/', HomeAction::class)->setName('home');

    // liste spectacles
    $app->get('/spectacles', GetSpectaclesAction::class)->setName('spectacles');

    //liste des themes
    $app->get('/soirees/themes', GetThemesAction::class)->setName('themes');

    // details d'un spectacle
    $app->get('/soirees/{id}', GetSoireeAction::class)->setName('spectacle');

    // liste des lieux
    $app->get('/lieux', GetLieuxAction::class)->setName('lieux');

    // create user
    $app->post('/users/create', PostCreateUserAction::class)->setName('createUser');

    // signin
    $app->post('/users/signin', PostSigninAction::class)->setName('signin');

    $app->get('/soirees/nbPlacesVendues/{id_soiree}', GetnbPlacesVenduesAction::class)->setName('nbPlacesVendues');

    $app->add(new JWTAuthMiddleware());

    // liste des billets
    $app->get('/users/{id}/billets', GetTicketByUserAction::class)->setName('billets');

    // panier
    $app->get('/panier/{id_user}', GetPanierAction::class)->setName('panier');


    // ajout d'un billet au panier
    $app->post('/panier/{id_user}/ajouter', GetAddBilletPanierAction::class)->setName('ajouterBilletAuPanier');


    $app->post('/panier/{id_user}/valider', PostValidatePanierAction::class)->setName('validerPanier');


    $app->post('/panier/{id_user}/payer', PostPayerPanierAction::class)->setName('payerPanier');




    return $app;
};